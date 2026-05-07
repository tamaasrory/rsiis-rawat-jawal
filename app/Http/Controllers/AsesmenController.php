<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;

class AsesmenController extends Controller
{
    public function index()
    {
        // Placeholder — akan diimplementasi di Fase 3
        return view('asesmen.index', [
            'kunjunganTerdaftar' => Kunjungan::terdaftar()
                ->with(['pasien', 'poli', 'dokter'])
                ->orderBy('tanggal_kunjungan', 'desc')
                ->get(),
            'asesmenList' => collect(),
        ]);
    }
}
