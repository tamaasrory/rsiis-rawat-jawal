<?php

namespace Database\Seeders;

use App\Models\Dokter;
use App\Models\Poli;
use Illuminate\Database\Seeder;

class DokterSeeder extends Seeder
{
    /**
     * Seed 6 dokter dengan poli yang variatif sesuai brief Section 12.
     */
    public function run(): void
    {
        $dokterList = [
            ['nama' => 'dr. Andi Pratama',     'spesialisasi' => 'Dokter Umum',           'poli' => 'Umum'],
            ['nama' => 'drg. Siti Rahayu',     'spesialisasi' => 'Dokter Gigi',           'poli' => 'Gigi'],
            ['nama' => 'dr. Budi Santoso, Sp.A', 'spesialisasi' => 'Spesialis Anak',     'poli' => 'Anak'],
            ['nama' => 'dr. Dewi Lestari, Sp.PD', 'spesialisasi' => 'Spesialis Penyakit Dalam', 'poli' => 'Penyakit Dalam'],
            ['nama' => 'dr. Rina Wulandari, Sp.OG', 'spesialisasi' => 'Spesialis Kandungan', 'poli' => 'Kandungan'],
            ['nama' => 'dr. Hendra Wijaya, Sp.M', 'spesialisasi' => 'Spesialis Mata',    'poli' => 'Mata'],
        ];

        foreach ($dokterList as $data) {
            $poli = Poli::where('nama_poli', $data['poli'])->first();

            if ($poli) {
                Dokter::firstOrCreate(
                    ['nama' => $data['nama']],
                    [
                        'spesialisasi' => $data['spesialisasi'],
                        'poli_id' => $poli->id,
                    ]
                );
            }
        }
    }
}
