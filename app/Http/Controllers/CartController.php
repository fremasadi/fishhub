<?php

namespace App\Http\Controllers;

use App\Models\StokBenih;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    const MIN_ORDER = 100;

    public function add(Request $request)
    {
        try {
            $request->validate([
                'stok_benih_id' => 'required|exists:stok_benihs,id',
                'peternak_id' => 'required|exists:peternaks,id',
                'jumlah' => 'required|integer|min:' . self::MIN_ORDER
            ]);

            // Ambil stok berdasarkan ID baru
            $stokBenih = StokBenih::with('peternak.user')->findOrFail($request->stok_benih_id);

            if ($request->jumlah < self::MIN_ORDER) {
                return redirect()->back()->with('error', 'Minimal pemesanan adalah ' . self::MIN_ORDER . ' ekor!');
            }

            if ($stokBenih->jumlah < $request->jumlah) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi! Tersedia: ' . number_format($stokBenih->jumlah) . ' ekor');
            }

            if ($stokBenih->status_stok !== 'Tersedia') {
                return redirect()->back()->with('error', 'Stok ini sedang tidak tersedia');
            }

            $cart = Session::get('cart', []);

            // Validasi single vendor
            if (!empty($cart)) {
                $firstItem = reset($cart);
                if ($firstItem['peternak_id'] != $request->peternak_id) {
                    Session::forget('cart');
                    $cart = [];

                    session()->flash('warning',
                        'Keranjang dikosongkan karena Anda menambahkan item dari peternak berbeda. 
                        Peternak sebelumnya: <strong>' . $firstItem['peternak_name'] .
                        '</strong>, sekarang: <strong>' . $stokBenih->peternak->user->name . '</strong>.'
                    );
                }
            }

            // KEY cart berdasarkan stok_benih id
            $itemKey = $request->stok_benih_id;

            if (isset($cart[$itemKey])) {
                $newJumlah = $cart[$itemKey]['jumlah'] + $request->jumlah;

                if ($newJumlah > $stokBenih->jumlah) {
                    return redirect()->back()->with('error', 'Total pesanan melebihi stok yang tersedia!');
                }

                $cart[$itemKey]['jumlah'] = $newJumlah;
                $cart[$itemKey]['subtotal'] = $newJumlah * $stokBenih->harga;

                $message = 'Berhasil menambah ' . number_format($request->jumlah) . ' ekor ' . $stokBenih->jenis .
                    '. Total: ' . number_format($newJumlah) . ' ekor.';
            } else {
                $cart[$itemKey] = [
                    'stok_benih_id' => $stokBenih->id,
                    'peternak_id' => $request->peternak_id,
                    'peternak_name' => $stokBenih->peternak->user->name,
                    'jenis' => $stokBenih->jenis,
                    'ukuran' => $stokBenih->ukuran,
                    'kualitas' => $stokBenih->kualitas,
                    'image' => $stokBenih->image,
                    'harga' => $stokBenih->harga,
                    'jumlah' => $request->jumlah,
                    'stok_tersedia' => $stokBenih->jumlah,
                    'subtotal' => $request->jumlah * $stokBenih->harga
                ];

                $message = 'Berhasil menambahkan ' . number_format($request->jumlah) .
                    ' ekor ' . $stokBenih->jenis . ' ke keranjang!';
            }

            Session::put('cart', $cart);

            return redirect()->route('cart.index')->with('success', $message);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->with('error', 'Validasi gagal: ' . implode(', ', $e->validator->errors()->all()));
        } catch (\Exception $e) {
            \Log::error('Cart add error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $cart = Session::get('cart', []);

        $total = !empty($cart)
            ? array_sum(array_column($cart, 'subtotal'))
            : 0;

        $peternakName = !empty($cart)
            ? reset($cart)['peternak_name']
            : null;

        return view('front.cart.index', compact('cart', 'total', 'peternakName'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:' . self::MIN_ORDER
        ]);

        $cart = Session::get('cart', []);

        if (!isset($cart[$id])) {
            return response()->json(['success' => false, 'message' => 'Item tidak ditemukan'], 404);
        }

        if ($request->jumlah < self::MIN_ORDER) {
            return response()->json(['success' => false, 'message' => 'Minimal order 100 ekor'], 400);
        }

        if ($cart[$id]['stok_tersedia'] < $request->jumlah) {
            return response()->json([
                'success' => false,
                'message' => 'Stok tidak mencukupi! Tersedia ' . number_format($cart[$id]['stok_tersedia'])
            ], 400);
        }

        $cart[$id]['jumlah'] = $request->jumlah;
        $cart[$id]['subtotal'] = $request->jumlah * $cart[$id]['harga'];

        Session::put('cart', $cart);

        return response()->json([
            'success' => true,
            'subtotal' => $cart[$id]['subtotal'],
            'total' => array_sum(array_column($cart, 'subtotal'))
        ]);
    }

    public function destroy($id)
    {
        $cart = Session::get('cart', []);

        if (!isset($cart[$id])) {
            return response()->json(['success' => false, 'message' => 'Item tidak ditemukan'], 404);
        }

        unset($cart[$id]);
        Session::put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Item dihapus',
            'cart_count' => count($cart)
        ]);
    }

    public function clear()
    {
        Session::forget('cart');

        return redirect()->route('cart.index')->with('success', 'Keranjang dikosongkan');
    }

    public function count()
    {
        return response()->json([
            'count' => count(Session::get('cart', []))
        ]);
    }
}
