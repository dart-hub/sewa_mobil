<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Menampilkan form login.
     */
    public function showLoginForm()
    {
        // Jika user sudah login, redirect ke dashboard yang sesuai
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('dashboard');
            }
        }
        
        return view('auth.login');
    }

    /**
     * Proses login.
     */
    public function login(Request $request)
    {
        // Jika user sudah login, redirect ke dashboard yang sesuai
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('dashboard');
            }
        }
        
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect berdasarkan role
            $user = Auth::user();
            if ($user->isAdmin()) {
                return redirect()->intended('/dashboard');
            } else {
                return redirect()->intended('/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    /**
     * Logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Menampilkan form registrasi.
     */
    public function showRegistrationForm()
    {
        // Jika user sudah login, redirect ke dashboard yang sesuai
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('dashboard');
            }
        }
        
        return view('auth.register');
    }

    /**
     * Proses registrasi.
     */
    public function register(Request $request)
    {
        // Jika user sudah login, redirect ke dashboard yang sesuai
        if (Auth::check()) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('dashboard');
            }
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'kasir', // Default role untuk user baru
            'password' => Hash::make($request->password),
        ]);

        // Alih-alih langsung login, arahkan ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
    }
    
    /**
     * Menampilkan dashboard.
     */
    public function dashboard()
    {
        return view('welcome');
    }
}