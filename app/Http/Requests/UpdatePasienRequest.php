<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasienRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama'          => 'required|string|min:3|max:100',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp'         => ['required', 'regex:/^[0-9+\-\s]+$/', 'min:10', 'max:15'],
            'alamat'        => 'required|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required'          => 'Nama pasien wajib diisi.',
            'nama.min'               => 'Nama pasien minimal 3 karakter.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.before'   => 'Tanggal lahir harus sebelum hari ini.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'no_hp.required'         => 'Nomor HP wajib diisi.',
            'no_hp.regex'            => 'Format nomor HP tidak valid.',
            'no_hp.min'              => 'Nomor HP minimal 10 karakter.',
            'alamat.required'        => 'Alamat wajib diisi.',
        ];
    }
}
