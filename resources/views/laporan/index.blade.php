@extends('layouts.app')

@section('title', 'Laporan Kunjungan')

@section('breadcrumb')
<li class="breadcrumb-item active">Laporan Kunjungan</li>
@endsection

@section('content')
<div class="mb-3">
    <h1 class="h4 fw-bold">Laporan Kunjungan</h1>
    <p class="text-muted mb-0">Filter dan analisis data kunjungan pasien</p>
</div>

{{-- Filter --}}
<div class="card mb-3">
    <div class="card-header bg-white fw-semibold">
        <i class="bi bi-funnel me-1"></i> Filter
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('laporan.index') }}" id="filterForm">
            <div class="row g-2">
                <div class="col-md-3">
                    <label for="nama" class="form-label small fw-semibold">Nama Pasien</label>
                    <input type="text" name="nama" id="nama" class="form-control form-control-sm"
                           value="{{ request('nama') }}" placeholder="Cari nama...">
                </div>
                <div class="col-md-2">
                    <label for="tanggal_dari" class="form-label small fw-semibold">Tanggal Dari</label>
                    <input type="date" name="tanggal_dari" id="tanggal_dari" class="form-control form-control-sm"
                           value="{{ request('tanggal_dari') }}">
                </div>
                <div class="col-md-2">
                    <label for="tanggal_sampai" class="form-label small fw-semibold">Tanggal Sampai</label>
                    <input type="date" name="tanggal_sampai" id="tanggal_sampai" class="form-control form-control-sm"
                           value="{{ request('tanggal_sampai') }}">
                </div>
                <div class="col-md-2">
                    <label for="dokter_id" class="form-label small fw-semibold">Dokter</label>
                    <select name="dokter_id" id="dokter_id" class="form-select form-select-sm">
                        <option value="">Semua Dokter</option>
                        @foreach($dokter as $d)
                        <option value="{{ $d->id }}" {{ request('dokter_id') == $d->id ? 'selected' : '' }}>
                            {{ $d->nama }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="status" class="form-label small fw-semibold">Status</label>
                    <select name="status" id="status" class="form-select form-select-sm">
                        <option value="">Semua Status</option>
                        <option value="terdaftar" {{ request('status') === 'terdaftar' ? 'selected' : '' }}>Terdaftar</option>
                        <option value="sudah_asesmen" {{ request('status') === 'sudah_asesmen' ? 'selected' : '' }}>Sudah Asesmen</option>
                        <option value="batal" {{ request('status') === 'batal' ? 'selected' : '' }}>Batal</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="diagnosis" class="form-label small fw-semibold">Diagnosis</label>
                    <input type="text" name="diagnosis" id="diagnosis" class="form-control form-control-sm"
                           value="{{ request('diagnosis') }}" placeholder="Cari diagnosis...">
                </div>
                <div class="col-md-9 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="bi bi-funnel me-1"></i> Filter
                    </button>
                    @if(request()->hasAny(['nama', 'tanggal_dari', 'tanggal_sampai', 'dokter_id', 'status', 'diagnosis']))
                    <a href="{{ route('laporan.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-x-lg me-1"></i> Reset
                    </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Ringkasan --}}
<div class="card mb-3">
    <div class="card-body py-2">
        <div class="d-flex align-items-center">
            <i class="bi bi-bar-chart-line text-primary me-2 fs-5"></i>
            <span class="fw-semibold">Total Kunjungan:</span>
            <span class="badge bg-primary ms-2 fs-6">{{ $total }}</span>
            @if(request()->hasAny(['nama', 'tanggal_dari', 'tanggal_sampai', 'dokter_id', 'status', 'diagnosis']))
            <small class="text-muted ms-2">(sesuai filter aktif)</small>
            @endif
        </div>
    </div>
</div>

{{-- Tabel Laporan --}}
<div class="card">
    <div class="card-body p-0">
        @if($kunjungan->isEmpty())
        <div class="empty-state">
            <i class="bi bi-search"></i>
            <p class="mb-0">Tidak ada data kunjungan ditemukan.</p>
            @if(request()->hasAny(['nama', 'tanggal_dari', 'tanggal_sampai', 'dokter_id', 'status', 'diagnosis']))
            <a href="{{ route('laporan.index') }}" class="btn btn-outline-primary btn-sm mt-2">Reset Filter</a>
            @endif
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Tanggal</th>
                        <th>Nama Pasien</th>
                        <th>Poli</th>
                        <th>Dokter</th>
                        <th>Diagnosis Awal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($kunjungan as $k)
                    <tr>
                        <td class="text-muted">{{ $kunjungan->firstItem() + $loop->index }}</td>
                        <td>{{ $k->tanggal_kunjungan->format('d/m/Y') }}</td>
                        <td class="fw-semibold">{{ $k->pasien->nama }}</td>
                        <td>{{ $k->poli->nama_poli }}</td>
                        <td>{{ $k->dokter->nama }}</td>
                        <td>
                            @if($k->asesmen)
                                <small>{{ Str::limit($k->asesmen->diagnosis_awal, 50) }}</small>
                            @else
                                <small class="text-muted">—</small>
                            @endif
                        </td>
                        <td>
                            @if($k->status === \App\Models\Kunjungan::STATUS_TERDAFTAR)
                                <span class="badge bg-warning text-dark">Terdaftar</span>
                            @elseif($k->status === \App\Models\Kunjungan::STATUS_SUDAH_ASESMEN)
                                <span class="badge bg-success">Sudah Asesmen</span>
                            @else
                                <span class="badge bg-secondary">Batal</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
    @if($kunjungan instanceof \Illuminate\Pagination\AbstractPaginator && $kunjungan->hasPages())
    <div class="card-footer bg-white">
        {{ $kunjungan->links() }}
    </div>
    @endif
</div>
@endsection
