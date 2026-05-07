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
        Schema::create('asesmen', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kunjungan_id')->unique()->constrained('kunjungan')->cascadeOnDelete();
            $table->text('keluhan_utama');
            $table->string('tekanan_darah', 10);
            $table->decimal('suhu_tubuh', 4, 1);
            $table->decimal('berat_badan', 5, 2);
            $table->text('diagnosis_awal');
            $table->text('tindakan_terapi');
            $table->text('catatan_dokter')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asesmen');
    }
};
