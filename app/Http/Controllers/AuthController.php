<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class AuthController extends Controller
{
    // Login
    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    // Register
    public function showRegisterForm() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('verification.notice');
    }

    // Email verification
    public function showEmailVerificationNotice() {
        return view('auth.verify-email');
    }

    public function verifyEmail(EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/')->with('success', 'Email berhasil diverifikasi.');
    }

    public function resendVerificationEmail(Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'Email verifikasi telah dikirim ulang!');
    }

    // Forgot & Reset Password
    public function showForgotPasswordForm() {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request) {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm($token) {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => Hash::make($password)])->save();
                Auth::login($user);
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect('/login')->with('success', 'Password berhasil direset!')
            : back()->withErrors(['email' => [__($status)]]);
    }
}
