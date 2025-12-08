<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peternak;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PeternakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $peternaks = Peternak::with('user')->latest()->paginate(10);
        return view('admin.peternaks.index', compact('peternaks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.peternaks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'status_aktif' => 'required|boolean',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        DB::beginTransaction();
        try {
            // Create user first
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            // Create peternak
            Peternak::create([
                'user_id' => $user->id,
                'alamat' => $validated['alamat'],
                'no_hp' => $validated['no_hp'],
                'status_aktif' => $validated['status_aktif'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
            ]);

            DB::commit();
            return redirect()->route('peternaks.index')
                ->with('success', 'Peternak berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Peternak $peternak)
    {
        $peternak->load('user');
        return view('admin.peternaks.show', compact('peternak'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peternak $peternak)
    {
        $peternak->load('user');
        return view('admin.peternaks.edit', compact('peternak'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peternak $peternak)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $peternak->user_id,
            'password' => 'nullable|min:8|confirmed',
            'alamat' => 'required|string',
            'no_hp' => 'required|string|max:20',
            'status_aktif' => 'required|boolean',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        DB::beginTransaction();
        try {
            // Update user
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];

            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $peternak->user->update($userData);

            // Update peternak
            $peternak->update([
                'alamat' => $validated['alamat'],
                'no_hp' => $validated['no_hp'],
                'status_aktif' => $validated['status_aktif'],
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude'],
            ]);

            DB::commit();
            return redirect()->route('peternaks.index')
                ->with('success', 'Peternak berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peternak $peternak)
    {
        DB::beginTransaction();
        try {
            $user = $peternak->user;
            $peternak->delete();
            $user->delete();

            DB::commit();
            return redirect()->route('peternaks.index')
                ->with('success', 'Peternak berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}