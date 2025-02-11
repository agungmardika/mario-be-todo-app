<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class AuthController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function showLoginForm()
    {
        return view('auth.login'); // View halaman login
    }

    /**
     * Proses login pengguna.
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Validasi kredensial pengguna
        if (Auth::attempt($credentials)) {
            // Ambil pengguna yang sudah terautentikasi
            $user = Auth::user();

            try {
                // Buat token JWT untuk pengguna
                $token = JWTAuth::fromUser($user);
                return response()->json([
                    'success' => true,
                    'token' => $token
                ]);
            } catch (JWTException $e) {
                return response()->json(['error' => 'Failed to create token'], 500);
            }
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }


    public function me()
    {
        return response()->json(auth()->user());
    }



    /**
     * Proses logout pengguna.
     */
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Successfully logged out']);
    }
}
