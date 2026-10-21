<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $adminCount = User::where('role', 1)->count();
        $dosenCount = User::where('role', 2)->count();
        $mahasiswaCount = User::where('role', 3)->count();

        return view('admin.dashboard', [
            'title' => 'Kelompok 32',
            'statistik_pengguna' => [
                'total' => $totalUsers,
                'admin' => $adminCount,
                'dosen' => $dosenCount,
                'mahasiswa' => $mahasiswaCount,
            ],
        ]);
    }
}
