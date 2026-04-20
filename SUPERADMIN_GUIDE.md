# Panduan Super Admin Panel

## Akses Super Admin Panel

**URL:** `/superadmin`

**Login sebagai Super Admin:**
- Email: `diskominfojabar@diskominfo.com` / Password: `@diskominfo1`
- Email: `dinsosprovinsijabar@dinsos.com` / Password: `@dinsosprovinsi1`

## Fitur Super Admin Panel

### 1. Dashboard LKS (`/superadmin`)
- Melihat semua data LKS yang terdaftar
- Filter berdasarkan:
  - Status (Menunggu, Diterima, Ditolak, Dikembalikan)
  - Kabupaten/Kota
  - Pencarian nama LKS
- Aksi yang tersedia:
  - Verifikasi LKS
  - Edit data LKS
  - Hapus LKS
  - Download/Preview Surat Rekomendasi

### 2. Verifikasi LKS (`/superadmin/{id}/verification`)

**Proses Verifikasi:**

1. **Lihat Informasi LKS**
   - Data lengkap LKS
   - Kelengkapan dokumen (jika ada)
   - Status saat ini

2. **Pilih Status Verifikasi:**
   - **Diterima** → Upload Surat Rekomendasi (opsional)
   - **Ditolak** → Wajib isi alasan penolakan
   - **Dikembalikan** → Wajib isi alasan dikembalikan

3. **Upload Surat Rekomendasi** (untuk status Diterima)
   - Format: PDF, JPG, PNG
   - Maksimal: 5MB
   - Surat rekomendasi akan tersimpan dan bisa didownload

4. **Simpan Verifikasi**
   - Data verifikasi tersimpan
   - Nama verifikator otomatis terisi (dari user login)

### 3. Edit Data LKS (`/superadmin/{id}/edit`)

**Field yang bisa diedit:**
- Nama LKS
- Alamat LKS
- Nomor Kontak
- Kabupaten/Kota
- Lokasi LKS
- Status Permohonan

### 4. Hapus LKS (`DELETE /superadmin/{id}`)
- Menghapus data LKS
- Menghapus surat rekomendasi (jika ada)
- Konfirmasi sebelum hapus

## Perbedaan dengan Admin Panel

| Fitur | Super Admin Panel | Admin Panel |
|-------|-------------------|-------------|
| URL | `/superadmin` | `/admin` |
| Akses | Super Admin only | Super Admin only |
| Upload | **Surat Rekomendasi** | **Sertifikat** |
| Status | Diterima/Ditolak/Dikembalikan | Diterima untuk proses/Ditolak/Dikembalikan |

## Workflow Verifikasi

```
1. LKS Register → Status: Menunggu
2. Super Admin Verifikasi:
   - Diterima → Upload Surat Rekomendasi
   - Ditolak → Isi alasan penolakan
   - Dikembalikan → Isi alasan dikembalikan
3. Admin Panel (jika diperlukan):
   - Diterima untuk proses → Upload Sertifikat
```

## Tips

1. **Filter Data**
   - Gunakan filter untuk mempermudah pencarian
   - Kombinasikan filter status dan kabupaten

2. **Verifikasi Dokumen**
   - Periksa kelengkapan dokumen sebelum verifikasi
   - Pastikan semua dokumen wajib sudah lengkap

3. **Surat Rekomendasi**
   - Upload surat rekomendasi saat status "Diterima"
   - Surat bisa diupdate kapan saja
   - Preview sebelum download untuk memastikan file benar

4. **Alasan Penolakan/Dikembalikan**
   - Berikan alasan yang jelas dan spesifik
   - Alasan akan dilihat oleh LKS

## Troubleshooting

### Error 403 Forbidden
**Penyebab:** User bukan super_admin
**Solusi:** Login dengan akun super admin

### File Upload Gagal
**Penyebab:** File terlalu besar atau format salah
**Solusi:** 
- Maksimal 5MB
- Format: PDF, JPG, PNG

### Data Tidak Muncul
**Penyebab:** Filter terlalu spesifik
**Solusi:** Reset filter atau gunakan pencarian

## Keamanan

- Hanya user dengan role `super_admin` yang bisa akses
- Semua aksi tercatat dengan nama verifikator
- File upload divalidasi format dan ukuran
- CSRF protection aktif di semua form
