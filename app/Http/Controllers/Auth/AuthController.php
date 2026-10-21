<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    /**
     * Tampilkan form login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Proses login user
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            switch ($user->role) {
                case 1:
                    return redirect()->intended(route('dashboard.index')); // Admin
                case 2:
                    return redirect()->intended(route('dosen.dashboard')); // Dosen
                case 3:
                    return redirect()->intended(route('mahasiswa.dashboard')); // Mahasiswa
                default:
                    return redirect('/')->with('warn', 'Role tidak dikenali.');
            }
        }

        return back()->with('loginError', 'Email atau password salah!');
    }

    /**
     * Logout
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    /**
     * Tampilkan form registrasi mahasiswa
     */
    public function showMahasiswaRegistrationForm()
    {
        return view('auth.register_mahasiswa');
    }

    /**
     * Tampilkan form registrasi dosen
     */
    public function showDosenRegistrationForm()
    {
        return view('auth.register_dosen');
    }

    /**
     * Proses registrasi mahasiswa
     */
    public function registerMahasiswa(Request $request)
    {
        $request->validate([
            'nim' => 'required|string|size:10|unique:mahasiswas,id_nim|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'nama' => 'required|string|max:255',
            'program_studi' => 'required|string|max:100',
            'angkatan' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'username' => $request->nim,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 3,
            ]);

            Mahasiswa::create([
                'id_nim' => $request->nim,
                'id_user' => $user->id_user,
                'nama' => $request->nama,
                'program_studi' => $request->program_studi,
                'angkatan' => $request->angkatan,
            ]);
        });

        return redirect('/login')->with('success', 'Registrasi berhasil sebagai mahasiswa. Silakan login.');
    }

    /**
     * Proses registrasi dosen
     */
    public function registerDosen(Request $request)
    {
        $request->validate([
            'nidn' => 'required|string|size:10|unique:dosens,id_nidn|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:100',
            'fakultas' => 'required|string|max:100',
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'username' => $request->nidn,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 2,
            ]);

            Dosen::create([
                'id_nidn' => $request->nidn,
                'id_user' => $user->id_user,
                'nama' => $request->nama,
                'jabatan' => $request->jabatan,
                'fakultas' => $request->fakultas,
            ]);
        });

        return redirect('/login')->with('success', 'Registrasi berhasil sebagai dosen. Silakan login.');
    }
}
