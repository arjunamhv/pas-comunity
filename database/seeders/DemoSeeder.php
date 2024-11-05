<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 50; $i++) {

            News::create([
                'title' => fake()->sentence(),
                'content' => fake()->paragraph(),
                'image' => 'https://via.placeholder.com/150',
            ]);

            Event::create([
                'title' => fake()->sentence(),
                'description' => fake()->paragraph(),
                'event_date' => fake()->date(),
                'start_time' => fake()->time(),
                'location' => fake()->city(),
                'latitude' => fake()->latitude(),
                'longitude' => fake()->longitude(),
                'image' => 'https://via.placeholder.com/150',
            ]);
        }
    }
}
