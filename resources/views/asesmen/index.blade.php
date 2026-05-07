@extends('layouts.app')

@section('title', 'Asesmen Rawat Jalan')

@section('breadcrumb')
<li class="breadcrumb-item active">Asesmen</li>
@endsection

@section('content')
<div class="mb-3">
    <h1 class="h4 fw-bold">Asesmen Rawat Jalan</h1>
    <p class="text-muted mb-0">Kelola asesmen untuk kunjungan pasien</p>
</div>

{{-- Antrian Kunjungan (Status: Terdaftar) --}}
<div class="card mb-4">
    <div class="card-header bg-white fw-semibold">
        <i class="bi bi-hourglass-split text-warning me-1"></i>
        Antrian Kunjungan — Menunggu Asesmen
        <span class="badge bg-warning text-dark ms-1">{{ $kunjunganTerdaftar->count() }}</span>
    </div>
    <div class="card-body p-0">
        @if($kunjunganTerdaftar->isEmpty())
        <div class="empty-state py-4">
            <i class="bi bi-check-circle"></i>
            <p class="mb-0">Tidak ada kunjungan yang menunggu asesmen.</p>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Pasien</th>
                        <th>Poli</th>
                        <th>Dokter</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($kunjunganTerdaftar as $k)
                    <tr>
                        <td>{{ $k->tanggal_kunjungan->format('d/m/Y') }}</td>
                        <td class="fw-semibold">{{ $k->pasien->nama }}</td>
                        <td>{{ $k->poli->nama_poli }}</td>
                        <td>{{ $k->dokter->nama }}</td>
                        <td class="text-end">
                            <a href="{{ route('asesmen.create', $k) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-clipboard-plus me-1"></i> Buat Asesmen
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

{{-- Riwayat Asesmen --}}
<div class="card">
    <div class="card-header bg-white fw-semibold">
        <i class="bi bi-clipboard-check text-success me-1"></i>
        Riwayat Asesmen
    </div>
    <div class="card-body p-0">
        @if($asesmenList->isEmpty())
        <div class="empty-state py-4">
            <i class="bi bi-clipboard-x"></i>
            <p class="mb-0">Belum ada data asesmen.</p>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama Pasien</th>
                        <th>Dokter</th>
                        <th>Diagnosis</th>
                        <th>Tindakan</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($asesmenList as $a)
                    <tr>
                        <td>{{ $a->kunjungan->tanggal_kunjungan->format('d/m/Y') }}</td>
                        <td class="fw-semibold">{{ $a->kunjungan->pasien->nama }}</td>
                        <td>{{ $a->kunjungan->dokter->nama }}</td>
                        <td><small>{{ Str::limit($a->diagnosis_awal, 50) }}</small></td>
                        <td><small>{{ Str::limit($a->tindakan_terapi, 50) }}</small></td>
                        <td class="text-end">
                            <a href="{{ route('asesmen.edit', $a) }}" class="btn btn-sm btn-outline-secondary"
                               data-bs-toggle="tooltip" title="Edit asesmen">
                                <i class="bi bi-pencil"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
    @if($asesmenList->hasPages())
    <div class="card-footer bg-white">{{ $asesmenList->links() }}</div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    var tooltipList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipList.map(el => new bootstrap.Tooltip(el));
</script>
@endpush
