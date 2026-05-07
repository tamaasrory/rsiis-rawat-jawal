@extends('layouts.app')

@section('title', 'Pendaftaran Pasien Baru')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('pasien.index') }}" class="text-decoration-none">Daftar Pasien</a></li>
<li class="breadcrumb-item active">Pendaftaran Baru</li>
@endsection

@section('content')
<div class="mb-3">
    <h1 class="h4 fw-bold">Pendaftaran Pasien Baru</h1>
    <p class="text-muted mb-0">Isi data pasien dan informasi kunjungan pertama</p>
</div>

<form method="POST" action="{{ route('pasien.store') }}" id="formPendaftaran">
    @csrf

    {{-- Data Pasien --}}
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
                           value="{{ old('nama') }}" required>
                    @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir"
                           class="form-control @error('tanggal_lahir') is-invalid @enderror"
                           value="{{ old('tanggal_lahir') }}" max="{{ date('Y-m-d', strtotime('-1 day')) }}" required>
                    @error('tanggal_lahir')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="jenis_kelamin" id="jenis_kelamin"
                            class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                        <option value="">-- Pilih --</option>
                        <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="no_hp" class="form-label">No HP <span class="text-danger">*</span></label>
                    <input type="text" name="no_hp" id="no_hp"
                           class="form-control @error('no_hp') is-invalid @enderror"
                           value="{{ old('no_hp') }}" placeholder="08xx-xxxx-xxxx" required>
                    @error('no_hp')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-8">
                    <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                    <textarea name="alamat" id="alamat" rows="2"
                              class="form-control @error('alamat') is-invalid @enderror"
                              required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    {{-- Data Kunjungan --}}
    <div class="card mb-3">
        <div class="card-header bg-white fw-semibold">
            <i class="bi bi-calendar-plus me-1"></i> Data Kunjungan Pertama
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="tanggal_kunjungan" class="form-label">Tanggal Kunjungan <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal_kunjungan" id="tanggal_kunjungan"
                           class="form-control @error('tanggal_kunjungan') is-invalid @enderror"
                           value="{{ old('tanggal_kunjungan', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                    @error('tanggal_kunjungan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="poli_id" class="form-label">Poli Tujuan <span class="text-danger">*</span></label>
                    <select name="poli_id" id="poli_id"
                            class="form-select @error('poli_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Poli --</option>
                        @foreach($poli as $p)
                        <option value="{{ $p->id }}" {{ old('poli_id') == $p->id ? 'selected' : '' }}>
                            {{ $p->nama_poli }}
                        </option>
                        @endforeach
                    </select>
                    @error('poli_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="dokter_id" class="form-label">Dokter <span class="text-danger">*</span></label>
                    <select name="dokter_id" id="dokter_id"
                            class="form-select @error('dokter_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Dokter --</option>
                    </select>
                    @error('dokter_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="jenis_pembayaran" class="form-label">Jenis Pembayaran <span class="text-danger">*</span></label>
                    <select name="jenis_pembayaran" id="jenis_pembayaran"
                            class="form-select @error('jenis_pembayaran') is-invalid @enderror" required>
                        <option value="">-- Pilih --</option>
                        <option value="BPJS" {{ old('jenis_pembayaran') === 'BPJS' ? 'selected' : '' }}>BPJS</option>
                        <option value="Umum" {{ old('jenis_pembayaran') === 'Umum' ? 'selected' : '' }}>Umum</option>
                        <option value="Asuransi" {{ old('jenis_pembayaran') === 'Asuransi' ? 'selected' : '' }}>Asuransi</option>
                    </select>
                    @error('jenis_pembayaran')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-check-lg me-1"></i> Simpan Pendaftaran
        </button>
        <a href="{{ route('pasien.index') }}" class="btn btn-outline-secondary">Batal</a>
    </div>
</form>
@endsection

@push('scripts')
<script>
    // Data dokter untuk filter dinamis berdasarkan poli
    const dokterData = @json($dokter);
    const oldDokter = '{{ old('dokter_id') }}';
    const poliSelect = document.getElementById('poli_id');
    const dokterSelect = document.getElementById('dokter_id');

    function filterDokter() {
        const poliId = poliSelect.value;
        dokterSelect.innerHTML = '<option value="">-- Pilih Dokter --</option>';
        if (!poliId) return;

        dokterData
            .filter(d => d.poli_id == poliId)
            .forEach(d => {
                const opt = document.createElement('option');
                opt.value = d.id;
                opt.textContent = d.nama;
                if (oldDokter == d.id) opt.selected = true;
                dokterSelect.appendChild(opt);
            });
    }

    poliSelect.addEventListener('change', filterDokter);

    // Trigger on page load jika ada old value
    if (poliSelect.value) filterDokter();
</script>
@endpush
