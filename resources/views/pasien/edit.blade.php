@extends('layouts.app')

@section('title', 'Edit Pasien')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('pasien.index') }}" class="text-decoration-none">Daftar Pasien</a></li>
<li class="breadcrumb-item active">Edit: {{ $pasien->nama }}</li>
@endsection

@section('content')
<div class="mb-3">
    <h1 class="h4 fw-bold">Edit Data Pasien</h1>
    <p class="text-muted mb-0">Perbarui data pasien: <strong>{{ $pasien->nama }}</strong></p>
</div>

<form method="POST" action="{{ route('pasien.update', $pasien) }}">
    @csrf
    @method('PUT')

    <div class="card mb-3">
        <div class="card-header bg-white fw-semibold">
            <i class="bi bi-person me-1"></i> Data Pasien
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" id="nama"
                           class="form-control @error('nama') is-invalid @enderror"
                           value="{{ old('nama', $pasien->nama) }}" required>
                    @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                           class="form-control @error('tanggal_lahir') is-invalid @enderror"
                           value="{{ old('tanggal_lahir', $pasien->tanggal_lahir->format('Y-m-d')) }}" required>
                    @error('tanggal_lahir')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="jenis_kelamin" id="jenis_kelamin"
                            class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                        <option value="L" {{ old('jenis_kelamin', $pasien->jenis_kelamin) === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $pasien->jenis_kelamin) === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="no_hp" class="form-label">No HP <span class="text-danger">*</span></label>
                    <input type="text" name="no_hp" id="no_hp"
                           class="form-control @error('no_hp') is-invalid @enderror"
                           value="{{ old('no_hp', $pasien->no_hp) }}" required>
                    @error('no_hp')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-8">
                    <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                    <textarea name="alamat" id="alamat" rows="2"
                              class="form-control @error('alamat') is-invalid @enderror"
                              required>{{ old('alamat', $pasien->alamat) }}</textarea>
                    @error('alamat')
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
        <a href="{{ route('pasien.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection
