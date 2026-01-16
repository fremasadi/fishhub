<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Peternak;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:peternak,pembudidaya'],

            // WAJIB kalau peternak
            'no_hp' => ['required_if:role,peternak'],
            'alamat' => ['required_if:role,peternak'],
        ]);

        DB::beginTransaction();

        try {
            // 1. CREATE USER
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'password' => Hash::make($request->password),
            ]);

            // 2. JIKA PETERNak → CREATE TABEL PETERNak
            if ($request->role === 'peternak') {
                Peternak::create([
                    'user_id' => $user->id,
                    'no_hp' => $request->no_hp,
                    'alamat' => $request->alamat,
                    'status_aktif' => 1,
                ]);
            }

            DB::commit();

            event(new Registered($user));

            Auth::login($user);

            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Gagal registrasi: ' . $e->getMessage());
        }
    }
}
