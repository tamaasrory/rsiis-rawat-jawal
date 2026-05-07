@extends('layouts.app')

@section('title', 'Edit Asesmen')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('asesmen.index') }}" class="text-decoration-none">Asesmen</a></li>
<li class="breadcrumb-item active">Edit Asesmen</li>
@endsection

@section('content')
{{-- Header Info Pasien & Kunjungan --}}
<div class="card mb-3 border-start border-success border-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="text-muted mb-1">Data Pasien</h6>
                <h5 class="fw-bold mb-1">{{ $asesmen->kunjungan->pasien->nama }}</h5>
                <p class="mb-0 text-muted small">
                    {{ $asesmen->kunjungan->pasien->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }} &middot;
                    {{ $asesmen->kunjungan->pasien->tanggal_lahir->format('d/m/Y') }}
                    ({{ $asesmen->kunjungan->pasien->tanggal_lahir->age }} thn)
                </p>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted mb-1">Data Kunjungan</h6>
                <p class="mb-0">
                    <strong>Tanggal:</strong> {{ $asesmen->kunjungan->tanggal_kunjungan->format('d/m/Y') }}<br>
                    <strong>Poli:</strong> {{ $asesmen->kunjungan->poli->nama_poli }} &middot;
                    <strong>Dokter:</strong> {{ $asesmen->kunjungan->dokter->nama }}<br>
                    <span class="badge bg-success">Sudah Asesmen</span>
                </p>
            </div>
        </div>
    </div>
</div>

{{-- Form Edit Asesmen --}}
<form method="POST" action="{{ route('asesmen.update', $asesmen) }}">
    @csrf
    @method('PUT')

    <div class="card mb-3">
        <div class="card-header bg-white fw-semibold">
            <i class="bi bi-clipboard2-pulse me-1"></i> Edit Asesmen
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-12">
                    <label for="keluhan_utama" class="form-label">Keluhan Utama <span class="text-danger">*</span></label>
                    <textarea name="keluhan_utama" id="keluhan_utama" rows="2"
                              class="form-control @error('keluhan_utama') is-invalid @enderror"
                              required>{{ old('keluhan_utama', $asesmen->keluhan_utama) }}</textarea>
                    @error('keluhan_utama')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="tekanan_darah" class="form-label">Tekanan Darah <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" name="tekanan_darah" id="tekanan_darah"
                               class="form-control @error('tekanan_darah') is-invalid @enderror"
                               value="{{ old('tekanan_darah', $asesmen->tekanan_darah) }}" required>
                        <span class="input-group-text">mmHg</span>
                        @error('tekanan_darah')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="suhu_tubuh" class="form-label">Suhu Tubuh <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="number" name="suhu_tubuh" id="suhu_tubuh"
                               class="form-control @error('suhu_tubuh') is-invalid @enderror"
                               value="{{ old('suhu_tubuh', $asesmen->suhu_tubuh) }}"
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
                               value="{{ old('berat_badan', $asesmen->berat_badan) }}"
                               step="0.01" min="1" max="300" required>
                        <span class="input-group-text">kg</span>
                        @error('berat_badan')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="diagnosis_awal" class="form-label">Diagnosis Awal <span class="text-danger">*</span></label>
                    <textarea name="diagnosis_awal" id="diagnosis_awal" rows="3"
                              class="form-control @error('diagnosis_awal') is-invalid @enderror"
                              required>{{ old('diagnosis_awal', $asesmen->diagnosis_awal) }}</textarea>
                    @error('diagnosis_awal')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="tindakan_terapi" class="form-label">Tindakan / Terapi <span class="text-danger">*</span></label>
                    <textarea name="tindakan_terapi" id="tindakan_terapi" rows="3"
                              class="form-control @error('tindakan_terapi') is-invalid @enderror"
                              required>{{ old('tindakan_terapi', $asesmen->tindakan_terapi) }}</textarea>
                    @error('tindakan_terapi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="catatan_dokter" class="form-label">Catatan Dokter <span class="text-muted">(opsional)</span></label>
                    <textarea name="catatan_dokter" id="catatan_dokter" rows="2"
                              class="form-control @error('catatan_dokter') is-invalid @enderror"
                              >{{ old('catatan_dokter', $asesmen->catatan_dokter) }}</textarea>
                    @error('catatan_dokter')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
        </button>
        <a href="{{ route('asesmen.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection
