<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KunjunganController extends Controller
{
    /**
     * Batalkan kunjungan (US-04).
     * Hanya bisa jika status = terdaftar (BR-03).
     */
    public function batal(Kunjungan $kunjungan)
    {
        if (!$kunjungan->bisaDibatalkan()) {
            return back()->with('error', 'Kunjungan ini tidak dapat dibatalkan.');
        }

        try {
            $kunjungan->update(['status' => Kunjungan::STATUS_BATAL]);

            return back()->with('success', 'Kunjungan berhasil dibatalkan.');
        } catch (\Exception $e) {
            Log::error('Gagal membatalkan kunjungan: ' . $e->getMessage());

            return back()->with('error', 'Gagal membatalkan kunjungan. Silakan coba lagi.');
        }
    }

    /**
     * Tambah kunjungan baru untuk pasien yang sudah ada (BR-04).
     */
    public function store(Request $request, Pasien $pasien)
    {
        $validated = $request->validate([
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'poli_id'           => 'required|exists:poli,id',
            'dokter_id'         => 'required|exists:dokter,id',
            'jenis_pembayaran'  => 'required|in:BPJS,Umum,Asuransi',
        ], [
            'tanggal_kunjungan.required'       => 'Tanggal kunjungan wajib diisi.',
            'tanggal_kunjungan.after_or_equal'  => 'Tanggal kunjungan tidak boleh di masa lalu.',
            'poli_id.required'                 => 'Poli tujuan wajib dipilih.',
            'dokter_id.required'               => 'Dokter wajib dipilih.',
            'jenis_pembayaran.required'        => 'Jenis pembayaran wajib dipilih.',
        ]);

        try {
            $pasien->kunjungan()->create([
                ...$validated,
                'status' => Kunjungan::STATUS_TERDAFTAR,
            ]);

            return redirect()
                ->route('pasien.kunjungan', $pasien)
                ->with('success', 'Kunjungan baru berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Gagal menambah kunjungan: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal menambah kunjungan. Silakan coba lagi.');
        }
    }
}
