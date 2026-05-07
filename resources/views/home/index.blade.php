@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-4">
    <h1 class="h3 fw-bold text-dark">Dashboard</h1>
    <p class="text-muted">Selamat datang di Aplikasi Pencatatan Pasien Rawat Jalan</p>
</div>

{{-- Statistik Ringkas --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-3 bg-primary bg-opacity-10 p-3 me-3">
                    <i class="bi bi-people-fill text-primary fs-3"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Pasien</div>
                    <div class="h4 fw-bold mb-0">{{ $totalPasien }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-3 bg-success bg-opacity-10 p-3 me-3">
                    <i class="bi bi-calendar-check-fill text-success fs-3"></i>
                </div>
                <div>
                    <div class="text-muted small">Kunjungan Hari Ini</div>
                    <div class="h4 fw-bold mb-0">{{ $totalKunjunganHariIni }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body d-flex align-items-center">
                <div class="rounded-3 bg-warning bg-opacity-10 p-3 me-3">
                    <i class="bi bi-hourglass-split text-warning fs-3"></i>
                </div>
                <div>
                    <div class="text-muted small">Menunggu Asesmen</div>
                    <div class="h4 fw-bold mb-0">{{ $totalMenungguAsesmen }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Menu Utama --}}
<div class="row g-3">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body text-center py-4">
                <i class="bi bi-person-plus-fill text-primary fs-1 mb-3 d-block"></i>
                <h5 class="card-title fw-bold">Pendaftaran</h5>
                <p class="card-text text-muted small">Daftarkan pasien baru beserta kunjungan pertamanya</p>
                <a href="{{ route('pasien.index') }}" class="btn btn-primary">
                    <i class="bi bi-arrow-right me-1"></i> Buka Modul
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body text-center py-4">
                <i class="bi bi-clipboard2-pulse-fill text-success fs-1 mb-3 d-block"></i>
                <h5 class="card-title fw-bold">Asesmen</h5>
                <p class="card-text text-muted small">Isi data pemeriksaan pasien rawat jalan</p>
                <a href="{{ route('asesmen.index') }}" class="btn btn-success">
                    <i class="bi bi-arrow-right me-1"></i> Buka Modul
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body text-center py-4">
                <i class="bi bi-bar-chart-line-fill text-info fs-1 mb-3 d-block"></i>
                <h5 class="card-title fw-bold">Laporan</h5>
                <p class="card-text text-muted small">Lihat laporan kunjungan dengan filter lengkap</p>
                <a href="{{ route('laporan.index') }}" class="btn btn-info text-white">
                    <i class="bi bi-arrow-right me-1"></i> Buka Modul
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
