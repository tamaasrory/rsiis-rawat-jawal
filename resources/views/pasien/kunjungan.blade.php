@extends('layouts.app')

@section('title', 'Kunjungan ' . $pasien->nama)

@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('pasien.index') }}" class="text-decoration-none">Daftar Pasien</a></li>
<li class="breadcrumb-item active">Kunjungan: {{ $pasien->nama }}</li>
@endsection

@section('content')
{{-- Info Pasien --}}
<div class="card mb-3">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h1 class="h4 fw-bold mb-1">{{ $pasien->nama }}</h1>
                <p class="text-muted mb-0">
                    {{ $pasien->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }} &middot;
                    {{ $pasien->tanggal_lahir->format('d/m/Y') }} ({{ $pasien->tanggal_lahir->age }} tahun) &middot;
                    <i class="bi bi-telephone"></i> {{ $pasien->no_hp }}
                </p>
            </div>
            <div class="col-md-6 text-md-end mt-2 mt-md-0">
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTambahKunjungan">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Kunjungan
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Riwayat Kunjungan --}}
<div class="card">
    <div class="card-header bg-white fw-semibold">
        <i class="bi bi-list-ul me-1"></i> Riwayat Kunjungan
    </div>
    <div class="card-body p-0">
        @if($kunjungan->isEmpty())
        <div class="empty-state">
            <i class="bi bi-calendar-x"></i>
            <p>Belum ada riwayat kunjungan.</p>
        </div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Poli</th>
                        <th>Dokter</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                        <th>Diagnosis</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($kunjungan as $k)
                    <tr>
                        <td>{{ $k->tanggal_kunjungan->format('d/m/Y') }}</td>
                        <td>{{ $k->poli->nama_poli }}</td>
                        <td>{{ $k->dokter->nama }}</td>
                        <td>{{ $k->jenis_pembayaran }}</td>
                        <td>
                            @if($k->status === \App\Models\Kunjungan::STATUS_TERDAFTAR)
                                <span class="badge bg-warning text-dark">Terdaftar</span>
                            @elseif($k->status === \App\Models\Kunjungan::STATUS_SUDAH_ASESMEN)
                                <span class="badge bg-success">Sudah Asesmen</span>
                            @else
                                <span class="badge bg-secondary">Batal</span>
                            @endif
                        </td>
                        <td>
                            @if($k->asesmen)
                                <small>{{ Str::limit($k->asesmen->diagnosis_awal, 40) }}</small>
                            @else
                                <small class="text-muted">-</small>
                            @endif
                        </td>
                        <td class="text-end">
                            @if($k->bisaDibatalkan())
                            <button class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalBatal{{ $k->id }}"
                                    title="Batalkan kunjungan">
                                <i class="bi bi-x-circle"></i>
                            </button>
                            @endif
                            @if($k->asesmen)
                            <a href="{{ route('asesmen.edit', $k->asesmen) }}"
                               class="btn btn-sm btn-outline-success" title="Edit asesmen">
                                <i class="bi bi-clipboard-check"></i>
                            </a>
                            @elseif($k->bisaDiasesmen())
                            <a href="{{ route('asesmen.create', $k) }}"
                               class="btn btn-sm btn-outline-primary" title="Buat asesmen">
                                <i class="bi bi-clipboard-plus"></i>
                            </a>
                            @endif
                        </td>
                    </tr>

                    {{-- Modal Batal --}}
                    @if($k->bisaDibatalkan())
                    <div class="modal fade" id="modalBatal{{ $k->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Konfirmasi Pembatalan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah Anda yakin ingin membatalkan kunjungan ini?</p>
                                    <ul class="list-unstyled text-muted small">
                                        <li><strong>Pasien:</strong> {{ $pasien->nama }}</li>
                                        <li><strong>Tanggal:</strong> {{ $k->tanggal_kunjungan->format('d/m/Y') }}</li>
                                        <li><strong>Poli:</strong> {{ $k->poli->nama_poli }}</li>
                                        <li><strong>Dokter:</strong> {{ $k->dokter->nama }}</li>
                                    </ul>
                                    <p class="text-danger small mb-0">
                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                        Tindakan ini tidak dapat dibatalkan.
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Tutup</button>
                                    <form method="POST" action="{{ route('kunjungan.batal', $k) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-x-circle me-1"></i> Ya, Batalkan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
    @if($kunjungan->hasPages())
    <div class="card-footer bg-white">{{ $kunjungan->links() }}</div>
    @endif
</div>

{{-- Modal Tambah Kunjungan --}}
<div class="modal fade" id="modalTambahKunjungan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('kunjungan.store', $pasien) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kunjungan Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="m_tanggal_kunjungan" class="form-label">Tanggal Kunjungan *</label>
                        <input type="date" name="tanggal_kunjungan" id="m_tanggal_kunjungan"
                               class="form-control" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="m_poli_id" class="form-label">Poli Tujuan *</label>
                        <select name="poli_id" id="m_poli_id" class="form-select" required>
                            <option value="">-- Pilih Poli --</option>
                            @foreach($poli as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_poli }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="m_dokter_id" class="form-label">Dokter *</label>
                        <select name="dokter_id" id="m_dokter_id" class="form-select" required>
                            <option value="">-- Pilih Dokter --</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="m_jenis_pembayaran" class="form-label">Jenis Pembayaran *</label>
                        <select name="jenis_pembayaran" id="m_jenis_pembayaran" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="BPJS">BPJS</option>
                            <option value="Umum">Umum</option>
                            <option value="Asuransi">Asuransi</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const dokterData = @json($dokter);

    // Filter dokter di modal tambah kunjungan
    const mPoliSelect = document.getElementById('m_poli_id');
    const mDokterSelect = document.getElementById('m_dokter_id');

    mPoliSelect.addEventListener('change', function() {
        const poliId = this.value;
        mDokterSelect.innerHTML = '<option value="">-- Pilih Dokter --</option>';
        if (!poliId) return;
        dokterData.filter(d => d.poli_id == poliId).forEach(d => {
            const opt = document.createElement('option');
            opt.value = d.id;
            opt.textContent = d.nama;
            mDokterSelect.appendChild(opt);
        });
    });
</script>
@endpush
