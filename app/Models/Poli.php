<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poli extends Model
{
    protected $table = 'poli';

    protected $fillable = [
        'nama_poli',
    ];

    /**
     * Poli memiliki banyak dokter.
     */
    public function dokter(): HasMany
    {
        return $this->hasMany(Dokter::class);
    }

    /**
     * Poli memiliki banyak kunjungan.
     */
    public function kunjungan(): HasMany
    {
        return $this->hasMany(Kunjungan::class);
    }
}
