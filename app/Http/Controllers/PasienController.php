<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePasienRequest;
use App\Http\Requests\UpdatePasienRequest;
use App\Models\Dokter;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PasienController extends Controller
{
    /**
     * Daftar pasien dengan search dan pagination (US-02).
     */
    public function index(Request $request)
    {
        $pasien = Pasien::withCount('kunjungan')
            ->when($request->search, fn($q, $v) =>
                $q->where('nama', 'like', "%{$v}%"))
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('pasien.index', compact('pasien'));
    }

    /**
     * Form pendaftaran pasien baru + kunjungan pertama (US-01).
     */
    public function create()
    {
        $poli = Poli::orderBy('nama_poli')->get();
        $dokter = Dokter::with('poli')->orderBy('nama')->get();

        return view('pasien.create', compact('poli', 'dokter'));
    }

    /**
     * Simpan pasien baru + kunjungan pertama secara transaksional (US-01).
     */
    public function store(StorePasienRequest $request)
    {
        try {
            DB::beginTransaction();

            $pasien = Pasien::create($request->only([
                'nama', 'tanggal_lahir', 'jenis_kelamin', 'no_hp', 'alamat',
            ]));

            $pasien->kunjungan()->create([
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'poli_id'           => $request->poli_id,
                'dokter_id'         => $request->dokter_id,
                'jenis_pembayaran'  => $request->jenis_pembayaran,
                'status'            => Kunjungan::STATUS_TERDAFTAR,
            ]);

            DB::commit();

            return redirect()
                ->route('pasien.index')
                ->with('success', 'Pasien berhasil didaftarkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal mendaftarkan pasien: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data. Silakan coba lagi.');
        }
    }

    /**
     * Form edit data pasien (US-03).
     */
    public function edit(Pasien $pasien)
    {
        return view('pasien.edit', compact('pasien'));
    }

    /**
     * Update data pasien (US-03).
     */
    public function update(UpdatePasienRequest $request, Pasien $pasien)
    {
        try {
            $pasien->update($request->validated());

            return redirect()
                ->route('pasien.index')
                ->with('success', 'Data pasien berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Gagal update pasien: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui data. Silakan coba lagi.');
        }
    }

    /**
     * Riwayat kunjungan pasien (untuk Fase Asesmen US-07 juga).
     */
    public function kunjungan(Pasien $pasien)
    {
        $kunjungan = $pasien->kunjungan()
            ->with(['poli', 'dokter', 'asesmen'])
            ->orderBy('tanggal_kunjungan', 'desc')
            ->paginate(10);

        $poli = Poli::orderBy('nama_poli')->get();
        $dokter = Dokter::with('poli')->orderBy('nama')->get();

        return view('pasien.kunjungan', compact('pasien', 'kunjungan', 'poli', 'dokter'));
    }
}
