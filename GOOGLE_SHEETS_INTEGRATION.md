# Google Sheets Integration untuk Pendaftaran LKS

## Masalah yang Diselesaikan

Sebelumnya, pendaftaran dengan status "Diterima untuk proses" tidak otomatis tersinkronisasi ke Google Drive Spreadsheet.

## Solusi yang Diimplementasikan

### 1. Model Observer (`app/Observers/LKSObserver.php`)
- **Fungsi**: Memantau perubahan status pada model LKS
- **Trigger**: Otomatis terpicu ketika status berubah menjadi "Diterima untuk proses"
- **Aksi**: Mengirim job ke queue untuk sinkronisasi background

### 2. Background Job (`app/Jobs/SyncLKSToGoogleSheets.php`)
- **Fungsi**: Memproses sinkronisasi data LKS ke Google Sheets
- **Keuntungan**: Tidak memblokir proses utama aplikasi
- **Error Handling**: Menyimpan log error jika sinkronisasi gagal

### 3. Admin Controller Integration
- **Fungsi**: Memanggil job sinkronisasi ketika admin mengubah status
- **Lokasi**: `AdminController::verification()` method
- **Trigger**: Manual ketika admin melakukan verifikasi

### 4. Artisan Command (`app/Console/Commands/SyncAcceptedLKSCommand.php`)
- **Fungsi**: Sinkronisasi manual semua LKS yang sudah diterima
- **Command**: `php artisan lks:sync-accepted`
- **Options**: `--force` untuk sinkronisasi ulang semua data

## Cara Menggunakan

### Sinkronisasi Otomatis
- Tidak perlu melakukan apa-apa, sistem akan otomatis sinkronisasi ketika:
  - Admin mengubah status menjadi "Diterima untuk proses"
  - Data LKS dibuat dengan status "Diterima untuk proses"

### Sinkronisasi Manual
```bash
# Sinkronisasi semua LKS yang diterima
php artisan lks:sync-accepted

# Sinkronisasi ulang semua (termasuk yang sudah pernah di-sync)
php artisan lks:sync-accepted --force
```

### Monitoring Queue
```bash
# Jalankan queue worker untuk memproses job
php artisan queue:work

# Lihat failed jobs
php artisan queue:failed
```

## Data yang Disinkronisasi

Data berikut akan dikirim ke Google Sheets:
1. ID LKS
2. Nama LKS
3. Alamat LKS
4. Nama Ketua LKS
5. Jenis Pelayanan
6. Jumlah Binaan Dalam Panti
7. Jumlah Binaan Luar Panti
8. Kabupaten/Kota
9. Pusat LKS
10. Cabang LKS
11. Nomor Kontak
12. Tanda Pendaftaran
13. Tanggal Masuk Dokumen
14. Tanggal Persyaratan
15. Status Pendaftaran Lengkap
16. Status Permohonan
17. Nama Verifikator
18. ID Verifikator
19. Tanggal Dibuat
20. Tanggal Diperbarui

## Konfigurasi

### Environment Variables
Pastikan file `.env` memiliki konfigurasi berikut:
```
GOOGLE_SHEET_ID=your_google_sheet_id_here
```

### Google Service Account
Pastikan file credential ada di:
```
storage/app/data-pendaftaran-lks-ba3d6100274d.json
```

## Logging

Sistem akan menyimpan log di `storage/logs/laravel.log` untuk:
- Sinkronisasi berhasil
- Error sinkronisasi
- Detail error dengan stack trace

## Troubleshooting

### Jika Sinkronisasi Gagal
1. Cek log file untuk detail error
2. Pastikan Google Service Account memiliki akses ke spreadsheet
3. Pastikan spreadsheet ID benar di environment
4. Pastikan credential file ada dan valid

### Jika Data Tidak Muncul di Google Sheets
1. Jalankan command manual: `php artisan lks:sync-accepted --force`
2. Cek queue worker berjalan: `php artisan queue:work`
3. Cek failed jobs: `php artisan queue:failed`

## Testing

Untuk testing sinkronisasi:
1. Buat data LKS dengan status "Menunggu"
2. Ubah status menjadi "Diterima untuk proses" melalui admin
3. Cek Google Sheets untuk memastikan data muncul
4. Cek log file untuk konfirmasi proses
