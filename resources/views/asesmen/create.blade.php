@extends('layouts.app')

@section('title', 'Buat Asesmen')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('asesmen.index') }}" class="text-decoration-none">Asesmen</a></li>
<li class="breadcrumb-item active">Buat Asesmen</li>
@endsection

@section('content')
{{-- Header Info Pasien & Kunjungan --}}
<div class="card mb-3 border-start border-primary border-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="text-muted mb-1">Data Pasien</h6>
                <h5 class="fw-bold mb-1">{{ $kunjungan->pasien->nama }}</h5>
                <p class="mb-0 text-muted small">
                    {{ $kunjungan->pasien->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }} &middot;
                    {{ $kunjungan->pasien->tanggal_lahir->format('d/m/Y') }}
                    ({{ $kunjungan->pasien->tanggal_lahir->age }} thn) &middot;
                    <i class="bi bi-telephone"></i> {{ $kunjungan->pasien->no_hp }}
                </p>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted mb-1">Data Kunjungan</h6>
                <p class="mb-0">
                    <strong>Tanggal:</strong> {{ $kunjungan->tanggal_kunjungan->format('d/m/Y') }}<br>
                    <strong>Poli:</strong> {{ $kunjungan->poli->nama_poli }} &middot;
                    <strong>Dokter:</strong> {{ $kunjungan->dokter->nama }}<br>
                    <strong>Pembayaran:</strong> {{ $kunjungan->jenis_pembayaran }}
                </p>
            </div>
        </div>
    </div>
</div>

{{-- Form Asesmen --}}
<form method="POST" action="{{ route('asesmen.store') }}">
    @csrf
    <input type="hidden" name="kunjungan_id" value="{{ $kunjungan->id }}">

    <div class="card mb-3">
        <div class="card-header bg-white fw-semibold">
            <i class="bi bi-clipboard2-pulse me-1"></i> Form Asesmen
        </div>
        <div class="card-body">
            <div class="row g-3">
                {{-- Keluhan Utama --}}
                <div class="col-12">
                    <label for="keluhan_utama" class="form-label">Keluhan Utama <span class="text-danger">*</span></label>
                    <textarea name="keluhan_utama" id="keluhan_utama" rows="2"
                              class="form-control @error('keluhan_utama') is-invalid @enderror"
                              placeholder="Tuliskan keluhan utama pasien..."
                              required>{{ old('keluhan_utama') }}</textarea>
                    @error('keluhan_utama')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Vital Signs --}}
                <div class="col-md-4">
                    <label for="tekanan_darah" class="form-label">Tekanan Darah <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" name="tekanan_darah" id="tekanan_darah"
                               class="form-control @error('tekanan_darah') is-invalid @enderror"
                               value="{{ old('tekanan_darah') }}" placeholder="120/80" required>
                        <span class="input-group-text">mmHg</span>
                        @error('tekanan_darah')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <small class="text-muted">Format: sistolik/diastolik</small>
                </div>
                <div class="col-md-4">
                    <label for="suhu_tubuh" class="form-label">Suhu Tubuh <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="number" name="suhu_tubuh" id="suhu_tubuh"
                               class="form-control @error('suhu_tubuh') is-invalid @enderror"
                               value="{{ old('suhu_tubuh') }}" placeholder="36.5"
                               step="0.1" min="30" max="45" required>
                        <span class="input-group-text">°C</span>
                        @error('suhu_tubuh')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="berat_badan" class="form-label">Berat Badan <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="number" name="berat_badan" id="berat_badan"
                               class="form-control @error('berat_badan') is-invalid @enderror"
                               value="{{ old('berat_badan') }}" placeholder="65.5"
                               step="0.01" min="1" max="300" required>
                        <span class="input-group-text">kg</span>
                        @error('berat_badan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Diagnosis & Tindakan --}}
                <div class="col-md-6">
                    <label for="diagnosis_awal" class="form-label">Diagnosis Awal <span class="text-danger">*</span></label>
                    <textarea name="diagnosis_awal" id="diagnosis_awal" rows="3"
                              class="form-control @error('diagnosis_awal') is-invalid @enderror"
                              placeholder="Tuliskan diagnosis awal..."
                              required>{{ old('diagnosis_awal') }}</textarea>
                    @error('diagnosis_awal')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="tindakan_terapi" class="form-label">Tindakan / Terapi <span class="text-danger">*</span></label>
                    <textarea name="tindakan_terapi" id="tindakan_terapi" rows="3"
                              class="form-control @error('tindakan_terapi') is-invalid @enderror"
                              placeholder="Tuliskan tindakan atau terapi yang diberikan..."
                              required>{{ old('tindakan_terapi') }}</textarea>
                    @error('tindakan_terapi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Catatan --}}
                <div class="col-12">
                    <label for="catatan_dokter" class="form-label">Catatan Dokter <span class="text-muted">(opsional)</span></label>
                    <textarea name="catatan_dokter" id="catatan_dokter" rows="2"
                              class="form-control @error('catatan_dokter') is-invalid @enderror"
                              placeholder="Catatan tambahan...">{{ old('catatan_dokter') }}</textarea>
                    @error('catatan_dokter')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg me-1"></i> Simpan Asesmen
        </button>
        <a href="{{ route('asesmen.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection
