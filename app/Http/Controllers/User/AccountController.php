<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function signUp()
    {
        return view('user.signup');
    }

    public function signIn()
    {
        return view('user.login');
    }

    public function validateAccount(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        $account = DB::table('accounts')
            ->where('email', $validated['email'])
            ->first();

        if (!$account || !Hash::check($validated['password'], $account->password)) {
            return back()->withInput()->with('auth_error', 'Email atau password salah.');
        }

        if ((int) $account->status !== 1) {
            return back()->withInput()->with('auth_error', 'Akun kamu belum aktif.');
        }

        $request->session()->put('account_id', $account->id);
        $request->session()->regenerate();

        return redirect('my')->with('status', 'Login berhasil.');
    }

    public function createAccount(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', 'unique:accounts,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        DB::table('accounts')->insert([
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('status', 'Akun berhasil dibuat.');
    }
}
