<?php

namespace App\Http\Controllers\Mhs;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardMhsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user->mahasiswa) {
            abort(403, 'Anda tidak memiliki akses sebagai mahasiswa.');
        }

        $nim = $user->mahasiswa->id_nim;

        // Statistik utama
        $stats = [
            'total' => Bimbingan::where('nim', $nim)->count(),
            'bulan_ini' => Bimbingan::where('nim', $nim)
                ->whereMonth('tanggal', Carbon::now()->month)
                ->whereYear('tanggal', Carbon::now()->year)
                ->count(),
            'valid' => Bimbingan::where('nim', $nim)
                ->where('status_validasi', 'valid')
                ->count(),
            'pending' => Bimbingan::where('nim', $nim)
                ->where('status_validasi', 'pending')
                ->count(),
            'invalid' => Bimbingan::where('nim', $nim)
                ->where('status_validasi', 'invalid')
                ->count(),
        ];

        // Data untuk chart bulanan (12 bulan terakhir)
        $bimbinganPerBulan = $this->getMonthlyStats($nim);

        // 5 bimbingan terbaru
        $recentBimbingan = Bimbingan::where('nim', $nim)
            ->with(['dosen' => function($query) {
                $query->select('id_nidn', 'nama');
            }])
            ->orderByDesc('tanggal')
            ->take(5)
            ->get();

        return view('mhs.dashboard', [
            'title' => 'Dashboard Mahasiswa',
            'statistik' => $stats,
            'bimbinganPerBulan' => $bimbinganPerBulan,
            'recentBimbingan' => $recentBimbingan,
            'chartData' => [
                'labels' => ['Valid', 'Pending', 'Invalid'],
                'data' => [$stats['valid'], $stats['pending'], $stats['invalid']]
            ]
        ]);
    }

    protected function getMonthlyStats($nim)
    {
        $stats = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);

            $total = Bimbingan::where('nim', $nim)
                ->whereMonth('tanggal', $month->month)
                ->whereYear('tanggal', $month->year)
                ->count();

            $valid = Bimbingan::where('nim', $nim)
                ->whereMonth('tanggal', $month->month)
                ->whereYear('tanggal', $month->year)
                ->where('status_validasi', 'valid')
                ->count();

            $stats[] = [
                'month' => $month->format('M Y'),
                'month_short' => $month->format('M'),
                'total' => $total,
                'valid' => $valid,
                'progress' => $total > 0 ? round(($valid / $total) * 100) : 0
            ];
        }

        return $stats;
    }

    public function getBimbinganByStatus($status)
    {
        $user = Auth::user();
        $nim = $user->mahasiswa->id_nim;

        $query = Bimbingan::where('nim', $nim)
            ->with(['dosen' => function($query) {
                $query->select('id_nidn', 'nama');
            }]);

        // Filter berdasarkan status validasi
        if (in_array($status, ['valid', 'pending', 'invalid'])) {
            $query->where('status_validasi', $status);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Status tidak valid'
            ], 400);
        }

        $bimbingan = $query->orderByDesc('tanggal')->get();

        return response()->json([
            'success' => true,
            'data' => $bimbingan->map(function ($item) {
                return [
                    'id' => $item->id_bimbingan,
                    'dosen' => $item->dosen->nama,
                    'tanggal' => $item->tanggal->format('d M Y'),
                    'status' => $item->status_validasi,
                    'topik' => $item->topik
                ];
            })
        ]);
    }
}
