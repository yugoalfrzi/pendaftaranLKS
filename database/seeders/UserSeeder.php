<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        
        // Super Admin - Dinsos Provinsi Jawa Barat
        User::updateOrCreate(
            ['email' => 'dinsosprovinsijabar@app.com'],
            [
                'name'            => 'Dinsos Provinsi Jawa Barat',
                'password'        => Hash::make('@dinsosprovinsi1'),
                'role'            => 'super_admin',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kabupaten Bogor
        User::updateOrCreate(
            ['email' => 'dinsoskabBogor@app.com'],
            [
                'name'            => 'Dinsos Kabupaten Bogor',
                'password'        => Hash::make('@dinsoskabBogor01'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kabupaten Bogor',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kabupaten Sukabumi
        User::updateOrCreate(
            ['email' => 'dinsoskabSukabumi@app.com'],
            [
                'name'            => 'Dinsos Kabupaten Sukabumi',
                'password'        => Hash::make('@dinsoskabSukabumi02'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kabupaten Sukabumi',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kabupaten Cianjur
        User::updateOrCreate(
            ['email' => 'dinsoskabCianjur@app.com'],
            [
                'name'            => 'Dinsos Kabupaten Cianjur',
                'password'        => Hash::make('@dinsoskabCianjur03'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kabupaten Cianjur',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kabupaten Bandung
        User::updateOrCreate(
            ['email' => 'dinsoskabBandung@app.com'],
            [
                'name'            => 'Dinsos Kabupaten Bandung',
                'password'        => Hash::make('@dinsoskabBandung04'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kabupaten Bandung',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kabupaten Garut
        User::updateOrCreate(
            ['email' => 'dinsoskabGarut@app.com'],
            [
                'name'            => 'Dinsos Kabupaten Garut',
                'password'        => Hash::make('@dinsoskabGarut05'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kabupaten Garut',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kabupaten Tasikmalaya
        User::updateOrCreate(
            ['email' => 'dinsoskabTasikmalaya@app.com'],
            [
                'name'            => 'Dinsos Kabupaten Tasikmalaya',
                'password'        => Hash::make('@dinsoskabTasikmalaya06'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kabupaten Tasikmalaya',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kabupaten Ciamis
        User::updateOrCreate(
            ['email' => 'dinsoskabCiamis@app.com'],
            [
                'name'            => 'Dinsos Kabupaten Ciamis',
                'password'        => Hash::make('@dinsoskabCiamis07'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kabupaten Ciamis',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kabupaten Kuningan
        User::updateOrCreate(
            ['email' => 'dinsoskabKuningan@app.com'],
            [
                'name'            => 'Dinsos Kabupaten Kuningan',
                'password'        => Hash::make('@dinsoskabKuningan08'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kabupaten Kuningan',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kabupaten Cirebon
        User::updateOrCreate(
            ['email' => 'dinsoskabCirebon@app.com'],
            [
                'name'            => 'Dinsos Kabupaten Cirebon',
                'password'        => Hash::make('@dinsoskabCirebon09'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kabupaten Cirebon',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kabupaten Majalengka
        User::updateOrCreate(
            ['email' => 'dinsoskabMajalengka@app.com'],
            [
                'name'            => 'Dinsos Kabupaten Majalengka',
                'password'        => Hash::make('@dinsoskabMajalengka10'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kabupaten Majalengka',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kabupaten Sumedang
        User::updateOrCreate(
            ['email' => 'dinsoskabSumedang@app.com'],
            [
                'name'            => 'Dinsos Kabupaten Sumedang',
                'password'        => Hash::make('@dinsoskabSumedang11'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kabupaten Sumedang',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kabupaten Indramayu
        User::updateOrCreate(
            ['email' => 'dinsoskabIndramayu@app.com'],
            [
                'name'            => 'Dinsos Kabupaten Indramayu',
                'password'        => Hash::make('@dinsoskabIndramayu12'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kabupaten Indramayu',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kabupaten Subang
        User::updateOrCreate(
            ['email' => 'dinsoskabSubang@app.com'],
            [
                'name'            => 'Dinsos Kabupaten Subang',
                'password'        => Hash::make('@dinsoskabSubang13'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kabupaten Subang',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kabupaten Purwakarta
        User::updateOrCreate(
            ['email' => 'dinsoskabPurwakarta@app.com'],
            [
                'name'            => 'Dinsos Kabupaten Purwakarta',
                'password'        => Hash::make('@dinsoskabPurwakarta14'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kabupaten Purwakarta',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kabupaten Karawang
        User::updateOrCreate(
            ['email' => 'dinsoskabKarawang@app.com'],
            [
                'name'            => 'Dinsos Kabupaten Karawang',
                'password'        => Hash::make('@dinsoskabKarawang15'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kabupaten Karawang',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kabupaten Bekasi
        User::updateOrCreate(
            ['email' => 'dinsoskabBekasi@app.com'],
            [
                'name'            => 'Dinsos Kabupaten Bekasi',
                'password'        => Hash::make('@dinsoskabBekasi16'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kabupaten Bekasi',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kabupaten Bandung Barat
        User::updateOrCreate(
            ['email' => 'dinsoskabBandungBarat@app.com'],
            [
                'name'            => 'Dinsos Kabupaten Bandung Barat',
                'password'        => Hash::make('@dinsoskabBandungBarat17'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kabupaten Bandung Barat',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kabupaten Pangandaran
        User::updateOrCreate(
            ['email' => 'dinsoskabPangandaran@app.com'],
            [
                'name'            => 'Dinsos Kabupaten Pangandaran',
                'password'        => Hash::make('@dinsoskabPangandaran18'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kabupaten Pangandaran',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kota Bogor
        User::updateOrCreate(
            ['email' => 'dinsoskotaBogor@app.com'],
            [
                'name'            => 'Dinsos Kota Bogor',
                'password'        => Hash::make('@dinsoskotaBogor19'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kota Bogor',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kota Sukabumi
        User::updateOrCreate(
            ['email' => 'dinsoskotaSukabumi@app.com'],
            [
                'name'            => 'Dinsos Kota Sukabumi',
                'password'        => Hash::make('@dinsoskotaSukabumi20'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kota Sukabumi',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kota Bandung
        User::updateOrCreate(
            ['email' => 'dinsoskotaBandung@app.com'],
            [
                'name'            => 'Dinsos Kota Bandung',
                'password'        => Hash::make('@dinsoskotaBandung21'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kota Bandung',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kota Cirebon
        User::updateOrCreate(
            ['email' => 'dinsoskotaCirebon@app.com'],
            [
                'name'            => 'Dinsos Kota Cirebon',
                'password'        => Hash::make('@dinsoskotaCirebon22'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kota Cirebon',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kota Bekasi
        User::updateOrCreate(
            ['email' => 'dinsoskotaBekasi@app.com'],
            [
                'name'            => 'Dinsos Kota Bekasi',
                'password'        => Hash::make('@dinsoskotaBekasi23'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kota Bekasi',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kota Depok
        User::updateOrCreate(
            ['email' => 'dinsoskotaDepok@app.com'],
            [
                'name'            => 'Dinsos Kota Depok',
                'password'        => Hash::make('@dinsoskotaDepok24'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kota Depok',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kota Cimahi
        User::updateOrCreate(
            ['email' => 'dinsoskotaCimahi@app.com'],
            [
                'name'            => 'Dinsos Kota Cimahi',
                'password'        => Hash::make('@dinsoskotaCimahi25'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kota Cimahi',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kota Tasikmalaya
        User::updateOrCreate(
            ['email' => 'dinsoskotaTasikmalaya@app.com'],
            [
                'name'            => 'Dinsos Kota Tasikmalaya',
                'password'        => Hash::make('@dinsoskotaTasikmalaya26'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kota Tasikmalaya',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // Admin - Dinsos Kota Banjar
        User::updateOrCreate(
            ['email' => 'dinsoskotaBanjar@app.com'],
            [
                'name'            => 'Dinsos Kota Banjar',
                'password'        => Hash::make('@dinsoskotaBanjar27'),
                'role'            => 'admin',
                'kabupaten_kota'  => 'Kota Banjar',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );
    }
}
