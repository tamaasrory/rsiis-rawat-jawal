<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePasienRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Data Pasien
            'nama'              => 'required|string|min:3|max:100',
            'tanggal_lahir'     => 'required|date|before:today',
            'jenis_kelamin'     => 'required|in:L,P',
            'no_hp'             => ['required', 'regex:/^[0-9+\-\s]+$/', 'min:10', 'max:15'],
            'alamat'            => 'required|string|max:500',

            // Data Kunjungan Pertama
            'tanggal_kunjungan' => 'required|date|after_or_equal:today',
            'poli_id'           => 'required|exists:poli,id',
            'dokter_id'         => 'required|exists:dokter,id',
            'jenis_pembayaran'  => 'required|in:BPJS,Umum,Asuransi',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required'              => 'Nama pasien wajib diisi.',
            'nama.min'                   => 'Nama pasien minimal 3 karakter.',
            'tanggal_lahir.required'     => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.before'       => 'Tanggal lahir harus sebelum hari ini.',
            'jenis_kelamin.required'     => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'           => 'Jenis kelamin harus L atau P.',
            'no_hp.required'             => 'Nomor HP wajib diisi.',
            'no_hp.regex'                => 'Format nomor HP tidak valid.',
            'no_hp.min'                  => 'Nomor HP minimal 10 karakter.',
            'alamat.required'            => 'Alamat wajib diisi.',
            'tanggal_kunjungan.required' => 'Tanggal kunjungan wajib diisi.',
            'tanggal_kunjungan.after_or_equal' => 'Tanggal kunjungan tidak boleh di masa lalu.',
            'poli_id.required'           => 'Poli tujuan wajib dipilih.',
            'poli_id.exists'             => 'Poli yang dipilih tidak valid.',
            'dokter_id.required'         => 'Dokter wajib dipilih.',
            'dokter_id.exists'           => 'Dokter yang dipilih tidak valid.',
            'jenis_pembayaran.required'  => 'Jenis pembayaran wajib dipilih.',
            'jenis_pembayaran.in'        => 'Jenis pembayaran tidak valid.',
        ];
    }
}
