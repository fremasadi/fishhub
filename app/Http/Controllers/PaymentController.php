<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Pembayaran;
use App\Models\StokBenih;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Pengambilan;

class PaymentController extends Controller
{
    protected $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }

    /**
     * Process checkout dari cart
     */
    public function processCheckout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong!');
        }

        DB::beginTransaction();
        try {
            // Get peternak_id dan stok_id dari cart
            $firstItem = reset($cart);
            $peternakId = $firstItem['peternak_id'];

            // stok_id bisa dari key atau dari value
            // Cek struktur cart: apakah key adalah stok_id atau ada field tersendiri
            $firstKey = array_key_first($cart);
            $stokId = is_numeric($firstKey) ? $firstKey : $firstItem['stok_id'] ?? ($firstItem['stok_benih_id'] ?? null);

            // Calculate total
            $totalHarga = array_sum(array_column($cart, 'subtotal'));

            // Create Pesanan
            $pesanan = Pesanan::create([
                'pembudidaya_id' => Auth::id(),
                'peternak_id' => $peternakId,
                'stok_id' => $stokId,
                'tanggal_pesan' => now(),
                'total_harga' => $totalHarga,
                'status_pesanan' => 'Menunggu',
            ]);

            // Create Detail Pesanan untuk setiap item
            foreach ($cart as $cartKey => $item) {
                // stok_id bisa dari key atau dari item
                $itemStokId = is_numeric($cartKey) ? $cartKey : $item['stok_id'] ?? ($item['stok_benih_id'] ?? null);

                if (!$itemStokId) {
                    throw new \Exception('Stok ID tidak ditemukan untuk item: ' . json_encode($item));
                }

                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'stok_id' => $itemStokId,
                    'qty' => $item['jumlah'],
                    'harga_satuan' => $item['harga'],
                ]);
            }

            // Generate Order ID
            $orderId = 'BENIH-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 8));

            // Customer Details
            $customerDetails = [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->no_telepon ?? '08123456789',
            ];

            // Item Details untuk Midtrans
            $itemDetails = [];
            foreach ($cart as $cartKey => $item) {
                $itemStokId = is_numeric($cartKey) ? $cartKey : $item['stok_id'] ?? ($item['stok_benih_id'] ?? null);

                $itemDetails[] = [
                    'id' => $itemStokId,
                    'price' => (int) $item['harga'],
                    'quantity' => (int) $item['jumlah'],
                    'name' => 'Benih ' . $item['jenis'] . ' (' . $item['ukuran'] . ') - ' . $item['kualitas'],
                ];
            }

            // Create transaction via Midtrans Service
            $result = $this->midtrans->createTransaction($orderId, (int) $totalHarga, $customerDetails, $itemDetails);

            if (!$result['success']) {
                DB::rollBack();
                return back()->with('error', 'Gagal membuat pembayaran: ' . ($result['message'] ?? 'Unknown error'));
            }

            // Create Pembayaran record
            $pembayaran = Pembayaran::create([
                'transaksi_id' => $pesanan->id,
                'order_id' => $orderId,
                'gross_amount' => $totalHarga,
                'transaction_status' => 'pending',
                'payment_url' => $result['snap_token'],
                'midtrans_response' => json_encode($result),
            ]);

            DB::commit();

            // Clear cart
            session()->forget('cart');

            // Redirect ke halaman payment
            return redirect()->route('payment.show', $pesanan->id)->with('success', 'Pesanan berhasil dibuat! Silakan lanjutkan pembayaran.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment Checkout Error: ' . $e->getMessage(), [
                'cart_structure' => $cart,
                'trace' => $e->getTraceAsString(),
            ]);

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Show payment page
     */
    public function show(Pesanan $pesanan)
    {
        $pembayaran = $pesanan->pembayaran;

        if (!$pembayaran) {
            return redirect()->route('cart.index')->with('error', 'Data pembayaran tidak ditemukan');
        }

        // Ambil status terbaru dari Midtrans
        $statusResult = $this->midtrans->getTransactionStatus($pembayaran->order_id);

        if ($statusResult['success']) {
            $this->updatePaymentStatus($pembayaran, $statusResult['data']);
            $pembayaran->refresh();
        }

        // 🔽 FETCH DATA PENGAMBILAN
        $pengambilan = $pesanan->pengambilan;

        return view('front.payment.show', compact('pesanan', 'pembayaran', 'pengambilan'));
    }

    /**
     * Payment Finish
     */
    public function finish(Request $request)
    {
        $orderId = $request->order_id;
        $pembayaran = Pembayaran::where('order_id', $orderId)->first();

        if (!$pembayaran) {
            return redirect()->route('home')->with('error', 'Pembayaran tidak ditemukan');
        }

        $statusResult = $this->midtrans->getTransactionStatus($orderId);

        if ($statusResult['success']) {
            $this->updatePaymentStatus($pembayaran, $statusResult['data']);
        }

        return redirect()->route('payment.show', $pembayaran->transaksi_id);
    }

    /**
     * Handle Midtrans callback
     */
    public function callback(Request $request)
    {
        try {
            $serverKey = config('midtrans.server_key');
            $hashed = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

            if ($hashed !== $request->signature_key) {
                Log::warning('Invalid Midtrans signature', ['order_id' => $request->order_id]);
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            $pembayaran = Pembayaran::where('order_id', $request->order_id)->first();

            if (!$pembayaran) {
                Log::error('Payment not found for callback', ['order_id' => $request->order_id]);
                return response()->json(['message' => 'Payment not found'], 404);
            }

            $this->updatePaymentStatus($pembayaran, $request->all());

            return response()->json(['message' => 'Callback processed']);
        } catch (\Exception $e) {
            Log::error('Midtrans Callback Error: ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Check payment status (AJAX)
     */
    public function checkStatus(Pesanan $pesanan)
    {
        try {
            $pembayaran = $pesanan->pembayaran;

            if (!$pembayaran) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Data pembayaran tidak ditemukan',
                    ],
                    404,
                );
            }

            $statusResult = $this->midtrans->getTransactionStatus($pembayaran->order_id);

            if ($statusResult['success']) {
                $this->updatePaymentStatus($pembayaran, $statusResult['data']);
                $pembayaran->refresh();

                return response()->json([
                    'success' => true,
                    'status' => $pembayaran->transaction_status,
                    'message' => $pembayaran->getStatusLabel(),
                    'is_paid' => $pembayaran->isSuccess(),
                ]);
            }

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Gagal mengecek status',
                ],
                500,
            );
        } catch (\Exception $e) {
            Log::error('Error checking payment status: ' . $e->getMessage());

            return response()->json(
                [
                    'success' => false,
                    'message' => 'Terjadi kesalahan',
                ],
                500,
            );
        }
    }

    /**
     * Show user's order history
     */
    public function history()
    {
        $pesanans = Pesanan::with(['details.stokBenih', 'pembayaran', 'peternak.user', 'pengambilan'])
            ->where('pembudidaya_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('front.payment.history', compact('pesanans'));
    }

    /**
     * Update Payment Status
     */
    private function updatePaymentStatus($pembayaran, $data)
    {
        $transactionStatus = $data->transaction_status ?? ($data['transaction_status'] ?? 'pending');
        $fraudStatus = $data->fraud_status ?? ($data['fraud_status'] ?? null);
        $paymentType = $data->payment_type ?? ($data['payment_type'] ?? null);

        $updateData = [
            'transaction_id' => $data->transaction_id ?? ($data['transaction_id'] ?? null),
            'transaction_status' => $transactionStatus,
            'fraud_status' => $fraudStatus,
            'payment_type' => $paymentType,
            'midtrans_response' => is_array($data) ? $data : json_decode(json_encode($data), true),
        ];

        // Bank info for VA
        if (isset($data->va_numbers) || isset($data['va_numbers'])) {
            $vaNumbers = $data->va_numbers ?? $data['va_numbers'];
            if (!empty($vaNumbers)) {
                $vaNumber = is_array($vaNumbers) ? $vaNumbers[0] : $vaNumbers[0];
                $updateData['bank'] = $vaNumber->bank ?? ($vaNumber['bank'] ?? null);
                $updateData['va_number'] = $vaNumber->va_number ?? ($vaNumber['va_number'] ?? null);
            }
        }

        // Transaction time
        if (isset($data->transaction_time) || isset($data['transaction_time'])) {
            $updateData['transaction_time'] = $data->transaction_time ?? $data['transaction_time'];
        }

        // Settlement time & Update Pesanan Status
        if ($transactionStatus === 'settlement' || $transactionStatus === 'capture') {
            $updateData['settlement_time'] = now();

            $pesanan = $pembayaran->pesanan;
            $pesanan->update(['status_pesanan' => 'Dibayar']);

            Pengambilan::firstOrCreate(
                ['pesanan_id' => $pesanan->id],
                [
                    'pembudidaya_id' => $pesanan->pembudidaya_id,
                    'peternak_id' => $pesanan->peternak_id,
                    'status_pengambilan' => 'Menunggu',
                    'tanggal_pengambilan' => null,
                    'catatan' => 'Menunggu konfirmasi pengambilan',
                ],
            );

            // Update stok benih (kurangi)
            foreach ($pesanan->details as $detail) {
                $stok = $detail->stokBenih;
                if ($stok && $stok->jumlah >= $detail->qty) {
                    $stok->decrement('jumlah', $detail->qty);

                    // Update status stok jika habis
                    if ($stok->jumlah <= 0) {
                        $stok->update(['status_stok' => 'Habis']);
                    }
                }
            }

            Log::info('Payment successful', [
                'order_id' => $pembayaran->order_id,
                'pesanan_id' => $pesanan->id,
            ]);
        }

        // Jika pembayaran gagal
        if (in_array($transactionStatus, ['deny', 'expire', 'cancel', 'failure'])) {
            $pesanan = $pembayaran->pesanan;
            $pesanan->update(['status_pesanan' => 'Dibatalkan']);

            Log::info('Payment failed', [
                'order_id' => $pembayaran->order_id,
                'status' => $transactionStatus,
            ]);
        }

        $pembayaran->update($updateData);
    }
}
