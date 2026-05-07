<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kunjungan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->constrained('pasien')->cascadeOnDelete();
            $table->foreignId('poli_id')->constrained('poli')->restrictOnDelete();
            $table->foreignId('dokter_id')->constrained('dokter')->restrictOnDelete();
            $table->date('tanggal_kunjungan');
            $table->enum('jenis_pembayaran', ['BPJS', 'Umum', 'Asuransi']);
            $table->enum('status', ['terdaftar', 'sudah_asesmen', 'batal'])->default('terdaftar');
            $table->timestamps();

            $table->index('status', 'idx_status');
            $table->index('tanggal_kunjungan', 'idx_tanggal');
            $table->index(['pasien_id', 'tanggal_kunjungan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kunjungan');
    }
};
