<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Super Admin - Diskominfo Jawa Barat
        User::updateOrCreate(
            ['email' => 'diskominfojabar@diskominfo.com'],
            [
                'name' => 'Diskominfo Jawa Barat',
                'password' => Hash::make('@diskominfo1'),
                'role' => 'super_admin',
            ]
        );

        // Super Admin - Dinsos Provinsi Jawa Barat
        User::updateOrCreate(
            ['email' => 'dinsosprovinsijabar@dinsos.com'],
            [
                'name' => 'Dinsos Provinsi Jawa Barat',
                'password' => Hash::make('@dinsosprovinsi1'),
                'role' => 'super_admin',
            ]
        );

        // Admin - Dinsos Kabupaten (18 Kabupaten)
        User::updateOrCreate(
            ['email' => 'dinsoskabBogor@dinsos.com'],
            [
                'name' => 'Dinsos Kabupaten Bogor',
                'password' => Hash::make('@dinsoskabBogor01'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'dinsoskabSukabumi@dinsos.com'],
            [
                'name' => 'Dinsos Kabupaten Sukabumi',
                'password' => Hash::make('@dinsoskabSukabumi02'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'dinsoskabCianjur@dinsos.com'],
            [
                'name' => 'Dinsos Kabupaten Cianjur',
                'password' => Hash::make('@dinsoskabCianjur03'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'dinsoskabBandung@dinsos.com'],
            [
                'name' => 'Dinsos Kabupaten Bandung',
                'password' => Hash::make('@dinsoskabBandung04'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'dinsoskabGarut@dinsos.com'],
            [
                'name' => 'Dinsos Kabupaten Garut',
                'password' => Hash::make('@dinsoskabGarut05'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'dinsoskabTasikmalaya@dinsos.com'],
            [
                'name' => 'Dinsos Kabupaten Tasikmalaya',
                'password' => Hash::make('@dinsoskabTasikmalaya06'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'dinsoskabCiamis@dinsos.com'],
            [
                'name' => 'Dinsos Kabupaten Ciamis',
                'password' => Hash::make('@dinsoskabCiamis07'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'dinsoskabKuningan@dinsos.com'],
            [
                'name' => 'Dinsos Kabupaten Kuningan',
                'password' => Hash::make('@dinsoskabKuningan08'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'dinsoskabCirebon@dinsos.com'],
            [
                'name' => 'Dinsos Kabupaten Cirebon',
                'password' => Hash::make('@dinsoskabCirebon09'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'dinsoskabMajalengka@dinsos.com'],
            [
                'name' => 'Dinsos Kabupaten Majalengka',
                'password' => Hash::make('@dinsoskabMajalengka10'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'dinsoskabSumedang@dinsos.com'],
            [
                'name' => 'Dinsos Kabupaten Sumedang',
                'password' => Hash::make('@dinsoskabSumedang11'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'dinsoskabIndramayu@dinsos.com'],
            [
                'name' => 'Dinsos Kabupaten Indramayu',
                'password' => Hash::make('@dinsoskabIndramayu12'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'dinsoskabSubang@dinsos.com'],
            [
                'name' => 'Dinsos Kabupaten Subang',
                'password' => Hash::make('@dinsoskabSubang13'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'dinsoskabPurwakarta@dinsos.com'],
            [
                'name' => 'Dinsos Kabupaten Purwakarta',
                'password' => Hash::make('@dinsoskabPurwakarta14'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'dinsoskabKarawang@dinsos.com'],
            [
                'name' => 'Dinsos Kabupaten Karawang',
                'password' => Hash::make('@dinsoskabKarawang15'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'dinsoskabBekasi@dinsos.com'],
            [
                'name' => 'Dinsos Kabupaten Bekasi',
                'password' => Hash::make('@dinsoskabBekasi16'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'dinsoskabBandungBarat@dinsos.com'],
            [
                'name' => 'Dinsos Kabupaten Bandung Barat',
                'password' => Hash::make('@dinsoskabBandungBarat17'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'dinsoskabPangandaran@dinsos.com'],
            [
                'name' => 'Dinsos Kabupaten Pangandaran',
                'password' => Hash::make('@dinsoskabPangandaran18'),
                'role' => 'admin'
            ]
        );

        // Admin - Dinsos Kota (9 Kota)
        User::updateOrCreate(
            ['email' => 'dinsoskotaBogor@dinsos.com'],
            [
                'name' => 'Dinsos Kota Bogor',
                'password' => Hash::make('@dinsoskotaBogor19'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'dinsoskotaSukabumi@dinsos.com'],
            [
                'name' => 'Dinsos Kota Sukabumi',
                'password' => Hash::make('@dinsoskotaSukabumi20'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'dinsoskotaBandung@dinsos.com'],
            [
                'name' => 'Dinsos Kota Bandung',
                'password' => Hash::make('@dinsoskotaBandung21'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'dinsoskotaCirebon@dinsos.com'],
            [
                'name' => 'Dinsos Kota Cirebon',
                'password' => Hash::make('@dinsoskotaCirebon22'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'dinsoskotaBekasi@dinsos.com'],
            [
                'name' => 'Dinsos Kota Bekasi',
                'password' => Hash::make('@dinsoskotaBekasi23'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'dinsoskotaDepok@dinsos.com'],
            [
                'name' => 'Dinsos Kota Depok',
                'password' => Hash::make('@dinsoskotaDepok24'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'dinsoskotaCimahi@dinsos.com'],
            [
                'name' => 'Dinsos Kota Cimahi',
                'password' => Hash::make('@dinsoskotaCimahi25'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'dinsoskotaTasikmalaya@dinsos.com'],
            [
                'name' => 'Dinsos Kota Tasikmalaya',
                'password' => Hash::make('@dinsoskotaTasikmalaya26'),
                'role' => 'admin'
            ]
        );

        User::updateOrCreate(
            ['email' => 'dinsoskotaBanjar@dinsos.com'],
            [
                'name' => 'Dinsos Kota Banjar',
                'password' => Hash::make('@dinsoskotaBanjar27'),
                'role' => 'admin'
            ]
        );

    }


}
