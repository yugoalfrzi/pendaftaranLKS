# Sistem Permission & Role

## Role Structure

### 1. Super Admin (super_admin)
**Akses Penuh** - Dapat mengakses semua fitur kecuali halaman registrasi LKS

**Akses:**
- ✅ Dashboard
- ✅ Super Admin Panel (`/superadmin`) - Upload **Surat Rekomendasi**
- ✅ Admin Panel (`/admin`) - Upload **Sertifikat**
- ✅ Data LKS (View, Create, Edit, Delete)
- ✅ Dokumen Tanda Pendaftaran (Full CRUD)
- ✅ Kewenangan Kabkota/Provinsi/Kemensos (Full CRUD + Export)
- ✅ Hibah LKS (Full CRUD)
- ✅ Pengumuman (View, Create, Delete)
- ❌ Registrasi LKS (Tidak bisa akses)

### 2. Admin (admin)
**Akses Terbatas** - Dapat mengakses semua fitur kecuali Admin Panel dan Registrasi LKS

**Akses:**
- ✅ Dashboard
- ✅ Data LKS (View, Create, Edit, Delete)
- ✅ Dokumen Tanda Pendaftaran (Full CRUD)
- ✅ Kewenangan Kabkota/Provinsi/Kemensos (Full CRUD + Export)
- ✅ Hibah LKS (Full CRUD)
- ✅ Pengumuman (View, Create, Delete)
- ❌ Super Admin Panel (`/superadmin`)
- ❌ Admin Panel (`/admin`)
- ❌ Registrasi LKS (Tidak bisa akses)

### 3. User (user)
**Akses Read-Only** - Hanya dapat melihat data, tidak bisa menambah/edit/hapus

**Akses:**
- ✅ Dashboard (View only)
- ✅ Data LKS (View only - tidak bisa create/edit/delete)
- ✅ Kewenangan Kabkota/Provinsi/Kemensos (View only - tidak bisa create/edit/delete/export)
- ✅ Pengumuman (View only)
- ❌ Dokumen Tanda Pendaftaran
- ❌ Hibah LKS
- ❌ Super Admin Panel
- ❌ Admin Panel
- ❌ Create/Edit/Delete data apapun

## Perbedaan Super Admin Panel vs Admin Panel

### Super Admin Panel (`/superadmin`)
- **Akses:** Hanya Super Admin
- **Fungsi Verifikasi:** Upload **Surat Rekomendasi**
- **Routes:**
  - `GET /superadmin` - List semua LKS
  - `GET /superadmin/{id}/verification` - Form verifikasi
  - `POST /superadmin/{id}/verification` - Proses verifikasi + upload surat rekomendasi
  - `GET /superadmin/{id}/edit` - Edit data LKS
  - `PUT /superadmin/{id}` - Update data LKS
  - `DELETE /superadmin/{id}` - Hapus LKS

### Admin Panel (`/admin`)
- **Akses:** Hanya Super Admin (Admin biasa tidak bisa akses)
- **Fungsi Verifikasi:** Upload **Sertifikat**
- **Routes:**
  - `GET /admin/lks` - List semua LKS
  - `GET /admin/{id}/verification` - Form verifikasi
  - `POST /admin/{id}/verification` - Proses verifikasi + upload sertifikat
  - Dan routes lainnya...

## Middleware

### 1. SuperAdminMiddleware
```php
// File: app/Http/Middleware/SuperAdminMiddleware.php
// Hanya user dengan role 'super_admin' yang bisa akses
```

### 2. AdminMiddleware
```php
// File: app/Http/Middleware/AdminMiddleware.php
// User dengan role 'admin' atau 'super_admin' yang bisa akses
```

### 3. Rolecheck Middleware
```php
// File: app/Http/Middleware/Rolecheck.php
// Bisa check multiple roles
// Usage: ->middleware('rolecheck:super_admin,admin')
```

## Route Protection Examples

### Super Admin Only
```php
Route::middleware('superadmin')->group(function () {
    // Hanya super_admin
});
```

### Admin & Super Admin
```php
Route::middleware('rolecheck:super_admin,admin')->group(function () {
    // admin dan super_admin
});
```

### All Authenticated Users (View Only for User)
```php
Route::get('/', [Controller::class, 'index']); // Semua bisa view
Route::middleware('rolecheck:super_admin,admin')->group(function () {
    Route::get('/create', [Controller::class, 'create']); // Hanya admin & super_admin
    Route::post('/', [Controller::class, 'store']);
    Route::put('/{id}', [Controller::class, 'update']);
    Route::delete('/{id}', [Controller::class, 'destroy']);
});
```

## Testing Permission

### Test Super Admin
```bash
# Login sebagai super_admin
Email: diskominfojabar@diskominfo.com
Password: @diskominfo1

# Cek akses:
- /superadmin ✅
- /admin ✅
- /lks (dengan tombol create/edit/delete) ✅
- /kewenangan-kabkota (dengan tombol create/edit/delete/export) ✅
```

### Test Admin
```bash
# Login sebagai admin
Email: dinsoskabBogor@dinsos.com
Password: @dinsoskabBogor01

# Cek akses:
- /superadmin ❌ (403 Forbidden)
- /admin ❌ (403 Forbidden)
- /lks (dengan tombol create/edit/delete) ✅
- /kewenangan-kabkota (dengan tombol create/edit/delete/export) ✅
```

### Test User (LKS)
```bash
# Register atau login sebagai user
# Cek akses:
- /lks (TANPA tombol create/edit/delete) ✅
- /kewenangan-kabkota (TANPA tombol create/edit/delete/export) ✅
- /documents ❌ (403 Forbidden)
- /hibah ❌ (403 Forbidden)
```

## View Conditional Rendering

Untuk menyembunyikan tombol berdasarkan role di view:

```blade
@if(auth()->user()->hasRole(['super_admin', 'admin']))
    <a href="{{ route('lks.create') }}" class="btn btn-primary">
        <i class="bi bi-plus"></i> Tambah LKS
    </a>
@endif

@if(auth()->user()->role === 'super_admin')
    <a href="{{ route('superadmin.index') }}" class="btn btn-success">
        Super Admin Panel
    </a>
@endif
```

## Summary

| Fitur | Super Admin | Admin | User |
|-------|-------------|-------|------|
| Dashboard | ✅ | ✅ | ✅ View |
| Super Admin Panel | ✅ | ❌ | ❌ |
| Admin Panel | ✅ | ❌ | ❌ |
| LKS CRUD | ✅ | ✅ | View Only |
| Dokumen | ✅ | ✅ | ❌ |
| Kewenangan CRUD | ✅ | ✅ | View Only |
| Kewenangan Export | ✅ | ✅ | ❌ |
| Hibah | ✅ | ✅ | ❌ |
| Registrasi LKS | ❌ | ❌ | ❌ |
