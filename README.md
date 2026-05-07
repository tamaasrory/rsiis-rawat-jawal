# Aplikasi Pencatatan Pasien Rawat Jalan

Aplikasi web untuk pencatatan pasien rawat jalan dengan alur:
**Pendaftaran → Asesmen → Laporan**

## Tech Stack
- PHP 8.4+
- Laravel 12 (Framework v13)
- MySQL/MariaDB
- Bootstrap 5

## Persyaratan Sistem
- PHP >= 8.4
- Composer
- MySQL >= 5.7 atau MariaDB >= 10.3
- Node.js (opsional, jika perlu compile asset)

## Cara Menjalankan

### 1. Clone Repository
```bash
git clone https://github.com/USERNAME/rsiis.git
cd rsiis
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Setup Environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Konfigurasi Database
Edit file `.env` dan sesuaikan:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rawat_jalan
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Buat Database & Import Skema
**Opsi A — Dari file SQL:**
```bash
mysql -u root -p -e "CREATE DATABASE rawat_jalan;"
mysql -u root -p rawat_jalan < database/sql/rawat_jalan.sql
```

**Opsi B — Dari migration & seeder:**
```bash
php artisan migrate --seed
```

### 6. Jalankan Aplikasi
```bash
php artisan serve
```

Akses di browser: `http://localhost:8000`

---

## Cara Menjalankan (via Docker)
Cara termudah untuk mencoba aplikasi tanpa setup PHP atau MySQL di komputer Anda adalah menggunakan Docker. Image sudah di-build otomatis di GitHub Container Registry.

1. Buka terminal di folder ini (atau cukup unduh file `docker-compose.yml` ini).
2. Jalankan perintah:
```bash
docker-compose up -d
```
3. Buka browser: `http://localhost:8080`

*(Catatan: Container database MySQL akan secara otomatis mengisi tabel dengan data default saat pertama kali dijalankan).*

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
