<?php

namespace Database\Seeders;

use App\Models\Poli;
use Illuminate\Database\Seeder;

class PoliSeeder extends Seeder
{
    /**
     * Seed data poli sesuai brief Section 5.2.
     */
    public function run(): void
    {
        $poliList = [
            'Umum',
            'Gigi',
            'Anak',
            'Penyakit Dalam',
            'Kandungan',
            'Mata',
        ];

        foreach ($poliList as $nama) {
            Poli::firstOrCreate(['nama_poli' => $nama]);
        }
    }
}
