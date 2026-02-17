<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembudidaya;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PembudidayaController extends Controller
{
    public function index()
    {
        $pembudidayas = Pembudidaya::with('user')->latest()->paginate(10);
        return view('admin.pembudidaya.index', compact('pembudidayas'));
    }

    public function create()
    {
        return view('admin.pembudidaya.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'pembudidaya',
            ]);

            Pembudidaya::create([
                'user_id' => $user->id,
                'no_hp' => $validated['no_hp'],
                'alamat' => $validated['alamat'],
            ]);

            DB::commit();
            return redirect()->route('pembudidayas.index')
                ->with('success', 'Pembudidaya berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Pembudidaya $pembudidaya)
    {
        $pembudidaya->load('user');
        return view('admin.pembudidaya.show', compact('pembudidaya'));
    }

    public function edit(Pembudidaya $pembudidaya)
    {
        $pembudidaya->load('user');
        return view('admin.pembudidaya.edit', compact('pembudidaya'));
    }

    public function update(Request $request, Pembudidaya $pembudidaya)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $pembudidaya->user_id,
            'password' => 'nullable|min:8|confirmed',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];

            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $pembudidaya->user->update($userData);

            $pembudidaya->update([
                'no_hp' => $validated['no_hp'],
                'alamat' => $validated['alamat'],
            ]);

            DB::commit();
            return redirect()->route('pembudidayas.index')
                ->with('success', 'Pembudidaya berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Pembudidaya $pembudidaya)
    {
        DB::beginTransaction();
        try {
            $user = $pembudidaya->user;
            $pembudidaya->delete();
            $user->delete();

            DB::commit();
            return redirect()->route('pembudidayas.index')
                ->with('success', 'Pembudidaya berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
