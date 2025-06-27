<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLoginForm()
    {
        return view('auth.loginPage');
    }

    // Menampilkan halaman register
    public function showRegisterForm()
    {
        return view('auth.registerPage');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');
        
        // Cek apakah input adalah email atau username
        $loginField = filter_var($credentials['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'name';
        
        // Cari user berdasarkan email atau username
        $user = User::where($loginField, $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            // Login berhasil - set session
            session([
                'user_id' => $user->user_id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ]);

            return redirect()->route('daftarKegiatan')->with('success', 'Login berhasil!');
        }

        return redirect()->back()
            ->withErrors(['email' => 'Email/Username atau password salah.'])
            ->withInput();
    }

    // Proses register
    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Buat user baru
            $user = User::create([
                'user_id' => Str::uuid(),
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'mahasiswa', 
            ]);

            // Auto login setelah register
            session([
                'user_id' => $user->user_id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ]);

            return redirect()->route('daftarKegiatan')->with('success', 'Registrasi berhasil!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => 'Terjadi kesalahan saat registrasi.'])
                ->withInput();
        }
    }

    // Proses logout
    public function logout()
    {
        session()->flush();
        return redirect('/')->with('success', 'Logout berhasil!');
    }

}