<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialiteUserController extends Controller // ← INI YANG HILANG!
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
{
    try {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            if (!$user->google_id) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'avatar' => $googleUser->getAvatar(),
                ]);
            }
        } else {
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'password' => bcrypt(Str::random(24)),
            ]);
        }

        Auth::login($user);
        return redirect()->route('home'); // atau route tujuan kamu

    } catch (\Exception $e) {
        dd($e->getMessage());

    }
}
}