<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Pasien;

class HomeController extends Controller
{
    public function index()
    {
        $totalPasien = Pasien::count();
        $totalKunjunganHariIni = Kunjungan::whereDate('tanggal_kunjungan', today())->count();
        $totalMenungguAsesmen = Kunjungan::terdaftar()->count();

        return view('home.index', compact(
            'totalPasien',
            'totalKunjunganHariIni',
            'totalMenungguAsesmen'
        ));
    }
}
