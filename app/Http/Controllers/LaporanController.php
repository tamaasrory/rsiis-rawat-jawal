<?php

namespace App\Http\Controllers;

class LaporanController extends Controller
{
    public function index()
    {
        // Placeholder — akan diimplementasi di Fase 4
        return view('laporan.index', [
            'kunjungan' => collect(),
            'total' => 0,
            'dokter' => collect(),
        ]);
    }
}
