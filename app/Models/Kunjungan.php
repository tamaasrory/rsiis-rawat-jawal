<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kunjungan extends Model
{
    protected $table = 'kunjungan';

    // Status constants — hindari hardcode string di banyak tempat (Section 9.2 #7)
    const STATUS_TERDAFTAR = 'terdaftar';
    const STATUS_SUDAH_ASESMEN = 'sudah_asesmen';
    const STATUS_BATAL = 'batal';

    protected $fillable = [
        'pasien_id',
        'poli_id',
        'dokter_id',
        'tanggal_kunjungan',
        'jenis_pembayaran',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_kunjungan' => 'date',
        ];
    }

    // --- Relationships ---

    /**
     * Kunjungan milik satu pasien.
     */
    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    /**
     * Kunjungan ke satu poli.
     */
    public function poli(): BelongsTo
    {
        return $this->belongsTo(Poli::class);
    }

    /**
     * Kunjungan ditangani satu dokter.
     */
    public function dokter(): BelongsTo
    {
        return $this->belongsTo(Dokter::class);
    }

    /**
     * Satu kunjungan memiliki maksimal satu asesmen (one-to-one).
     */
    public function asesmen(): HasOne
    {
        return $this->hasOne(Asesmen::class);
    }

    // --- Eloquent Scopes ---

    /**
     * Scope: hanya kunjungan yang berstatus 'terdaftar'.
     */
    public function scopeTerdaftar(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_TERDAFTAR);
    }

    /**
     * Scope: hanya kunjungan yang berstatus 'sudah_asesmen'.
     */
    public function scopeSudahAsesmen(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_SUDAH_ASESMEN);
    }

    // --- Helper Methods ---

    /**
     * Cek apakah kunjungan bisa dibatalkan (hanya jika status = terdaftar).
     */
    public function bisaDibatalkan(): bool
    {
        return $this->status === self::STATUS_TERDAFTAR;
    }

    /**
     * Cek apakah kunjungan bisa di-asesmen (hanya jika status = terdaftar).
     */
    public function bisaDiasesmen(): bool
    {
        return $this->status === self::STATUS_TERDAFTAR;
    }
}
