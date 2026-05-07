<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Kunjungan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Laporan kunjungan dengan multi-filter (US-08).
     * Query pattern sesuai brief Section 8.4.
     */
    public function index(Request $request)
    {
        $query = Kunjungan::with(['pasien', 'dokter', 'poli', 'asesmen'])
            ->when($request->nama, fn($q, $v) =>
                $q->whereHas('pasien', fn($q) =>
                    $q->where('nama', 'like', "%{$v}%")))
            ->when($request->dokter_id, fn($q, $v) =>
                $q->where('dokter_id', $v))
            ->when($request->status, fn($q, $v) =>
                $q->where('status', $v))
            ->when($request->diagnosis, fn($q, $v) =>
                $q->whereHas('asesmen', fn($q) =>
                    $q->where('diagnosis_awal', 'like', "%{$v}%")))
            ->when($request->tanggal_dari, fn($q, $v) =>
                $q->where('tanggal_kunjungan', '>=', $v))
            ->when($request->tanggal_sampai, fn($q, $v) =>
                $q->where('tanggal_kunjungan', '<=', $v))
            ->orderBy('tanggal_kunjungan', 'desc');

        $total = $query->count();
        $kunjungan = $query->paginate(20)->withQueryString();
        $dokter = Dokter::orderBy('nama')->get();

        return view('laporan.index', compact('kunjungan', 'total', 'dokter'));
    }
}
