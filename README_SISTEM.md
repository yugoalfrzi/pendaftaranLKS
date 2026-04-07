# Sistem Pendaftaran LKS (Lembaga Kesejahteraan Sosial)

## Deskripsi Sistem

Sistem ini adalah aplikasi web untuk mengelola pendaftaran Lembaga Kesejahteraan Sosial (LKS) dengan fitur verifikasi oleh admin. Sistem memungkinkan pengguna untuk mendaftar LKS mereka dan admin untuk memverifikasi pendaftaran tersebut.

## Fitur Utama

### 1. Fitur Pengguna (User)
- **Pendaftaran LKS**: Pengguna dapat mendaftarkan LKS mereka dengan mengisi form pendaftaran
- **Status Default**: Setiap pendaftaran baru akan memiliki status "Menunggu" secara otomatis
- **Manajemen Data**: Pengguna dapat melihat, mengedit, dan menghapus data pendaftaran mereka
- **Upload Dokumen**: Pengguna dapat mengupload dokumen pendukung yang diperlukan
- **Tracking Status**: Pengguna dapat melihat status permohonan mereka (Menunggu, Diterima, Ditolak, Dikembalikan)

### 2. Fitur Admin
- **Dashboard Admin**: Tampilan khusus admin dengan statistik pendaftaran
- **Verifikasi Pendaftaran**: Admin dapat memverifikasi pendaftaran dengan status:
  - **Diterima**: Pendaftaran disetujui
  - **Ditolak**: Pendaftaran ditolak dengan alasan
  - **Dikembalikan**: Pendaftaran dikembalikan untuk perbaikan dengan alasan
- **Filter dan Pencarian**: Admin dapat memfilter data berdasarkan status dan mencari berdasarkan nama LKS
- **Manajemen Lengkap**: Admin dapat melihat, mengedit, dan menghapus semua data pendaftaran

### 3. Status Permohonan
- **Menunggu**: Status default saat pendaftaran baru disimpan
- **Diterima**: Pendaftaran telah diverifikasi dan diterima
- **Ditolak**: Pendaftaran ditolak dengan alasan penolakan
- **Dikembalikan**: Pendaftaran dikembalikan untuk perbaikan dengan alasan

## Struktur Database

### Tabel `lks`
- `id`: Primary key
- `nama_lks`: Nama LKS
- `alamat_lks`: Alamat LKS
- `tanda_pendaftaran`: Baru/Ulang
- `tanggal_masuk_dokumen`: Tanggal masuk dokumen
- `tanggal_persyaratan`: Tanggal persyaratan
- `pendaftaran_lengkap`: Boolean kelengkapan pendaftaran
- `status_permohonan`: Status permohonan (Menunggu, Diterima, Ditolak, Dikembalikan)
- `alasan_penolakan`: Alasan jika ditolak
- `alasan_dikembalikan`: Alasan jika dikembalikan
- `nomor_kontak`: Nomor kontak
- `verifikator`: ID verifikator
- `nama_verifikator`: Nama verifikator
- `tandatangan`: Tandatangan verifikator
- `created_at`, `updated_at`: Timestamps

## Cara Penggunaan

### Untuk Pengguna
1. Akses halaman utama sistem
2. Klik "Pendaftaran Baru" untuk membuat pendaftaran baru
3. Isi form pendaftaran dengan data LKS
4. Upload dokumen yang diperlukan
5. Simpan pendaftaran (status otomatis menjadi "Menunggu")
6. Pantau status permohonan di halaman daftar pendaftaran
7. Jika status "Dikembalikan", edit pendaftaran sesuai alasan yang diberikan

### Untuk Admin
1. Akses "Admin Panel" dari halaman utama
2. Lihat dashboard dengan statistik pendaftaran
3. Gunakan filter untuk mencari pendaftaran tertentu
4. Klik tombol "Verifikasi" pada pendaftaran dengan status "Menunggu"
5. Pilih status verifikasi (Diterima/Ditolak/Dikembalikan)
6. Jika Ditolak atau Dikembalikan, isi alasan yang diperlukan
7. Isi informasi verifikator
8. Simpan verifikasi

## Routes

### User Routes
- `GET /lks` - Daftar pendaftaran LKS
- `GET /lks/create` - Form pendaftaran baru
- `POST /lks` - Simpan pendaftaran baru
- `GET /lks/{id}` - Detail pendaftaran
- `GET /lks/{id}/edit` - Form edit pendaftaran
- `PUT /lks/{id}` - Update pendaftaran
- `DELETE /lks/{id}` - Hapus pendaftaran

### Admin Routes
- `GET /admin/lks` - Dashboard admin
- `GET /admin/lks/{id}/verify` - Form verifikasi
- `POST /admin/lks/{id}/verify` - Simpan verifikasi

## Instalasi

1. Clone repository
2. Install dependencies: `composer install`
3. Copy `.env.example` ke `.env`
4. Generate key: `php artisan key:generate`
5. Setup database di `.env`
6. Run migration: `php artisan migrate`
7. Run seeder: `php artisan db:seed --class=DocumentSeeder`
8. Start server: `php artisan serve`

## Teknologi yang Digunakan

- **Backend**: Laravel 12
- **Frontend**: Bootstrap 5, Bootstrap Icons
- **Database**: MySQL/SQLite
- **PHP**: 8.2+

## Catatan Penting

- Setiap pendaftaran baru otomatis memiliki status "Menunggu"
- Admin dapat mengubah status menjadi Diterima, Ditolak, atau Dikembalikan
- Jika Ditolak atau Dikembalikan, admin wajib mengisi alasan
- Pengguna dapat mengedit pendaftaran mereka kapan saja
- Admin memiliki akses penuh untuk mengelola semua data
