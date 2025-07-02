<?php

// ======================================
// Admin AuthController.php
// ======================================

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
{
    $credentials = $request->only('username', 'password');

    // Paksa logout user jika masih login
    Auth::guard('web')->logout();

    if (Auth::guard('admin')->attempt($credentials)) {
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dashboard'));
    }

    return back()->with('error', 'Invalid credentials');
}


    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
