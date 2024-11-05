<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Agus',
            'kota_tempat_lahir_id' => '1101',
            'tanggal_lahir' => '2001-01-01',
            'provinsi_id' => '11',
            'kota_id' => '1101',
            'kecamatan_id' => '1101010',
            'kelurahan_id' => '1101010001',
            'kode_pos' => '23898',
            'is_admin' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
