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
        user::updateOrCreate([
            'name' => 'Diskominfo Jawa Barat',
            'email' => 'diskominfojabar@diskominfo.com',
            'password' => Hash::make('@diskominfo1'),
            'role' => 'admin',
        ]);

        user::updateOrCreate([
            'name' => 'Dinsos Provinsi Jawa Barat',
            'email' => 'dinsosprovinsijabar@dinsos.com',
            'password' => Hash::make('@dinsosprovinsi1'),
            'role' => 'admin',
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kabupaten Bogor',
            'email' => 'dinsoskabBogor@dinsos.com',
            'password' => Hash::make('@dinsoskabBogor01'),
            'role' => 'user'
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kabupaten Sukabumi',
            'email' => 'dinsoskabSukabumi@dinsos.com',
            'password' => Hash::make('@dinsoskabSukabumi02'),
            'role' => 'user'
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kabupaten Cianjur',
            'email' => 'dinsoskabCianjur@dinsos.com',
            'password' => Hash::make('@dinsoskabCianjur03'),
            'role' => 'user'
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kabupaten Bandung',
            'email' => 'dinsoskabBandung@dinsos.com',
            'password' => Hash::make('@dinsoskabBandung04'),
            'role' => 'user'
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kabupaten Garut',
            'email' => 'dinsoskabGarut@dinsos.com',
            'password' => Hash::make('@dinsoskabGarut05'),
            'role' => 'user'
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kabupaten Tasikmalaya',
            'email' => 'dinsoskabTasikmalaya@dinsos.com',
            'password' => Hash::make('@dinsoskabTasikmalaya06'),
            'role' => 'user'
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kabupaten Ciamis',
            'email' => 'dinsoskabCiamis@dinsos.com',
            'password' => Hash::make('@dinsoskabCiamis07'),
            'role' => 'user'
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kabupaten Kuningan',
            'email' => 'dinsoskabKuningan@dinsos.com',
            'password' => Hash::make('@dinsoskabKuningan08'),
            'role' => 'user'
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kabupaten Cirebon',
            'email' => 'dinsoskabCirebon@dinsos.com',
            'password' => Hash::make('@dinsoskabCirebon09'),
            'role' => 'user'
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kabupaten Majalengka',
            'email' => 'dinsoskabMajalengka@dinsos.com',
            'password' => Hash::make('@dinsoskabMajalengka10'),
            'role' => 'user'
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kabupaten Sumedang',
            'email' => 'dinsoskabSumedang@dinsos.com',
            'password' => Hash::make('@dinsoskabSumedang11'),
            'role' => 'user'
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kabupaten Indramayu ',
            'email' => 'dinsoskabIndramayu@dinsos.com',
            'password' => Hash::make('@dinsoskabIndramayu12'),
            'role' => 'user'
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kabupaten Subang',
            'email' => 'dinsoskabSubang@dinsos.com',
            'password' => Hash::make('@dinsoskabSubang13'),
            'role' => 'user'
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kabupaten Purwakarta',
            'email' => 'dinsoskabPurwakarta@dinsos.com',
            'password' => Hash::make('@dinsoskabPurwakarta14'),
            'role' => 'user'
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kabupaten Karawang',
            'email' => 'dinsoskabKarawang@dinsos.com',
            'password' => Hash::make('@dinsoskabKarawang15'),
            'role' => 'user'
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kabupaten Bekasi',
            'email' => 'dinsoskabBekasi@dinsos.com',
            'password' => Hash::make('@dinsoskabBekasi16'),
            'role' => 'user'
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kabupaten Bandung Barat',
            'email' => 'dinsoskabBandungBarat@dinsos.com',
            'password' => Hash::make('@dinsoskabBandungBarat17'),
            'role' => 'user'
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kabupaten Pangandaran',
            'email' => 'dinsoskabPangandaran@dinsos.com',
            'password' => Hash::make('@dinsoskabPangandaran18'),
            'role' => 'user'
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kota Bogor',
            'email' => 'dinsoskotaBogor@dinsos.com',
            'password' => Hash::make('@dinsoskotaBogor19'),
            'role' => 'user'
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kota Sukabumi',
            'email' => 'dinsoskotaSukabumi@dinsos.com',
            'password' => Hash::make('@dinsoskotaSukabumi20'),
            'role' => 'user'
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kota Bandung',
            'email' => 'dinsoskotaBandung@dinsos.com',
            'password' => Hash::make('@dinsoskotaBandung21'),
            'role' => 'user'
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kota Cirebon',
            'email' => 'dinsoskotaCirebon@dinsos.com',
            'password' => Hash::make('@dinsoskotaCirebon22'),
            'role' => 'user'
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kota Bekasi',
            'email' => 'dinsoskotaBekasi@dinsos.com',
            'password' => Hash::make('@dinsoskotaBekasi23'),
            'role' => 'user'
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kota Depok',
            'email' => 'dinsoskotaDepok@dinsos.com',
            'password' => Hash::make('@dinsoskotaDepok24'),
            'role' => 'user'
        ]);

        user::updateOrCreate([
            'name' => 'Dinsos Kota Cimahi',
            'email' => 'dinsoskotaCimahi@dinsos.com',
            'password' => Hash::make('@dinsoskotaCimahi25'),
            'role' => 'user',
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kota Tasikmalaya',
            'email' => 'dinsoskotaTasikmalaya@dinsos.com',
            'password' => Hash::make('@dinsoskotaTasikmalaya26'),
            'role' => 'user'
        ]);

        User::updateOrCreate([
            'name' => 'Dinsos Kota Banjar',
            'email' => 'dinsoskotaBanjar@dinsos.com',
            'password' => Hash::make('@dinsoskotaBanjar27'),
            'role' => 'user'
        ]);
    }


}
