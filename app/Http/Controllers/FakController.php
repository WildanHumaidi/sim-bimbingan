<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FakController extends Controller
{
    public static $listFakultas = [
        'Teknik & Informatika',
        'Komunikasi & Bahasa',
        'Ekonomi & Bisnis',
        'Hukum',
        'Ilmu Kesehatan'
    ];


    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => self::$listFakultas
        ]);
    }

    public function validateFakultas($nama)
    {
        $isValid = in_array($nama, self::$listFakultas);

        return response()->json([
            'success' => true,
            'data' => $isValid
        ]);
    }
}
