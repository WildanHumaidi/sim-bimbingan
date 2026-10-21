<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  int  $requiredRole
     */
    public function handle(Request $request, Closure $next, $requiredRole): Response
    {
        // Jika belum login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();
        $currentRole = (int) $user->role;

        // Konversi ke integer untuk memastikan
        $requiredRole = (int) $requiredRole;

        if ($currentRole !== $requiredRole) {
            switch ($currentRole) {
                case 1: // Admin
                    return redirect('/admin/dashboard')->with('error', 'Akses terbatas untuk admin.');
                case 2: // Dosen
                    return redirect('/dosen/dashboard')->with('error', 'Akses terbatas untuk dosen.');
                case 3: // Mahasiswa
                    return redirect('/mhs/dashboard')->with('error', 'Akses terbatas untuk mahasiswa.');
                default:
                    return redirect('/')->with('error', 'Role tidak dikenali. Akses ditolak.');
            }
        }

        return $next($request);
    }
}
