<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\Event;
use App\Models\Regency;
use App\Models\User;
use App\Models\Village;
use Illuminate\Support\Facades\Storage;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 99; $i++) {

            News::create([
                'title' => fake()->sentence(),
                'content' => fake()->paragraph(),
                'image' => 'https://via.placeholder.com/150',
            ]);

            Event::create([
                'title' => fake()->sentence(),
                'description' => fake()->paragraph(),
                'event_date' => fake()->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
                'start_time' => fake()->time(),
                'location' => fake()->city(),
                'latitude' => fake()->latitude(),
                'longitude' => fake()->longitude(),
                'image' => 'https://via.placeholder.com/150',
            ]);

            $village = Village::inRandomOrder()->first();
            $kotaLahir = Regency::inRandomOrder()->first();

            User::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => fake()->optional()->dateTime(),
                'telepon' => fake()->unique()->numerify('08##########'),
                'kota_tempat_lahir_id' => $kotaLahir->id,
                'tanggal_lahir' => fake()->date(),
                'foto' => 'https://via.placeholder.com/150',
                'provinsi_id' => substr($village->id, 0, 2),
                'kota_id' => substr($village->id, 0, 4),
                'kecamatan_id' => substr($village->id, 0, 7),
                'kelurahan_id' => $village->id,
                'kode_pos' => fake()->postcode(),
                'detail_alamat' => fake()->address(),
                'is_admin' => 0,
            ]);
        }
    }
}
