<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Helper: update email lama ke baru, lalu updateOrCreate dengan email baru.
     */
    private function upsertUser(string $emailBaru, string $emailLama, array $data): void
    {
        // Jika email lama masih ada, update ke email baru dulu
        User::where('email', $emailLama)->update(['email' => $emailBaru]);

        // Kemudian updateOrCreate dengan email baru
        User::updateOrCreate(['email' => $emailBaru], $data);
    }

    public function run(): void
    {
        // ── SUPER ADMIN ──────────────────────────────────────────────
        $this->upsertUser(
            'diskominfojabar@app.com',
            'diskominfojabar@diskominfo.com',
            [
                'name'            => 'Diskominfo Jawa Barat',
                'password'        => Hash::make('@diskominfo1'),
                'role'            => 'super_admin',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        $this->upsertUser(
            'dinsosprovinsijabar@app.com',
            'dinsosprovinsijabar@dinsos.com',
            [
                'name'            => 'Dinsos Provinsi Jawa Barat',
                'password'        => Hash::make('@dinsosprovinsi1'),
                'role'            => 'super_admin',
                'approval_status' => 'approved',
                'is_active'       => true,
            ]
        );

        // ── ADMIN KABUPATEN (18) ──────────────────────────────────────
        $adminKabupaten = [
            ['email_baru' => 'dinsoskabBogor@app.com',         'email_lama' => 'dinsoskabBogor@dinsos.com',         'name' => 'Dinsos Kabupaten Bogor',         'password' => '@dinsoskabBogor01',         'kabupaten_kota' => 'Kabupaten Bogor'],
            ['email_baru' => 'dinsoskabSukabumi@app.com',      'email_lama' => 'dinsoskabSukabumi@dinsos.com',      'name' => 'Dinsos Kabupaten Sukabumi',      'password' => '@dinsoskabSukabumi02',      'kabupaten_kota' => 'Kabupaten Sukabumi'],
            ['email_baru' => 'dinsoskabCianjur@app.com',       'email_lama' => 'dinsoskabCianjur@dinsos.com',       'name' => 'Dinsos Kabupaten Cianjur',       'password' => '@dinsoskabCianjur03',       'kabupaten_kota' => 'Kabupaten Cianjur'],
            ['email_baru' => 'dinsoskabBandung@app.com',       'email_lama' => 'dinsoskabBandung@dinsos.com',       'name' => 'Dinsos Kabupaten Bandung',       'password' => '@dinsoskabBandung04',       'kabupaten_kota' => 'Kabupaten Bandung'],
            ['email_baru' => 'dinsoskabGarut@app.com',         'email_lama' => 'dinsoskabGarut@dinsos.com',         'name' => 'Dinsos Kabupaten Garut',         'password' => '@dinsoskabGarut05',         'kabupaten_kota' => 'Kabupaten Garut'],
            ['email_baru' => 'dinsoskabTasikmalaya@app.com',   'email_lama' => 'dinsoskabTasikmalaya@dinsos.com',   'name' => 'Dinsos Kabupaten Tasikmalaya',   'password' => '@dinsoskabTasikmalaya06',   'kabupaten_kota' => 'Kabupaten Tasikmalaya'],
            ['email_baru' => 'dinsoskabCiamis@app.com',        'email_lama' => 'dinsoskabCiamis@dinsos.com',        'name' => 'Dinsos Kabupaten Ciamis',        'password' => '@dinsoskabCiamis07',        'kabupaten_kota' => 'Kabupaten Ciamis'],
            ['email_baru' => 'dinsoskabKuningan@app.com',      'email_lama' => 'dinsoskabKuningan@dinsos.com',      'name' => 'Dinsos Kabupaten Kuningan',      'password' => '@dinsoskabKuningan08',      'kabupaten_kota' => 'Kabupaten Kuningan'],
            ['email_baru' => 'dinsoskabCirebon@app.com',       'email_lama' => 'dinsoskabCirebon@dinsos.com',       'name' => 'Dinsos Kabupaten Cirebon',       'password' => '@dinsoskabCirebon09',       'kabupaten_kota' => 'Kabupaten Cirebon'],
            ['email_baru' => 'dinsoskabMajalengka@app.com',    'email_lama' => 'dinsoskabMajalengka@dinsos.com',    'name' => 'Dinsos Kabupaten Majalengka',    'password' => '@dinsoskabMajalengka10',    'kabupaten_kota' => 'Kabupaten Majalengka'],
            ['email_baru' => 'dinsoskabSumedang@app.com',      'email_lama' => 'dinsoskabSumedang@dinsos.com',      'name' => 'Dinsos Kabupaten Sumedang',      'password' => '@dinsoskabSumedang11',      'kabupaten_kota' => 'Kabupaten Sumedang'],
            ['email_baru' => 'dinsoskabIndramayu@app.com',     'email_lama' => 'dinsoskabIndramayu@dinsos.com',     'name' => 'Dinsos Kabupaten Indramayu',     'password' => '@dinsoskabIndramayu12',     'kabupaten_kota' => 'Kabupaten Indramayu'],
            ['email_baru' => 'dinsoskabSubang@app.com',        'email_lama' => 'dinsoskabSubang@dinsos.com',        'name' => 'Dinsos Kabupaten Subang',        'password' => '@dinsoskabSubang13',        'kabupaten_kota' => 'Kabupaten Subang'],
            ['email_baru' => 'dinsoskabPurwakarta@app.com',    'email_lama' => 'dinsoskabPurwakarta@dinsos.com',    'name' => 'Dinsos Kabupaten Purwakarta',    'password' => '@dinsoskabPurwakarta14',    'kabupaten_kota' => 'Kabupaten Purwakarta'],
            ['email_baru' => 'dinsoskabKarawang@app.com',      'email_lama' => 'dinsoskabKarawang@dinsos.com',      'name' => 'Dinsos Kabupaten Karawang',      'password' => '@dinsoskabKarawang15',      'kabupaten_kota' => 'Kabupaten Karawang'],
            ['email_baru' => 'dinsoskabBekasi@app.com',        'email_lama' => 'dinsoskabBekasi@dinsos.com',        'name' => 'Dinsos Kabupaten Bekasi',        'password' => '@dinsoskabBekasi16',        'kabupaten_kota' => 'Kabupaten Bekasi'],
            ['email_baru' => 'dinsoskabBandungBarat@app.com',  'email_lama' => 'dinsoskabBandungBarat@dinsos.com',  'name' => 'Dinsos Kabupaten Bandung Barat', 'password' => '@dinsoskabBandungBarat17',  'kabupaten_kota' => 'Kabupaten Bandung Barat'],
            ['email_baru' => 'dinsoskabPangandaran@app.com',   'email_lama' => 'dinsoskabPangandaran@dinsos.com',   'name' => 'Dinsos Kabupaten Pangandaran',   'password' => '@dinsoskabPangandaran18',   'kabupaten_kota' => 'Kabupaten Pangandaran'],
        ];

        // ── ADMIN KOTA (9) ────────────────────────────────────────────
        $adminKota = [
            ['email_baru' => 'dinsoskotaBogor@app.com',        'email_lama' => 'dinsoskotaBogor@dinsos.com',        'name' => 'Dinsos Kota Bogor',        'password' => '@dinsoskotaBogor19',        'kabupaten_kota' => 'Kota Bogor'],
            ['email_baru' => 'dinsoskotaSukabumi@app.com',     'email_lama' => 'dinsoskotaSukabumi@dinsos.com',     'name' => 'Dinsos Kota Sukabumi',     'password' => '@dinsoskotaSukabumi20',     'kabupaten_kota' => 'Kota Sukabumi'],
            ['email_baru' => 'dinsoskotaBandung@app.com',      'email_lama' => 'dinsoskotaBandung@dinsos.com',      'name' => 'Dinsos Kota Bandung',      'password' => '@dinsoskotaBandung21',      'kabupaten_kota' => 'Kota Bandung'],
            ['email_baru' => 'dinsoskotaCirebon@app.com',      'email_lama' => 'dinsoskotaCirebon@dinsos.com',      'name' => 'Dinsos Kota Cirebon',      'password' => '@dinsoskotaCirebon22',      'kabupaten_kota' => 'Kota Cirebon'],
            ['email_baru' => 'dinsoskotaBekasi@app.com',       'email_lama' => 'dinsoskotaBekasi@dinsos.com',       'name' => 'Dinsos Kota Bekasi',       'password' => '@dinsoskotaBekasi23',       'kabupaten_kota' => 'Kota Bekasi'],
            ['email_baru' => 'dinsoskotaDepok@app.com',        'email_lama' => 'dinsoskotaDepok@dinsos.com',        'name' => 'Dinsos Kota Depok',        'password' => '@dinsoskotaDepok24',        'kabupaten_kota' => 'Kota Depok'],
            ['email_baru' => 'dinsoskotaCimahi@app.com',       'email_lama' => 'dinsoskotaCimahi@dinsos.com',       'name' => 'Dinsos Kota Cimahi',       'password' => '@dinsoskotaCimahi25',       'kabupaten_kota' => 'Kota Cimahi'],
            ['email_baru' => 'dinsoskotaTasikmalaya@app.com',  'email_lama' => 'dinsoskotaTasikmalaya@dinsos.com',  'name' => 'Dinsos Kota Tasikmalaya',  'password' => '@dinsoskotaTasikmalaya26',  'kabupaten_kota' => 'Kota Tasikmalaya'],
            ['email_baru' => 'dinsoskotaBanjar@app.com',       'email_lama' => 'dinsoskotaBanjar@dinsos.com',       'name' => 'Dinsos Kota Banjar',       'password' => '@dinsoskotaBanjar27',       'kabupaten_kota' => 'Kota Banjar'],
        ];

        foreach (array_merge($adminKabupaten, $adminKota) as $admin) {
            $this->upsertUser(
                $admin['email_baru'],
                $admin['email_lama'],
                [
                    'name'            => $admin['name'],
                    'password'        => Hash::make($admin['password']),
                    'role'            => 'admin',
                    'kabupaten_kota'  => $admin['kabupaten_kota'],
                    'approval_status' => 'approved',
                    'is_active'       => true,
                ]
            );
        }
    }
}
