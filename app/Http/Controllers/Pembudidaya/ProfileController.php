<?php

namespace App\Http\Controllers\Pembudidaya;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $pembudidaya = $user->pembudidaya;

        return view('front.profile.edit', compact('user', 'pembudidaya'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $user->id,
            'no_hp'  => 'required|string|max:20',
            'alamat' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            $user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);

            $user->pembudidaya->update([
                'no_hp'  => $request->no_hp,
                'alamat' => $request->alamat,
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

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Password berhasil diubah');
    }
}
