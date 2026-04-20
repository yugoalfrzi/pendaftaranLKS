# Perubahan Sistem Role

## Ringkasan Perubahan

Sistem role telah diperbarui dengan struktur baru:

### Role Baru:
1. **super_admin** - Dinsos Provinsi (sebelumnya: dinsos_provinsi)
2. **admin** - Dinsos Kabkota (sebelumnya: dinsos_kabkota)  
3. **user** - LKS/Pengguna biasa

## Fitur Baru

### 1. Halaman Registrasi LKS
- URL: `/register`
- Pengguna dapat mendaftar sebagai LKS dengan role `user`
- Form registrasi mencakup:
  - Data pengguna (nama, email, password)
  - Data LKS (nama LKS, alamat, nomor kontak)
- Setelah registrasi berhasil, otomatis login dan redirect ke dashboard

### 2. Update Role System
- Role `dinsos_provinsi` → `super_admin`
- Role `dinsos_kabkota` → `admin`
- Role default untuk LKS: `user`

## Cara Menggunakan

### 1. Migrasi Database
Jalankan migrasi untuk update role dan field nullable:

```bash
php artisan migrate
```

Migrasi ini akan:
- Update role yang sudah ada (dinsos_provinsi → super_admin, dinsos_kabkota → admin)
- Membuat field `tanda_pendaftaran`, `tanggal_masuk_dokumen`, `tanggal_persyaratan` menjadi nullable

### 2. Seeder - Update Role yang Sudah Ada
Karena Anda sudah memiliki UserSeeder dengan akun Kabkota/Kota, jalankan seeder untuk update role mereka:

```bash
php artisan db:seed --class=UserSeeder
```

Ini akan membuat/update:
- **2 Super Admin** (Dinsos Provinsi):
  - `diskominfojabar@diskominfo.com` / `@diskominfo1`
  - `dinsosprovinsijabar@dinsos.com` / `@dinsosprovinsi1`
  
- **27 Admin** (Dinsos Kabupaten/Kota):
  - 18 Kabupaten (Bogor, Sukabumi, Cianjur, dll)
  - 9 Kota (Bogor, Sukabumi, Bandung, dll)

### 3. Akses Halaman

#### Login
- URL: `/login`
- Semua role bisa login di sini

#### Register (LKS)
- URL: `/register`
- Hanya untuk pendaftaran LKS baru
- Role otomatis: `user`
- **Setelah registrasi berhasil, redirect ke halaman login**
- Data yang dibuat:
  - User dengan role `user`
  - LKS dengan status `Menunggu`
  - Field minimal: nama_lks, alamat_lks, nomor_kontak

## Middleware & Permission

### AdminMiddleware
Sekarang menerima role `admin` dan `super_admin`:
```php
// Kedua role ini bisa akses fitur admin
$isAdmin = in_array($user->role, ['admin', 'super_admin']);
```

### Rolecheck Middleware
Tetap sama, bisa digunakan untuk check role spesifik:
```php
Route::middleware(['auth', 'rolecheck:super_admin'])->group(function () {
    // Hanya super_admin yang bisa akses
});

Route::middleware(['auth', 'rolecheck:admin,super_admin'])->group(function () {
    // Admin dan super_admin bisa akses
});
```

## File yang Diubah

1. **Migration**: 
   - `database/migrations/2026_04_20_000001_update_user_roles.php`
   - `database/migrations/2026_04_20_000002_make_lks_fields_nullable_for_registration.php`
2. **Controller**: `app/Http/Controllers/AuthController.php`
3. **Middleware**: `app/Http/Middleware/AdminMiddleware.php`
4. **Routes**: `routes/web.php`
5. **Views**: 
   - `resources/views/register.blade.php` (baru)
   - `resources/views/login.blade.php` (update)
6. **Seeder**: `database/seeders/UserSeeder.php` (update role)

## Testing

### Test Registrasi
1. Buka `/register`
2. Isi form dengan data LKS
3. Submit
4. **Cek apakah redirect ke halaman login dengan pesan sukses**
5. Login dengan email dan password yang baru didaftarkan
6. Cek database: user baru dengan role `user` dan data LKS terkait dengan status `Menunggu`

### Test Login
1. Login dengan user role `super_admin`
2. Cek akses ke fitur admin
3. Login dengan user role `admin`
4. Cek akses ke fitur admin
5. Login dengan user role `user`
6. Cek akses terbatas (tidak bisa akses admin)

## Catatan Penting

- Password minimal 8 karakter
- Email harus unique
- Setiap registrasi LKS otomatis membuat record di tabel `lks` dengan `status_verifikasi = 'pending'`
- User yang register sebagai LKS akan ter-link dengan data LKS melalui `user_id`
