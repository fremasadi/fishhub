<?php

namespace App\Http\Controllers\Peternak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StokBenih;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StokBenihController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user->peternak) {
            return redirect()->route('dashboard')
                ->with('error', 'Akun Anda belum terdaftar sebagai peternak.');
        }

        $peternakId = $user->peternak->id;

        $benih = StokBenih::where('peternak_id', $peternakId)->paginate(10);

        return view('peternak.benih.index', compact('benih'));
    }


    public function create()
    {
        return view('peternak.benih.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'jenis'   => 'required|string|max:255',
            'jumlah'  => 'required|integer|min:1',
            'ukuran'  => 'required|string',
            'kualitas'=> 'required|string',
            'harga'   => 'required|integer|min:100',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload image jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('benih', 'public');
        }

        StokBenih::create([
            'peternak_id'     => Auth::user()->peternak->id,
            'jenis'           => $request->jenis,
            'jumlah'          => $request->jumlah,
            'ukuran'          => $request->ukuran,
            'kualitas'        => $request->kualitas,
            'harga'           => $request->harga,
            'image'           => $imagePath,
            'tanggal_input'   => now(),
            'status_validasi' => 'Menunggu',
            'status_stok'     => $request->jumlah > 0 ? 'Tersedia' : 'Habis',
        ]);

        return redirect()->route('benih.index')->with('success', 'Stok benih berhasil ditambahkan.');
    }


    public function edit(StokBenih $benih)
    {
        return view('peternak.benih.edit', compact('benih'));
    }


    public function update(Request $request, StokBenih $benih)
    {
        $request->validate([
            'jenis'   => 'required|string|max:255',
            'jumlah'  => 'required|integer|min:1',
            'ukuran'  => 'required|string',
            'kualitas'=> 'required|string',
            'harga'   => 'required|integer|min:100',
            'image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload gambar baru jika ada
        if ($request->hasFile('image')) {

            // Hapus gambar lama jika ada
            if ($benih->image && Storage::disk('public')->exists($benih->image)) {
                Storage::disk('public')->delete($benih->image);
            }

            // Upload baru
            $benih->image = $request->file('image')->store('benih', 'public');
        }

        $benih->update([
            'jenis'       => $request->jenis,
            'jumlah'      => $request->jumlah,
            'ukuran'      => $request->ukuran,
            'kualitas'    => $request->kualitas,
            'harga'       => $request->harga,
            'status_stok' => $request->jumlah > 0 ? 'Tersedia' : 'Habis',
        ]);

        return redirect()->route('benih.index')->with('success', 'Data berhasil diperbarui.');
    }


    public function destroy(StokBenih $benih)
    {
        // Hapus file image juga
        if ($benih->image && Storage::disk('public')->exists($benih->image)) {
            Storage::disk('public')->delete($benih->image);
        }

        $benih->delete();

        return redirect()->route('benih.index')->with('success', 'Data berhasil dihapus.');
    }
}
