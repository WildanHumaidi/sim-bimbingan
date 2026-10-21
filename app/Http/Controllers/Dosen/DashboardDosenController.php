<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use App\Models\Bimbingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardDosenController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Total semua bimbingan di sistem
        $totalBimbingan = Bimbingan::count();

        // Total bimbingan dosen berdasarkan NIDN
        $bimbinganDosen = Bimbingan::where('nidn', $user->dosen->id_nidn)->count();

        // Bimbingan bulan ini
        $bimbinganBulanIni = Bimbingan::where('nidn', $user->dosen->id_nidn)
            ->whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->count();

        // Bimbingan selesai (status valid)
        $bimbinganSelesai = Bimbingan::where('nidn', $user->dosen->id_nidn)
            ->where('status_validasi', 'valid')
            ->count();

        // Ambil bimbingan baru dalam 24 jam terakhir yang belum dibaca
        $bimbinganBaru = Bimbingan::where('nidn', $user->dosen->id_nidn)
            ->whereNull('dibaca_oleh_dosen')
            ->where('tanggal', '>=', Carbon::now()->subHours(24))
            ->with(['mahasiswa' => function ($query) {
                $query->select('id_nim', 'nama', 'id_user')
                    ->with(['user' => function ($userQuery) {
                        $userQuery->select('id_user', 'email');
                    }]);
            }])
            ->orderByDesc('tanggal')
            ->get();

        // Statistik bimbingan per bulan untuk chart (12 bulan terakhir)
        $bimbinganPerBulan = [];
        for ($i = 11; $i >= 0; $i--) {
            $bulan = Carbon::now()->subMonths($i);
            $totalBulan = Bimbingan::where('nidn', $user->dosen->id_nidn)
                ->whereMonth('tanggal', $bulan->month)
                ->whereYear('tanggal', $bulan->year)
                ->count();
            $selesaiBulan = Bimbingan::where('nidn', $user->dosen->id_nidn)
                ->whereMonth('tanggal', $bulan->month)
                ->whereYear('tanggal', $bulan->year)
                ->where('status_validasi', 'valid')
                ->count();

            $bimbinganPerBulan[] = [
                'bulan' => $bulan->format('M Y'),
                'bulan_short' => $bulan->format('M'),
                'total' => $totalBulan,
                'selesai' => $selesaiBulan,
                'progress' => $totalBulan > 0 ? round(($selesaiBulan / $totalBulan) * 100, 1) : 0
            ];
        }

        // Data untuk pie chart
        $bimbinganPending = Bimbingan::where('nidn', $user->dosen->id_nidn)
            ->where('status_validasi', 'pending')
            ->count();

        $bimbinganInvalid = Bimbingan::where('nidn', $user->dosen->id_nidn)
            ->where('status_validasi', 'invalid')
            ->count();

        $pieChartData = [
            'pending' => $bimbinganPending,
            'valid' => $bimbinganSelesai, // valid = selesai
            'invalid' => $bimbinganInvalid,
        ];

        // Bimbingan terbaru
        $recentBimbingan = Bimbingan::where('nidn', $user->dosen->id_nidn)
            ->with(['mahasiswa' => function ($query) {
                $query->select('id_nim', 'nama');
            }])
            ->orderByDesc('tanggal')
            ->take(5)
            ->get();

        // Hitung statistik status baca
        $totalBimbinganBelumDibaca = Bimbingan::where('nidn', $user->dosen->id_nidn)
            ->whereNull('dibaca_oleh_dosen')
            ->count();

        $totalBimbinganSudahDibaca = Bimbingan::where('nidn', $user->dosen->id_nidn)
            ->whereNotNull('dibaca_oleh_dosen')
            ->count();

        return view('dosen.dashboard', [
            'title' => 'Dashboard Dosen',
            'statistik_bimbingan' => [
                'total_semua' => $totalBimbingan,
                'total_dosen' => $bimbinganDosen,
                'bulan_ini' => $bimbinganBulanIni,
                'selesai' => $bimbinganSelesai,
                'belum_dibaca' => $totalBimbinganBelumDibaca,
                'sudah_dibaca' => $totalBimbinganSudahDibaca,
            ],
            'bimbinganBaru' => $bimbinganBaru,
            'bimbinganPerBulan' => $bimbinganPerBulan,
            'pieChartData' => $pieChartData,
            'recentBimbingan' => $recentBimbingan,
        ]);
    }

    public function tandaiSudahDibaca($id)
    {
        $bimbingan = Bimbingan::where('id_bimbingan', $id)->firstOrFail();

        if ($bimbingan->nidn !== Auth::user()->dosen->id_nidn) {
            abort(403, 'Anda tidak berhak menandai bimbingan ini.');
        }

        // Cek apakah sudah dibaca sebelumnya
        if ($bimbingan->dibaca_oleh_dosen) {
            return response()->json([
                'success' => false,
                'message' => 'Bimbingan ini sudah dibaca sebelumnya.',
                'status' => 'already_read'
            ]);
        }

        $bimbingan->dibaca_oleh_dosen = now();
        $bimbingan->save();

        return response()->json([
            'success' => true,
            'message' => 'Bimbingan berhasil ditandai sebagai sudah dibaca.',
            'status' => 'marked_as_read'
        ]);
    }

    public function checkNewBimbingan()
    {
        $user = Auth::user();
        $bimbinganBaru = Bimbingan::where('nidn', $user->dosen->id_nidn)
            ->whereNull('dibaca_oleh_dosen')
            ->where('tanggal', '>=', Carbon::now()->subHours(24))
            ->with(['mahasiswa' => function ($query) {
                $query->select('id_nim', 'nama', 'id_user')
                    ->with(['user' => function ($userQuery) {
                        $userQuery->select('id_user', 'email');
                    }]);
            }])
            ->orderByDesc('tanggal')
            ->get();

        return response()->json([
            'count' => $bimbinganBaru->count(),
            'hasNew' => $bimbinganBaru->count() > 0,
            'data' => $bimbinganBaru->map(function ($item) {
                return [
                    'id' => $item->id_bimbingan,
                    'mahasiswa_nama' => $item->mahasiswa->nama,
                    'tanggal' => $item->tanggal->format('d M Y, H:i'),
                    'created_at' => $item->tanggal->diffForHumans(),
                    'is_read' => !is_null($item->dibaca_oleh_dosen),
                    'read_at' => $item->dibaca_oleh_dosen ? $item->dibaca_oleh_dosen->format('d M Y, H:i') : null,
                ];
            })
        ]);
    }

    public function tandaiSemuaDibaca()
    {
        $user = Auth::user();

        // Hitung total bimbingan yang akan ditandai
        $totalBelumDibaca = Bimbingan::where('nidn', $user->dosen->id_nidn)
            ->whereNull('dibaca_oleh_dosen')
            ->count();

        if ($totalBelumDibaca === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Semua bimbingan sudah ditandai sebagai dibaca.',
                'status' => 'all_already_read'
            ]);
        }

        // Update semua bimbingan yang belum dibaca
        $updated = Bimbingan::where('nidn', $user->dosen->id_nidn)
            ->whereNull('dibaca_oleh_dosen')
            ->update(['dibaca_oleh_dosen' => now()]);

        return response()->json([
            'success' => true,
            'message' => "Berhasil menandai {$updated} bimbingan sebagai sudah dibaca.",
            'status' => 'all_marked_as_read',
            'updated_count' => $updated
        ]);
    }

    public function getStatistik()
    {
        $user = Auth::user();

        // Statistik dasar
        $totalDosen = Bimbingan::where('nidn', $user->dosen->id_nidn)->count();
        $bulanIni = Bimbingan::where('nidn', $user->dosen->id_nidn)
            ->whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->count();
        $selesai = Bimbingan::where('nidn', $user->dosen->id_nidn)
            ->where('status_validasi', 'valid')
            ->count();
        $baruCount = Bimbingan::where('nidn', $user->dosen->id_nidn)
            ->whereNull('dibaca_oleh_dosen')
            ->where('tanggal', '>=', Carbon::now()->subHours(24))
            ->count();

        // Statistik status baca
        $belumDibaca = Bimbingan::where('nidn', $user->dosen->id_nidn)
            ->whereNull('dibaca_oleh_dosen')
            ->count();
        $sudahDibaca = Bimbingan::where('nidn', $user->dosen->id_nidn)
            ->whereNotNull('dibaca_oleh_dosen')
            ->count();

        return response()->json([
            'total_dosen' => $totalDosen,
            'bulan_ini' => $bulanIni,
            'selesai' => $selesai,
            'baru_count' => $baruCount,
            'belum_dibaca' => $belumDibaca,
            'sudah_dibaca' => $sudahDibaca,
            'read_percentage' => $totalDosen > 0 ? round(($sudahDibaca / $totalDosen) * 100, 1) : 0,
            'status_summary' => [
                'total' => $totalDosen,
                'read' => $sudahDibaca,
                'unread' => $belumDibaca,
                'all_read' => $belumDibaca === 0
            ]
        ]);
    }

    public function getBimbinganByStatus($status)
    {
        $user = Auth::user();

        $query = Bimbingan::where('nidn', $user->dosen->id_nidn)
            ->with(['mahasiswa' => function ($query) {
                $query->select('id_nim', 'nama');
            }]);

        switch ($status) {
            case 'sudah-dibaca':
                $query->whereNotNull('dibaca_oleh_dosen');
                break;
            case 'belum-dibaca':
                $query->whereNull('dibaca_oleh_dosen');
                break;
            case 'baru':
                $query->whereNull('dibaca_oleh_dosen')
                      ->where('tanggal', '>=', Carbon::now()->subHours(24));
                break;
            default:
                return response()->json([
                    'success' => false,
                    'message' => 'Status tidak valid.'
                ], 400);
        }

        $bimbingan = $query->orderByDesc('tanggal')->get();

        return response()->json([
            'success' => true,
            'data' => $bimbingan->map(function ($item) {
                return [
                    'id' => $item->id_bimbingan,
                    'mahasiswa_nama' => $item->mahasiswa->nama,
                    'tanggal' => $item->tanggal->format('d M Y, H:i'),
                    'status_validasi' => $item->status_validasi,
                    'is_read' => !is_null($item->dibaca_oleh_dosen),
                    'read_at' => $item->dibaca_oleh_dosen ? $item->dibaca_oleh_dosen->format('d M Y, H:i') : null,
                    'created_at' => $item->tanggal->diffForHumans(),
                ];
            }),
            'total' => $bimbingan->count(),
            'status' => $status
        ]);
    }
}
