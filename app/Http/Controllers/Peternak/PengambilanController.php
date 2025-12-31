<?php

namespace App\Http\Controllers\Peternak;

use App\Http\Controllers\Controller;
use App\Models\Pengambilan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PengambilanController extends Controller
{
    /**
     * List pengambilan milik peternak
     */
    public function index()
    {
        $peternak = Auth::user()->peternak;

        if (!$peternak) {
            abort(403, 'Peternak tidak ditemukan');
        }

        Log::info('Peternak Debug', [
            'user_id' => Auth::id(),
            'peternak_id' => $peternak->id,
        ]);

        $pengambilans = Pengambilan::with(['pesanan.pembudidaya', 'pesanan.details.stokBenih'])
            ->where('peternak_id', $peternak->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('peternak.pengambilan.index', compact('pengambilans'));
    }

    /**
     * Detail pengambilan
     */
    public function show(Pengambilan $pengambilan)
    {
        $peternak = Auth::user()->peternak;

        // if (!$peternak) {
        //     abort(403, 'Peternak tidak ditemukan');
        // }

        // if ($pengambilan->peternak_id !== $peternak->id) {
        //     abort(403, 'Bukan pengambilan milik Anda');
        // }

        return view('peternak.pengambilan.show', compact('pengambilan'));
    }

    /**
     * Tandai siap diambil
     */
    public function markReady(Pengambilan $pengambilan)
    {
        $peternak = Auth::user()->peternak;

        // if (!$peternak) {
        //     abort(403, 'Peternak tidak ditemukan');
        // }

        // if ($pengambilan->peternak_id !== $peternak->id) {
        //     abort(403, 'Bukan pengambilan milik Anda');
        // }
        $pengambilan->update([
            'status_pengambilan' => 'Siap Diambil',
        ]);

        return back()->with('success', 'Pengambilan ditandai siap diambil');
    }

    /**
     * Konfirmasi barang telah diambil (serah terima)
     */
    public function confirm(Request $request, Pengambilan $pengambilan)
    {
        $peternak = Auth::user()->peternak;

        // if (!$peternak) {
        //     abort(403, 'Peternak tidak ditemukan');
        // }

        // if ($pengambilan->peternak_id !== $peternak->id) {
        //     abort(403, 'Bukan pengambilan milik Anda');
        // }

        $request->validate([
            'bukti_serah' => 'nullable|image|max:2048',
            'catatan' => 'nullable|string',
        ]);

        $data = [
            'status_pengambilan' => 'Diterima',
            'tanggal_pengambilan' => now(),
            'catatan' => $request->catatan,
        ];

        if ($request->hasFile('bukti_serah')) {
            $data['bukti_serah'] = $request->file('bukti_serah')->store('bukti-serah', 'public');
        }

        $pengambilan->update($data);

        return redirect()->route('peternak.pengambilan.index')->with('success', 'Pengambilan berhasil diselesaikan');
    }
}
