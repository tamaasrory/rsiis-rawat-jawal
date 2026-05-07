<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pasien extends Model
{
    protected $table = 'pasien';

    protected $fillable = [
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_hp',
        'alamat',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }

    /**
     * Pasien memiliki banyak kunjungan.
     */
    public function kunjungan(): HasMany
    {
        return $this->hasMany(Kunjungan::class);
    }
}
