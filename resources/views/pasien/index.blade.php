@extends('layouts.app')

@section('title', 'Daftar Pasien')

@section('breadcrumb')
<li class="breadcrumb-item active">Daftar Pasien</li>
@endsection

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 fw-bold mb-0">Daftar Pasien</h1>
    <a href="{{ route('pasien.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Daftar Pasien Baru
    </a>
</div>

{{-- Search --}}
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" action="{{ route('pasien.index') }}" class="row g-2 align-items-center">
            <div class="col-auto flex-grow-1">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Cari nama pasien..."
                           value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-primary">Cari</button>
                @if(request('search'))
                <a href="{{ route('pasien.index') }}" class="btn btn-outline-secondary">Reset</a>
                @endif
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card">
    <div class="card-body p-0">
        @if($pasien->isEmpty())
        <div class="empty-state">
            <i class="bi bi-people"></i>
            <p class="mb-0">Belum ada data pasien.</p>
            <a href="{{ route('pasien.create') }}" class="btn btn-primary btn-sm mt-2">
                <i class="bi bi-plus-lg me-1"></i> Daftar Pasien Baru
            </a>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama Pasien</th>
                        <th>Tgl Lahir / Umur</th>
                        <th>Jenis Kelamin</th>
                        <th>No HP</th>
                        <th class="text-center">Kunjungan</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($pasien as $p)
                    <tr>
                        <td class="text-muted">{{ $pasien->firstItem() + $loop->index }}</td>
                        <td class="fw-semibold">{{ $p->nama }}</td>
                        <td>
                            {{ $p->tanggal_lahir->format('d/m/Y') }}
                            <small class="text-muted">({{ $p->tanggal_lahir->age }} thn)</small>
                        </td>
                        <td>{{ $p->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td>{{ $p->no_hp }}</td>
                        <td class="text-center">
                            <span class="badge bg-primary rounded-pill">{{ $p->kunjungan_count }}</span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('pasien.edit', $p) }}" class="btn btn-sm btn-outline-secondary"
                               data-bs-toggle="tooltip" title="Edit data pasien">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a href="{{ route('pasien.kunjungan', $p) }}" class="btn btn-sm btn-outline-primary"
                               data-bs-toggle="tooltip" title="Lihat kunjungan">
                                <i class="bi bi-list-ul"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
    @if($pasien->hasPages())
    <div class="card-footer bg-white">
        {{ $pasien->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    var tooltipList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipList.map(el => new bootstrap.Tooltip(el));
</script>
@endpush
