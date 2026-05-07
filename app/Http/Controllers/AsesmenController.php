<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAsesmenRequest;
use App\Http\Requests\UpdateAsesmenRequest;
use App\Models\Asesmen;
use App\Models\Kunjungan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AsesmenController extends Controller
{
    /**
     * List kunjungan yang siap di-asesmen + asesmen yang sudah ada (US-05).
     */
    public function index()
    {
        $kunjunganTerdaftar = Kunjungan::terdaftar()
            ->with(['pasien', 'poli', 'dokter'])
            ->orderBy('tanggal_kunjungan', 'desc')
            ->get();

        $asesmenList = Asesmen::with(['kunjungan.pasien', 'kunjungan.poli', 'kunjungan.dokter'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('asesmen.index', compact('kunjunganTerdaftar', 'asesmenList'));
    }

    /**
     * Form asesmen untuk kunjungan tertentu (US-05).
     */
    public function create(Kunjungan $kunjungan)
    {
        // BR-02: Asesmen hanya bisa dibuat untuk kunjungan status terdaftar
        if (!$kunjungan->bisaDiasesmen()) {
            return redirect()
                ->route('asesmen.index')
                ->with('error', 'Kunjungan ini tidak bisa di-asesmen (status: ' . $kunjungan->status . ').');
        }

        // BR-01: Cek apakah sudah punya asesmen
        if ($kunjungan->asesmen) {
            return redirect()
                ->route('asesmen.edit', $kunjungan->asesmen)
                ->with('warning', 'Kunjungan ini sudah memiliki asesmen. Anda dialihkan ke halaman edit.');
        }

        $kunjungan->load(['pasien', 'poli', 'dokter']);

        return view('asesmen.create', compact('kunjungan'));
    }

    /**
     * Simpan asesmen + update status kunjungan secara transaksional (US-05).
     */
    public function store(StoreAsesmenRequest $request)
    {
        $kunjungan = Kunjungan::findOrFail($request->kunjungan_id);

        // Double-check business rules
        if (!$kunjungan->bisaDiasesmen()) {
            return redirect()
                ->route('asesmen.index')
                ->with('error', 'Kunjungan ini tidak bisa di-asesmen.');
        }

        try {
            DB::beginTransaction();

            Asesmen::create($request->validated());

            $kunjungan->update(['status' => Kunjungan::STATUS_SUDAH_ASESMEN]);

            DB::commit();

            return redirect()
                ->route('asesmen.index')
                ->with('success', 'Asesmen berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan asesmen: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan asesmen. Silakan coba lagi.');
        }
    }

    /**
     * Form edit asesmen (US-06).
     */
    public function edit(Asesmen $asesmen)
    {
        $asesmen->load(['kunjungan.pasien', 'kunjungan.poli', 'kunjungan.dokter']);

        return view('asesmen.edit', compact('asesmen'));
    }

    /**
     * Update asesmen — status kunjungan tetap sudah_asesmen (US-06).
     */
    public function update(UpdateAsesmenRequest $request, Asesmen $asesmen)
    {
        try {
            $asesmen->update($request->validated());

            return redirect()
                ->route('asesmen.index')
                ->with('success', 'Asesmen berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal update asesmen: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui asesmen. Silakan coba lagi.');
        }
    }
}
