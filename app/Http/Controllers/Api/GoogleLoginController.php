<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Http;

class GoogleLoginController extends Controller
{
    public function handle(Request $request)
    {
        $request->validate(['token' => 'required|string']);

        $googleResponse = Http::get('https://oauth2.googleapis.com/tokeninfo', [
            'id_token' => $request->token,
        ]);

        if (!$googleResponse->ok()) {
            return response()->json(['message' => 'Token tidak valid'], 401);
        }

        $data = $googleResponse->json();
        $user = User::firstOrCreate(
            ['email' => $data['email']],
            ['name' => $data['name'], 'password' => bcrypt(uniqid())]
        );

        $token = $user->createToken('mobile_app')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }
}
