<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login')->with('loginError', 'Gagal melakukan autentikasi Google.');
        }

        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            return redirect('/login')->with('loginError', 'Akun dengan email Google ini belum terdaftar. Silakan registrasi terlebih dahulu.');
        }

        Auth::login($user);

        return match ((int)$user->role) {
            1 => redirect()->intended(route('dashboard.index')),
            2 => redirect()->intended(route('dosen.dashboard')),
            3 => redirect()->intended(route('mahasiswa.dashboard')),
            default => redirect('/'),
        };
    }
}
