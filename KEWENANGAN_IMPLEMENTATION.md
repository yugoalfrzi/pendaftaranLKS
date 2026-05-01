# Implementasi Kewenangan Pendaftaran LKS

## Ringkasan Perubahan

Sistem pendaftaran LKS sekarang mendukung dua jenis kewenangan:
1. **Kab/Kota** - Proses verifikasi berhenti di Admin (tidak diteruskan ke Super Admin)
2. **Provinsi** - Proses verifikasi lengkap: User → Admin → Super Admin

## File yang Diubah

### 1. Database Migration
- **File**: `database/migrations/2026_04_23_000001_add_kewenangan_type_to_lks_table.php`
- **Perubahan**: Menambahkan kolom `kewenangan_type` (enum: 'kabkota', 'provinsi', 'kemensos') ke tabel `lks`
- **Default**: 'kabkota'

### 2. Model LKS
- **File**: `app/Models/lks.php`
- **Perubahan**: Menambahkan `kewenangan_type` ke array `$fillable`

### 3. Halaman Registrasi
- **File**: `resources/views/register.blade.php`
- **Perubahan**: 
  - Menambahkan pilihan radio button untuk memilih kewenangan (Kab/Kota atau Provinsi)
  - Kab/Kota: badge biru dengan icon building
  - Provinsi: badge hijau dengan icon map
  - Penjelasan singkat di bawah setiap pilihan

### 4. AuthController
- **File**: `app/Http/Controllers/AuthController.php`
- **Perubahan**:
  - Menambahkan validasi untuk `kewenangan_type` (required, in:kabkota,provinsi)
  - Menyimpan `kewenangan_type` ke session setelah registrasi berhasil
  - Session ini akan digunakan saat user membuat pendaftaran LKS

### 5. LKS Create Form
- **File**: `resources/views/lks/create.blade.php`
- **Perubahan**: Menambahkan hidden input `kewenangan_type` yang mengambil nilai dari session

### 6. LKSController
- **File**: `app/Http/Controllers/LKS/LKSController.php`
- **Perubahan**: 
  - Menyimpan `kewenangan_type` saat membuat LKS baru
  - Mengambil dari request (jika ada) atau dari session (fallback ke 'kabkota')

### 7. AdminController
- **File**: `app/Http/Controllers/AdminController.php`
- **Perubahan**:
  - Menambahkan filter kewenangan di method `adminIndex()`
  - Menambahkan statistik untuk kewenangan kabkota dan provinsi
  - Menambahkan data `KewenanganKabkota` dan `KewenanganProvinsi` untuk ditampilkan di admin panel
  - Import model `KewenanganKabkota` dan `KewenanganProvinsi`

### 8. Admin Index View
- **File**: `resources/views/admin/index.blade.php`
- **Perubahan**:
  - Menambahkan filter dropdown untuk kewenangan
  - Menambahkan kolom "Kewenangan" di tabel LKS dengan badge berwarna
  - Menambahkan 2 tab baru di bawah tabel LKS:
    - Tab "Kewenangan Kab/Kota" - menampilkan tabel KewenanganKabkota
    - Tab "Kewenangan Provinsi" - menampilkan tabel KewenanganProvinsi
  - Setiap tab menampilkan: Nama LKS, Nama Lembaga/Yayasan, Kabupaten/Kota, Status, Akreditasi
  - Link "Lihat Semua" untuk masing-masing kewenangan

### 9. Admin Verification View
- **File**: `resources/views/admin/verification.blade.php`
- **Perubahan**:
  - Menambahkan baris "Kewenangan" di tabel informasi pendaftaran
  - Menampilkan badge kewenangan dengan keterangan:
    - Kab/Kota: "Proses berhenti di Admin"
    - Provinsi: "Diteruskan ke Super Admin"

### 10. SuperAdminController
- **File**: `app/Http/Controllers/SuperAdminController.php`
- **Perubahan**:
  - Menambahkan filter untuk TIDAK menampilkan LKS dengan `kewenangan_type = 'kabkota'`
  - LKS kab/kota tidak akan muncul di panel Super Admin karena proses sudah selesai di Admin

## Alur Kerja

### Alur Kewenangan Kab/Kota
1. User registrasi → pilih "Kab/Kota"
2. `kewenangan_type` disimpan di session
3. User membuat pendaftaran LKS → `kewenangan_type = 'kabkota'` tersimpan di database
4. Admin memverifikasi dan upload surat rekomendasi
5. Status menjadi "Diterima" → **SELESAI** (tidak diteruskan ke Super Admin)

### Alur Kewenangan Provinsi
1. User registrasi → pilih "Provinsi"
2. `kewenangan_type` disimpan di session
3. User membuat pendaftaran LKS → `kewenangan_type = 'provinsi'` tersimpan di database
4. Admin memverifikasi dan upload surat rekomendasi
5. Status menjadi "Diterima" → muncul di panel Super Admin
6. Super Admin upload sertifikat → **SELESAI**

## Fitur Tambahan di Admin Panel

### Tabel Kewenangan
Admin panel sekarang menampilkan 2 tabel tambahan dalam bentuk tab:

1. **Tab Kewenangan Kab/Kota**
   - Menampilkan data dari tabel `kewenangan_kabkota`
   - Pagination terpisah (parameter: `kabkota_page`)
   - Link ke halaman detail kewenangan kabkota

2. **Tab Kewenangan Provinsi**
   - Menampilkan data dari tabel `kewenangan_provinsi`
   - Pagination terpisah (parameter: `provinsi_page`)
   - Link ke halaman detail kewenangan provinsi

### Filter
Admin dapat memfilter LKS berdasarkan:
- Status permohonan
- Kewenangan (Kab/Kota atau Provinsi)
- Ketersediaan surat rekomendasi
- Pencarian nama LKS

## Testing

Untuk menguji implementasi:

1. **Registrasi User Baru**
   - Buka `/register`
   - Pilih kewenangan "Kab/Kota" atau "Provinsi"
   - Lengkapi form dan submit

2. **Buat Pendaftaran LKS**
   - Login sebagai user yang baru dibuat
   - Buat pendaftaran LKS baru
   - Verifikasi bahwa `kewenangan_type` tersimpan dengan benar

3. **Verifikasi Admin**
   - Login sebagai admin
   - Lihat badge kewenangan di tabel LKS
   - Verifikasi LKS dan upload surat rekomendasi
   - Untuk kab/kota: pastikan tidak muncul di Super Admin
   - Untuk provinsi: pastikan muncul di Super Admin

4. **Panel Admin - Tab Kewenangan**
   - Buka `/admin/lks`
   - Scroll ke bawah untuk melihat tab kewenangan
   - Klik tab "Kewenangan Kab/Kota" dan "Kewenangan Provinsi"
   - Verifikasi data ditampilkan dengan benar

## Catatan

- Migration sudah dijalankan dan berhasil
- Tidak ada error diagnostik di semua file yang diubah
- Semua route admin masih berfungsi normal
- Backward compatibility: LKS lama tanpa `kewenangan_type` akan default ke 'kabkota'
