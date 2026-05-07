# PROJECT BRIEF — Aplikasi Pencatatan Pasien Rawat Jalan

> **Dokumen ini adalah master brief untuk AI Agent (atau developer) yang akan mengeksekusi project.**
> Baca dokumen ini secara menyeluruh sebelum menulis baris kode pertama. Setiap bagian dirancang untuk meminimalkan asumsi dan ambiguitas.

---

## 1. KONTEKS & TUJUAN

### 1.1 Latar Belakang

Project ini adalah **tes praktek IT Programmer** dengan durasi pengerjaan **2 jam 15 menit**. Output adalah aplikasi web sederhana untuk pencatatan pasien rawat jalan di fasilitas kesehatan.

### 1.2 Tujuan Utama

Membangun aplikasi yang mendemonstrasikan kemampuan dalam:

1. Merancang struktur database yang ternormalisasi dengan relasi yang tepat
2. Menulis logic program yang clean dan maintainable
3. Membuat query laporan yang efisien dengan multiple filter
4. Membangun UI yang rapi dan usable
5. Melakukan validasi input dan error handling yang baik

### 1.3 Aspek Penilaian (8 poin)

| No | Aspek | Bobot Implisit |
|----|-------|----------------|
| 1 | Struktur database | Tinggi |
| 2 | Relasi antar tabel | Tinggi |
| 3 | Kerapihan code | Tinggi |
| 4 | Logic program | Tinggi |
| 5 | Query laporan | Tinggi |
| 6 | Tampilan dan usability | Sedang |
| 7 | Validasi input | Sedang |
| 8 | Kemampuan menggunakan AI secara efektif | Sedang |

### 1.4 Nilai Tambahan

- UI yang rapi dan nyaman digunakan
- Error handling yang baik

---

## 2. CONSTRAINTS & TECHNICAL REQUIREMENTS

### 2.1 Tech Stack (WAJIB)

- **Bahasa**: PHP berbasis OOP
- **Framework**: Laravel 12 (wajib)
- **Database**: MySQL atau MariaDB
- **Frontend**: Bootstrap 5 (untuk efisiensi waktu)

### 2.2 Larangan

- ❌ **TIDAK BOLEH** menggunakan project CRUD generator yang sudah jadi
- ❌ **TIDAK BOLEH** menggunakan database selain MySQL/MariaDB
- ❌ **TIDAK BOLEH** procedural PHP murni — wajib OOP

### 2.3 Diizinkan

- ✅ Menggunakan internet untuk referensi
- ✅ Menggunakan AI tools (sebagai bagian dari penilaian)
- ✅ Menggunakan library/package open source

### 2.4 Submission Requirements

| Item | Detail |
|------|--------|
| Repository | GitHub **public** |
| Branch | **Single branch saja** (gunakan `main`) |
| File SQL | **WAJIB di-commit** ke repository |
| README.md | Singkat, berisi cara menjalankan project |
| Email tujuan | `itrsipku@gmail.com` |
| Subject email | `NAMA – IT Programmer TES Praktek` |
| Isi email | Link repo GitHub |

---

## 3. USER STORIES

### 3.1 Persona

- **Petugas Pendaftaran** — staff yang menerima dan mendaftarkan pasien
- **Dokter / Perawat** — pengisi data asesmen
- **Admin / Supervisor** — pengakses laporan

> **Catatan**: Aplikasi ini TIDAK memerlukan sistem login multi-role. Anggap semua user dapat mengakses semua fitur (single-user app untuk simplifikasi sesuai scope tes).

### 3.2 User Stories — Modul Pendaftaran

**US-01: Mendaftarkan pasien baru beserta kunjungan pertama**
> Sebagai petugas pendaftaran, saya ingin mendaftarkan pasien baru dengan data dirinya dan informasi kunjungan pertamanya, agar pasien dapat dilanjutkan ke proses asesmen.

**Acceptance Criteria:**

- Form berisi data pasien (nama, tanggal lahir, jenis kelamin, no HP, alamat) DAN data kunjungan (tanggal kunjungan, poli tujuan, dokter, jenis pembayaran) dalam satu form
- Semua field wajib diisi (kecuali field yang memang opsional)
- Setelah submit, data tersimpan di tabel `pasien` dan `kunjungan` (transactional)
- Status kunjungan otomatis = `terdaftar`
- User di-redirect ke list pasien dengan flash message sukses

**US-02: Melihat daftar pasien & kunjungan**
> Sebagai petugas pendaftaran, saya ingin melihat daftar pasien yang sudah terdaftar agar dapat mengelola data mereka.

**Acceptance Criteria:**

- Tabel menampilkan: nama pasien, tanggal lahir/umur, no HP, jumlah kunjungan
- Ada tombol **Edit** dan **Lihat Kunjungan** per row
- Pagination jika data > 10
- Search/filter sederhana (opsional, nilai plus)

**US-03: Mengedit data pasien**
> Sebagai petugas, saya ingin mengedit data pasien yang sudah terdaftar untuk mengoreksi kesalahan input.

**Acceptance Criteria:**

- Form pre-filled dengan data existing
- Validasi sama dengan form pendaftaran
- Setelah simpan, redirect ke list dengan flash message

**US-04: Membatalkan kunjungan**
> Sebagai petugas, saya ingin membatalkan kunjungan pasien yang batal datang, agar tidak masuk ke proses asesmen.

**Acceptance Criteria:**

- Tombol "Batal Kunjungan" muncul hanya untuk kunjungan dengan status `terdaftar`
- Klik tombol → muncul modal konfirmasi
- Setelah dikonfirmasi, status kunjungan berubah ke `batal`
- Kunjungan yang sudah `batal` atau `sudah_asesmen` TIDAK BISA dibatalkan
- Flash message konfirmasi

### 3.3 User Stories — Modul Asesmen

**US-05: Membuat asesmen untuk kunjungan**
> Sebagai dokter, saya ingin mengisi data asesmen untuk pasien yang sedang berkunjung, agar terdokumentasi diagnosis dan tindakannya.

**Acceptance Criteria:**

- Halaman asesmen menampilkan list kunjungan yang status-nya `terdaftar`
- Pilih kunjungan → masuk ke form asesmen
- Form berisi: keluhan utama, tekanan darah, suhu tubuh, berat badan, diagnosis awal, tindakan/terapi, catatan dokter
- Setelah simpan, status kunjungan berubah ke `sudah_asesmen`
- Satu kunjungan hanya bisa punya satu asesmen (one-to-one)

**US-06: Mengedit asesmen**
> Sebagai dokter, saya ingin mengedit asesmen yang sudah dibuat untuk koreksi atau update.

**Acceptance Criteria:**

- Form edit pre-filled dengan data asesmen existing
- Status kunjungan tetap `sudah_asesmen` setelah edit

**US-07: Melihat riwayat asesmen pasien**
> Sebagai dokter, saya ingin melihat riwayat asesmen pasien dari kunjungan-kunjungan sebelumnya, agar dapat memberikan perawatan yang lebih tepat.

**Acceptance Criteria:**

- Halaman per pasien menampilkan list asesmen-nya secara kronologis
- Tiap entry menampilkan: tanggal kunjungan, dokter, diagnosis, tindakan
- Sortir terbaru di atas

### 3.4 User Stories — Modul Laporan

**US-08: Melihat laporan kunjungan**
> Sebagai admin, saya ingin melihat laporan kunjungan dengan filter, agar bisa menganalisis aktivitas klinik.

**Acceptance Criteria:**

- Tabel menampilkan: tanggal kunjungan, nama pasien, poli, dokter, diagnosis awal, status
- Filter tersedia:
  - Nama pasien (text search, LIKE)
  - Rentang tanggal kunjungan (dari–sampai)
  - Dokter (dropdown)
  - Diagnosis (text search, LIKE)
  - Status (dropdown: terdaftar / sudah asesmen / batal)
- Filter dapat dikombinasi (AND)
- Ringkasan jumlah total kunjungan ditampilkan sesuai filter aktif
- Pagination tetap berfungsi setelah filter
- Default sort: tanggal kunjungan terbaru di atas

---

## 4. SYSTEM FLOW

### 4.1 High-Level Flow

```
┌─────────────────┐     ┌─────────────────┐     ┌─────────────────┐
│   PENDAFTARAN   │ ──> │     ASESMEN     │ ──> │     LAPORAN     │
│     PASIEN      │     │   RAWAT JALAN   │     │      DATA       │
└─────────────────┘     └─────────────────┘     └─────────────────┘
        │                       │                       │
        │                       │                       │
        ▼                       ▼                       ▼
   Status:                 Status:                  View only
   "terdaftar"             "sudah_asesmen"
        │                       │
        │                       │
        └───> Status: "batal" <─┘ (hanya jika belum asesmen)
```

### 4.2 Detailed Flow — Pendaftaran Pasien

```
START
  │
  ▼
[User membuka halaman Pendaftaran]
  │
  ▼
[User klik "Daftar Pasien Baru"]
  │
  ▼
[Form pendaftaran ditampilkan]
  │
  ▼
[User mengisi data pasien + data kunjungan]
  │
  ▼
[User klik Simpan]
  │
  ▼
{Validasi input}
  │
  ├── GAGAL ──> [Tampilkan error di form] ──> Kembali ke form
  │
  └── BERHASIL
        │
        ▼
   [Begin DB Transaction]
        │
        ▼
   [INSERT ke tabel pasien]
        │
        ▼
   [INSERT ke tabel kunjungan dgn status='terdaftar']
        │
        ▼
   [Commit Transaction]
        │
        ├── ERROR ──> [Rollback] ──> [Flash error]
        │
        └── SUKSES
              │
              ▼
        [Flash success]
              │
              ▼
        [Redirect ke list pasien]
              │
              ▼
            END
```

### 4.3 Detailed Flow — Asesmen

```
START
  │
  ▼
[User membuka halaman Asesmen]
  │
  ▼
[Sistem tampilkan list kunjungan dgn status='terdaftar']
  │
  ▼
[User pilih kunjungan]
  │
  ▼
[Form asesmen ditampilkan, header berisi info pasien & kunjungan]
  │
  ▼
[User mengisi 7 field asesmen]
  │
  ▼
[User klik Simpan]
  │
  ▼
{Validasi input}
  │
  ├── GAGAL ──> [Tampilkan error] ──> Kembali ke form
  │
  └── BERHASIL
        │
        ▼
   [Begin DB Transaction]
        │
        ▼
   [INSERT ke tabel asesmen dgn kunjungan_id]
        │
        ▼
   [UPDATE kunjungan SET status='sudah_asesmen' WHERE id=...]
        │
        ▼
   [Commit Transaction]
        │
        ▼
   [Flash success]
        │
        ▼
   [Redirect ke detail asesmen / list asesmen]
        │
        ▼
      END
```

### 4.4 Detailed Flow — Batal Kunjungan

```
START
  │
  ▼
[User klik "Batal" pada row kunjungan]
  │
  ▼
{Cek status kunjungan}
  │
  ├── status='sudah_asesmen' atau 'batal' ──> [Tampilkan error] ──> END
  │
  └── status='terdaftar'
        │
        ▼
   [Tampilkan modal konfirmasi]
        │
        ▼
   [User konfirmasi]
        │
        ▼
   [UPDATE kunjungan SET status='batal']
        │
        ▼
   [Flash success]
        │
        ▼
      END
```

### 4.5 Detailed Flow — Laporan

```
START
  │
  ▼
[User membuka halaman Laporan]
  │
  ▼
[Form filter ditampilkan + tabel dengan data default]
  │
  ▼
[User mengisi filter (opsional)]
  │
  ▼
[User klik "Filter" atau auto-submit]
  │
  ▼
[Build query Eloquent dgn when() chaining]
  │
  ▼
[Eager load relasi: pasien, dokter, poli, asesmen]
  │
  ▼
[Apply pagination]
  │
  ▼
[Hitung total count untuk ringkasan]
  │
  ▼
[Render view dgn data, filter values, dan total]
  │
  ▼
END
```

---

## 5. STRUKTUR DATABASE

### 5.1 Entity Relationship Diagram (Text)

```
┌─────────────┐       ┌──────────────┐       ┌──────────────┐
│   pasien    │       │  kunjungan   │       │   asesmen    │
├─────────────┤       ├──────────────┤       ├──────────────┤
│ id (PK)     │ 1───n │ id (PK)      │ 1───1 │ id (PK)      │
│ nama        │       │ pasien_id FK │       │ kunjungan_id │
│ tgl_lahir   │       │ poli_id   FK │       │ keluhan      │
│ jns_kelamin │       │ dokter_id FK │       │ tek_darah    │
│ no_hp       │       │ tgl_kunjung  │       │ suhu         │
│ alamat      │       │ jns_bayar    │       │ berat_badan  │
│ timestamps  │       │ status       │       │ diagnosis    │
└─────────────┘       │ timestamps   │       │ tindakan     │
                      └──────────────┘       │ catatan      │
                          │      │           │ timestamps   │
                          │      │           └──────────────┘
                          n      n
                          │      │
                          │      ▼
                          │  ┌────────┐
                          │  │ dokter │
                          │  ├────────┤
                          │  │ id PK  │
                          │  │ nama   │
                          │  │ poli_id│ FK
                          │  └────────┘
                          ▼       │
                       ┌──────┐   │
                       │ poli │ ◄─┘
                       ├──────┤
                       │ id PK│
                       │ nama │
                       └──────┘
```

### 5.2 Detail Schema

#### Tabel `pasien`

| Kolom | Tipe | Constraint | Keterangan |
|-------|------|------------|------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | |
| nama | VARCHAR(100) | NOT NULL | |
| tanggal_lahir | DATE | NOT NULL | |
| jenis_kelamin | ENUM('L','P') | NOT NULL | |
| no_hp | VARCHAR(20) | NOT NULL | |
| alamat | TEXT | NOT NULL | |
| created_at | TIMESTAMP | NULLABLE | |
| updated_at | TIMESTAMP | NULLABLE | |

**Index:** `idx_nama` pada kolom `nama` (untuk pencarian)

#### Tabel `poli`

| Kolom | Tipe | Constraint |
|-------|------|------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT |
| nama_poli | VARCHAR(50) | NOT NULL, UNIQUE |
| created_at | TIMESTAMP | NULLABLE |
| updated_at | TIMESTAMP | NULLABLE |

**Seed data:** Umum, Gigi, Anak, Penyakit Dalam, Kandungan, Mata

#### Tabel `dokter`

| Kolom | Tipe | Constraint |
|-------|------|------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT |
| nama | VARCHAR(100) | NOT NULL |
| spesialisasi | VARCHAR(100) | NULLABLE |
| poli_id | BIGINT UNSIGNED | FK → poli.id, NOT NULL |
| created_at | TIMESTAMP | NULLABLE |
| updated_at | TIMESTAMP | NULLABLE |

**Foreign Key:** `poli_id` REFERENCES `poli(id)` ON DELETE RESTRICT

#### Tabel `kunjungan`

| Kolom | Tipe | Constraint |
|-------|------|------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT |
| pasien_id | BIGINT UNSIGNED | FK → pasien.id, NOT NULL |
| poli_id | BIGINT UNSIGNED | FK → poli.id, NOT NULL |
| dokter_id | BIGINT UNSIGNED | FK → dokter.id, NOT NULL |
| tanggal_kunjungan | DATE | NOT NULL |
| jenis_pembayaran | ENUM('BPJS','Umum','Asuransi') | NOT NULL |
| status | ENUM('terdaftar','sudah_asesmen','batal') | NOT NULL, DEFAULT 'terdaftar' |
| created_at | TIMESTAMP | NULLABLE |
| updated_at | TIMESTAMP | NULLABLE |

**Foreign Keys:**

- `pasien_id` REFERENCES `pasien(id)` ON DELETE CASCADE
- `poli_id` REFERENCES `poli(id)` ON DELETE RESTRICT
- `dokter_id` REFERENCES `dokter(id)` ON DELETE RESTRICT

**Index:**

- `idx_status` pada `status`
- `idx_tanggal` pada `tanggal_kunjungan`
- Composite: `(pasien_id, tanggal_kunjungan)`

#### Tabel `asesmen`

| Kolom | Tipe | Constraint |
|-------|------|------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT |
| kunjungan_id | BIGINT UNSIGNED | FK → kunjungan.id, NOT NULL, UNIQUE |
| keluhan_utama | TEXT | NOT NULL |
| tekanan_darah | VARCHAR(10) | NOT NULL |
| suhu_tubuh | DECIMAL(4,1) | NOT NULL |
| berat_badan | DECIMAL(5,2) | NOT NULL |
| diagnosis_awal | TEXT | NOT NULL |
| tindakan_terapi | TEXT | NOT NULL |
| catatan_dokter | TEXT | NULLABLE |
| created_at | TIMESTAMP | NULLABLE |
| updated_at | TIMESTAMP | NULLABLE |

**Foreign Key:** `kunjungan_id` REFERENCES `kunjungan(id)` ON DELETE CASCADE

**UNIQUE constraint:** `kunjungan_id` (memastikan one-to-one)

### 5.3 Eloquent Relationships

```php
// Pasien.php
public function kunjungan() {
    return $this->hasMany(Kunjungan::class);
}

// Poli.php
public function dokter() {
    return $this->hasMany(Dokter::class);
}
public function kunjungan() {
    return $this->hasMany(Kunjungan::class);
}

// Dokter.php
public function poli() {
    return $this->belongsTo(Poli::class);
}
public function kunjungan() {
    return $this->hasMany(Kunjungan::class);
}

// Kunjungan.php
public function pasien() {
    return $this->belongsTo(Pasien::class);
}
public function poli() {
    return $this->belongsTo(Poli::class);
}
public function dokter() {
    return $this->belongsTo(Dokter::class);
}
public function asesmen() {
    return $this->hasOne(Asesmen::class);
}

// Asesmen.php
public function kunjungan() {
    return $this->belongsTo(Kunjungan::class);
}
```

---

## 6. BUSINESS RULES & BOUNDARIES

### 6.1 State Machine — Status Kunjungan

```
                   ┌─────────────┐
                   │  terdaftar  │ (initial state saat insert)
                   └─────┬───────┘
                         │
              ┌──────────┴──────────┐
              │                     │
    [submit asesmen]        [klik batal]
              │                     │
              ▼                     ▼
    ┌─────────────────┐      ┌──────────┐
    │ sudah_asesmen   │      │  batal   │
    └─────────────────┘      └──────────┘
        (terminal)              (terminal)
```

**Transisi yang DILARANG:**

- `sudah_asesmen` → `batal` ❌
- `sudah_asesmen` → `terdaftar` ❌
- `batal` → `sudah_asesmen` ❌
- `batal` → `terdaftar` ❌

### 6.2 Business Rules

1. **BR-01**: Satu kunjungan hanya boleh memiliki maksimal satu asesmen.
2. **BR-02**: Asesmen hanya bisa dibuat untuk kunjungan dengan status `terdaftar`.
3. **BR-03**: Pembatalan hanya bisa dilakukan untuk kunjungan dengan status `terdaftar`.
4. **BR-04**: Pasien dapat memiliki banyak kunjungan (riwayat kunjungan).
5. **BR-05**: Tanggal kunjungan tidak boleh di masa lalu saat pendaftaran baru (boleh di-edit menjadi masa lalu untuk koreksi data historis — opsional).
6. **BR-06**: Data pasien tidak boleh dihapus jika memiliki kunjungan terkait (hanya soft-delete atau restrict).
7. **BR-07**: Edit data pasien tidak mengubah data kunjungan yang sudah ada.

### 6.3 Validation Rules

#### Form Pendaftaran — Data Pasien

| Field | Rules |
|-------|-------|
| nama | required, string, min:3, max:100 |
| tanggal_lahir | required, date, before:today |
| jenis_kelamin | required, in:L,P |
| no_hp | required, regex:/^[0-9+\-\s]+$/, min:10, max:15 |
| alamat | required, string, max:500 |

#### Form Pendaftaran — Data Kunjungan

| Field | Rules |
|-------|-------|
| tanggal_kunjungan | required, date, after_or_equal:today |
| poli_id | required, exists:poli,id |
| dokter_id | required, exists:dokter,id |
| jenis_pembayaran | required, in:BPJS,Umum,Asuransi |

#### Form Asesmen

| Field | Rules |
|-------|-------|
| kunjungan_id | required, exists:kunjungan,id |
| keluhan_utama | required, string, max:1000 |
| tekanan_darah | required, regex:/^\d{2,3}\/\d{2,3}$/ (format: "120/80") |
| suhu_tubuh | required, numeric, between:30,45 |
| berat_badan | required, numeric, between:1,300 |
| diagnosis_awal | required, string, max:500 |
| tindakan_terapi | required, string, max:1000 |
| catatan_dokter | nullable, string, max:1000 |

### 6.4 Error Handling Standards

1. Semua operasi tulis multi-tabel **HARUS** dibungkus DB transaction
2. Try-catch wajib di controller untuk operasi DB
3. Flash message harus informatif (tidak generic seperti "Error")
4. Validation errors ditampilkan inline di form (gunakan Bootstrap `is-invalid` class)
5. Custom 404 page untuk record tidak ditemukan
6. Logging error ke `storage/logs/laravel.log`

---

## 7. UI / UX REQUIREMENTS

### 7.1 Layout Standard

```
┌────────────────────────────────────────────────┐
│ NAVBAR                                          │
│ [Logo] Pendaftaran | Asesmen | Laporan         │
├────────────────────────────────────────────────┤
│                                                 │
│ [Breadcrumb]                                    │
│                                                 │
│ [Flash Message Area]                            │
│                                                 │
│ [Page Title + Action Button]                    │
│                                                 │
│ [Content / Form / Table]                        │
│                                                 │
│ [Pagination if needed]                          │
│                                                 │
├────────────────────────────────────────────────┤
│ FOOTER (optional, simple)                       │
└────────────────────────────────────────────────┘
```

### 7.2 Halaman yang HARUS Ada

| Route | Halaman | Tujuan |
|-------|---------|--------|
| `/` | Dashboard / Home | Landing, link ke 3 modul utama |
| `/pasien` | List Pasien | Daftar pasien dengan tombol aksi |
| `/pasien/create` | Form Pendaftaran | Form pasien + kunjungan baru |
| `/pasien/{id}/edit` | Form Edit Pasien | Edit data pasien |
| `/pasien/{id}/kunjungan` | Detail Kunjungan Pasien | Riwayat kunjungan pasien |
| `/kunjungan/{id}/batal` | Action Batal | (POST only, redirect) |
| `/asesmen` | List Asesmen | List kunjungan yang siap di-asesmen + asesmen yang sudah ada |
| `/asesmen/create/{kunjungan_id}` | Form Asesmen | Buat asesmen baru |
| `/asesmen/{id}/edit` | Form Edit Asesmen | Edit asesmen existing |
| `/laporan` | Laporan Kunjungan | Tabel + filter + ringkasan |

### 7.3 UI Component Checklist

- ✅ Navbar dengan menu jelas mengikuti alur (Pendaftaran → Asesmen → Laporan)
- ✅ Breadcrumb di setiap halaman selain home
- ✅ Flash message dengan icon (Bootstrap alert: success/danger/warning)
- ✅ Modal konfirmasi untuk aksi destruktif (batal kunjungan)
- ✅ Pagination di list pasien dan laporan
- ✅ Empty state ("Belum ada data pasien") jika kosong
- ✅ Loading state pada button form submission (`disabled` saat submit)
- ✅ Badge untuk status kunjungan (warna berbeda per status)
- ✅ Tooltip pada icon button (Edit, Batal, Lihat)
- ✅ Konfirmasi sebelum keluar form yang belum disimpan (opsional)

### 7.4 Color Coding Status

| Status | Badge Class |
|--------|-------------|
| terdaftar | `bg-warning text-dark` (kuning) |
| sudah_asesmen | `bg-success` (hijau) |
| batal | `bg-secondary` (abu-abu) |

---

## 8. STRUKTUR FOLDER & CODE ORGANIZATION

### 8.1 Direktori Penting

```
rawat-jalan/
├── app/
│   ├── Models/
│   │   ├── Pasien.php
│   │   ├── Kunjungan.php
│   │   ├── Asesmen.php
│   │   ├── Dokter.php
│   │   └── Poli.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── HomeController.php
│   │   │   ├── PasienController.php
│   │   │   ├── KunjunganController.php
│   │   │   ├── AsesmenController.php
│   │   │   └── LaporanController.php
│   │   └── Requests/
│   │       ├── StorePasienRequest.php
│   │       ├── UpdatePasienRequest.php
│   │       └── StoreAsesmenRequest.php
├── database/
│   ├── migrations/
│   │   ├── xxxx_create_poli_table.php
│   │   ├── xxxx_create_dokter_table.php
│   │   ├── xxxx_create_pasien_table.php
│   │   ├── xxxx_create_kunjungan_table.php
│   │   └── xxxx_create_asesmen_table.php
│   ├── seeders/
│   │   ├── DatabaseSeeder.php
│   │   ├── PoliSeeder.php
│   │   └── DokterSeeder.php
│   └── sql/
│       └── rawat_jalan.sql       ← WAJIB COMMIT FILE INI
├── resources/views/
│   ├── layouts/
│   │   └── app.blade.php
│   ├── partials/
│   │   ├── navbar.blade.php
│   │   ├── flash.blade.php
│   │   └── breadcrumb.blade.php
│   ├── home/
│   │   └── index.blade.php
│   ├── pasien/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   └── kunjungan.blade.php
│   ├── asesmen/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   └── laporan/
│       └── index.blade.php
├── routes/
│   └── web.php
├── README.md                     ← WAJIB ADA
└── .env.example
```

### 8.2 Code Quality Standards

1. **PSR-12** coding standard
2. **Single Responsibility** per controller method
3. **FormRequest** untuk semua validasi (jangan inline di controller)
4. **Eloquent scope** untuk query yang sering dipakai
5. **Resource Controller** pattern (index, create, store, edit, update, destroy)
6. **Blade components** untuk elemen UI yang reusable (mis. flash message)
7. **No magic numbers** — gunakan const atau enum
8. **Komentar** hanya untuk logika non-obvious
9. **Variable naming**: gunakan bahasa Indonesia yang konsisten dengan domain (e.g., `$pasien`, `$kunjungan`) — boleh juga English asal konsisten

### 8.3 Contoh Pattern Controller (Reference)

```php
class PasienController extends Controller
{
    public function index(Request $request)
    {
        $pasien = Pasien::withCount('kunjungan')
            ->when($request->search, fn($q, $v) =>
                $q->where('nama', 'like', "%{$v}%"))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('pasien.index', compact('pasien'));
    }

    public function store(StorePasienRequest $request)
    {
        try {
            DB::beginTransaction();

            $pasien = Pasien::create($request->validated());

            $pasien->kunjungan()->create([
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
                'poli_id' => $request->poli_id,
                'dokter_id' => $request->dokter_id,
                'jenis_pembayaran' => $request->jenis_pembayaran,
                'status' => 'terdaftar',
            ]);

            DB::commit();

            return redirect()
                ->route('pasien.index')
                ->with('success', 'Pasien berhasil didaftarkan');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return back()
                ->withInput()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
}
```

### 8.4 Contoh Query Laporan (Reference)

```php
class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kunjungan::with(['pasien', 'dokter', 'poli', 'asesmen'])
            ->when($request->nama, fn($q, $v) =>
                $q->whereHas('pasien', fn($q) =>
                    $q->where('nama', 'like', "%{$v}%")))
            ->when($request->dokter_id, fn($q, $v) =>
                $q->where('dokter_id', $v))
            ->when($request->status, fn($q, $v) =>
                $q->where('status', $v))
            ->when($request->diagnosis, fn($q, $v) =>
                $q->whereHas('asesmen', fn($q) =>
                    $q->where('diagnosis_awal', 'like', "%{$v}%")))
            ->when($request->tanggal_dari, fn($q, $v) =>
                $q->where('tanggal_kunjungan', '>=', $v))
            ->when($request->tanggal_sampai, fn($q, $v) =>
                $q->where('tanggal_kunjungan', '<=', $v))
            ->orderBy('tanggal_kunjungan', 'desc');

        $total = $query->count();
        $kunjungan = $query->paginate(20)->withQueryString();
        $dokter = Dokter::orderBy('nama')->get();

        return view('laporan.index', compact('kunjungan', 'total', 'dokter'));
    }
}
```

---

## 9. INSTRUKSI EKSPLISIT UNTUK AI AGENT

Bagian ini berisi instruksi yang **WAJIB** diikuti AI agent saat mengeksekusi project ini.

### 9.1 DO (Lakukan)

1. **Baca dokumen ini sepenuhnya** sebelum menulis kode
2. **Ikuti urutan fase** yang ada di Section 10 (Roadmap)
3. **Test setiap fitur** setelah selesai sebelum lanjut fitur berikutnya
4. **Commit per milestone** dengan pesan commit yang deskriptif
5. **Gunakan FormRequest** untuk validasi, jangan inline `$request->validate()` di controller
6. **Bungkus operasi multi-tabel dengan DB Transaction**
7. **Eager load relasi** dengan `with()` untuk hindari N+1
8. **Gunakan Blade `@error` dan `@old`** untuk validation feedback
9. **Tampilkan flash message** setelah setiap aksi sukses/gagal
10. **Test ulang aplikasi end-to-end** sebelum push final

### 9.2 DON'T (Hindari)

1. **JANGAN** menggunakan generator CRUD seperti Laravel Backpack atau Voyager
2. **JANGAN** skip validasi karena "asumsi user akan input benar"
3. **JANGAN** menulis query mentah jika Eloquent bisa handle
4. **JANGAN** menempatkan logika bisnis di view (Blade)
5. **JANGAN** commit file `.env`, `node_modules/`, atau `vendor/`
6. **JANGAN** lupa export SQL ke `database/sql/` sebelum push
7. **JANGAN** hardcode nilai seperti `'terdaftar'` di banyak tempat — gunakan const di Model
8. **JANGAN** buat banyak branch — single branch `main` saja
9. **JANGAN** lupa test transisi state (terdaftar → sudah_asesmen, terdaftar → batal)
10. **JANGAN** tampilkan error teknis ke user — tampilkan pesan friendly

### 9.3 Commit Message Convention

```
feat: tambah fitur pendaftaran pasien
fix: perbaiki validasi tanggal kunjungan
refactor: pisahkan logic asesmen ke FormRequest
style: rapikan tampilan list pasien
docs: update README cara install
db: tambah seeder untuk dokter dan poli
```

### 9.4 Definition of Done (per fitur)

Sebuah fitur dianggap selesai jika:

- [x] Migration sudah jalan tanpa error
- [x] Model sudah punya relasi yang benar
- [x] Controller method lengkap (CRUD sesuai kebutuhan)
- [x] FormRequest sudah dibuat & dipakai
- [x] View sudah selesai dengan styling Bootstrap
- [x] Validasi sudah teruji (coba input invalid)
- [x] Flash message muncul setelah aksi
- [x] Sudah di-commit dengan pesan deskriptif

---

## 10. ROADMAP & TIMELINE

**Total: 2 jam 15 menit (135 menit)**

| Fase | Durasi | Aktivitas | Output |
|------|--------|-----------|--------|
| **0** | 5 mnt | Setup repo GitHub + Laravel install | Repo public, Laravel running |
| **1** | 15 mnt | Database design: migration, seeder, relasi Eloquent | DB schema lengkap, seed data poli & dokter |
| **2** | 30 mnt | Modul Pendaftaran (Pasien + Kunjungan) | List, Create, Edit, Batal kunjungan |
| **3** | 25 mnt | Modul Asesmen | List, Create, Edit, Riwayat |
| **4** | 25 mnt | Modul Laporan | Filter lengkap, ringkasan, pagination |
| **5** | 20 mnt | Polish UI (navbar, badge, modal, empty state) | UI rapi & konsisten |
| **6** | 10 mnt | Testing E2E + Bug fix | Semua flow jalan tanpa error |
| **7** | 5 mnt | Export SQL, README, push final, kirim email | Submission selesai |

---

## 11. CHECKLIST FINAL SEBELUM SUBMIT

```
SETUP & DELIVERABLE
[ ] Repo GitHub public
[ ] Hanya 1 branch (main)
[ ] File .sql di database/sql/ ter-commit
[ ] README.md jelas dan lengkap
[ ] .gitignore benar (tidak commit .env, vendor, node_modules)

DATABASE
[ ] Migration jalan tanpa error
[ ] Foreign key constraint benar
[ ] Seeder untuk poli dan dokter berfungsi
[ ] Relasi Eloquent semua sudah didefinisikan

FITUR PENDAFTARAN
[ ] Form input semua field benar
[ ] Validasi berfungsi
[ ] Data tersimpan di pasien & kunjungan (transaksional)
[ ] List pasien tampil
[ ] Edit data pasien berfungsi
[ ] Batal kunjungan dengan modal konfirmasi

FITUR ASESMEN
[ ] List kunjungan yang siap asesmen tampil
[ ] Form asesmen lengkap (7 field)
[ ] Status kunjungan auto-update ke sudah_asesmen
[ ] Edit asesmen berfungsi
[ ] Riwayat asesmen per pasien tampil

FITUR LAPORAN
[ ] Tabel menampilkan kolom sesuai requirement
[ ] Filter nama (LIKE) berfungsi
[ ] Filter tanggal (range) berfungsi
[ ] Filter dokter (dropdown) berfungsi
[ ] Filter diagnosis (LIKE) berfungsi
[ ] Filter status (dropdown) berfungsi
[ ] Filter dapat dikombinasi
[ ] Ringkasan total muncul sesuai filter
[ ] Pagination berfungsi setelah filter

UI/UX
[ ] Navbar konsisten di semua halaman
[ ] Flash message dengan style yang baik
[ ] Empty state tampil saat data kosong
[ ] Badge status warna sesuai
[ ] Modal konfirmasi untuk aksi destruktif
[ ] Form pre-filled saat edit

VALIDASI & ERROR HANDLING
[ ] Semua form punya validasi
[ ] Error message tampil inline di form
[ ] DB transaction di-rollback saat error
[ ] Try-catch di operasi kritikal
[ ] Custom 404 untuk record tidak ditemukan

BUSINESS RULES
[ ] Tidak bisa asesmen kunjungan yang sudah_asesmen/batal
[ ] Tidak bisa batal kunjungan yang sudah_asesmen
[ ] Satu kunjungan hanya satu asesmen (UNIQUE constraint)
[ ] Tanggal lahir tidak boleh masa depan
[ ] Format tekanan darah valid (regex)

SUBMISSION
[ ] Email subject benar: "NAMA – IT Programmer TES Praktek"
[ ] Email tujuan benar: itrsipku@gmail.com
[ ] Link repo public dapat diakses
[ ] Test clone di folder lain dan jalankan dari nol — sukses
```

---

## 12. TEMPLATE README.md

```markdown
# Aplikasi Pencatatan Pasien Rawat Jalan

Aplikasi web untuk pencatatan pasien rawat jalan dengan alur:
**Pendaftaran → Asesmen → Laporan**

## Tech Stack
- PHP 8.2+
- Laravel 12
- MySQL/MariaDB
- Bootstrap 5

## Persyaratan Sistem
- PHP >= 8.2
- Composer
- MySQL >= 5.7 atau MariaDB >= 10.3
- Node.js (opsional, jika perlu compile asset)

## Cara Menjalankan

### 1. Clone Repository
\`\`\`bash
git clone https://github.com/USERNAME/rawat-jalan.git
cd rawat-jalan
\`\`\`

### 2. Install Dependencies
\`\`\`bash
composer install
\`\`\`

### 3. Setup Environment
\`\`\`bash
cp .env.example .env
php artisan key:generate
\`\`\`

### 4. Konfigurasi Database
Edit file `.env` dan sesuaikan:
\`\`\`
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rawat_jalan
DB_USERNAME=root
DB_PASSWORD=
\`\`\`

### 5. Buat Database & Import Skema
**Opsi A — Dari file SQL:**
\`\`\`bash
mysql -u root -p -e "CREATE DATABASE rawat_jalan;"
mysql -u root -p rawat_jalan < database/sql/rawat_jalan.sql
\`\`\`

**Opsi B — Dari migration & seeder:**
\`\`\`bash
php artisan migrate --seed
\`\`\`

### 6. Jalankan Aplikasi
\`\`\`bash
php artisan serve
\`\`\`

Akses di browser: `http://localhost:8000`

## Struktur Database
- **pasien** — data pribadi pasien
- **poli** — master data poli
- **dokter** — master data dokter (terhubung ke poli)
- **kunjungan** — record kunjungan pasien (status: terdaftar / sudah_asesmen / batal)
- **asesmen** — data pemeriksaan (1:1 dengan kunjungan)

## Fitur
1. **Pendaftaran Pasien** — daftar pasien baru beserta kunjungan pertamanya
2. **Asesmen Rawat Jalan** — input data pemeriksaan terhubung ke kunjungan
3. **Laporan Kunjungan** — laporan dengan filter (nama, tanggal, dokter, diagnosis, status) dan ringkasan total

## Default Seed Data
- Poli: Umum, Gigi, Anak, Penyakit Dalam, Kandungan, Mata
- Dokter: 6 dokter dengan poli yang variatif

## Author
[NAMA ANDA]
```

---

## 13. RISK & MITIGATION

| Risk | Impact | Mitigation |
|------|--------|------------|
| Waktu tidak cukup | High | Skip nice-to-have (multi-poli per dokter), fokus core requirement |
| Database design tidak normalisasi | High | Sudah didesain di Section 5, ikuti tepat |
| N+1 query di laporan | Medium | Wajib eager load dengan `with()` |
| Validasi terlewat | Medium | Pakai FormRequest, ada checklist di Section 11 |
| Lupa commit .sql | High | Set sebagai langkah eksplisit di Fase 7 |
| Error saat clone & install | High | Test clone di folder lain sebelum submit |
| File .env ter-commit | Medium | `.gitignore` Laravel default sudah handle |

---

**END OF DOCUMENT**
