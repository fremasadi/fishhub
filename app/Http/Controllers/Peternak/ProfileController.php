<?php

namespace App\Http\Controllers\Peternak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Tampilkan form edit profile
     */
    public function edit()
    {
        $user = Auth::user();
        $peternak = $user->peternak;

        return view('peternak.profile.edit', compact('user', 'peternak'));
    }

    /**
     * Update profile peternak
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'no_hp'     => 'required',
            'alamat'    => 'required',
            'latitude'  => 'required',
            'longitude' => 'required',
        ]);

        DB::beginTransaction();

        try {
            // UPDATE USER
            $user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);

            // UPDATE PETERNak
            $user->peternak->update([
                'no_hp'     => $request->no_hp,
                'alamat'    => $request->alamat,
                'latitude'  => $request->latitude,
                'longitude' => $request->longitude,
            ]);

            DB::commit();

            return redirect()
                ->back()
                ->with('success', 'Profil berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui profil');
        }
    }
}