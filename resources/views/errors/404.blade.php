@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan')

@section('content')
<div class="text-center py-5">
    <div class="mb-4">
        <i class="bi bi-exclamation-triangle text-warning" style="font-size: 5rem;"></i>
    </div>
    <h1 class="h2 fw-bold text-dark mb-2">404</h1>
    <h2 class="h5 text-muted mb-3">Halaman Tidak Ditemukan</h2>
    <p class="text-muted mb-4">
        Maaf, halaman yang Anda cari tidak ditemukan atau data tidak tersedia.
    </p>
    <div class="d-flex justify-content-center gap-2">
        <a href="{{ route('home') }}" class="btn btn-primary">
            <i class="bi bi-house-door me-1"></i> Kembali ke Dashboard
        </a>
        <a href="javascript:history.back()" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i> Halaman Sebelumnya
        </a>
    </div>
</div>
@endsection
