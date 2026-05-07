<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAsesmenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kunjungan_id'    => 'required|exists:kunjungan,id',
            'keluhan_utama'   => 'required|string|max:1000',
            'tekanan_darah'   => ['required', 'regex:/^\d{2,3}\/\d{2,3}$/'],
            'suhu_tubuh'      => 'required|numeric|between:30,45',
            'berat_badan'     => 'required|numeric|between:1,300',
            'diagnosis_awal'  => 'required|string|max:500',
            'tindakan_terapi' => 'required|string|max:1000',
            'catatan_dokter'  => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'kunjungan_id.required'    => 'Kunjungan wajib dipilih.',
            'kunjungan_id.exists'      => 'Kunjungan tidak valid.',
            'keluhan_utama.required'   => 'Keluhan utama wajib diisi.',
            'keluhan_utama.max'        => 'Keluhan utama maksimal 1000 karakter.',
            'tekanan_darah.required'   => 'Tekanan darah wajib diisi.',
            'tekanan_darah.regex'      => 'Format tekanan darah harus seperti "120/80".',
            'suhu_tubuh.required'      => 'Suhu tubuh wajib diisi.',
            'suhu_tubuh.between'       => 'Suhu tubuh harus antara 30 - 45 °C.',
            'berat_badan.required'     => 'Berat badan wajib diisi.',
            'berat_badan.between'      => 'Berat badan harus antara 1 - 300 kg.',
            'diagnosis_awal.required'  => 'Diagnosis awal wajib diisi.',
            'diagnosis_awal.max'       => 'Diagnosis awal maksimal 500 karakter.',
            'tindakan_terapi.required' => 'Tindakan/terapi wajib diisi.',
            'tindakan_terapi.max'      => 'Tindakan/terapi maksimal 1000 karakter.',
            'catatan_dokter.max'       => 'Catatan dokter maksimal 1000 karakter.',
        ];
    }
}
