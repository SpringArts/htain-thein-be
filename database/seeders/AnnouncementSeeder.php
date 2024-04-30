<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Announcement::truncate();
        $data = Announcement::factory(5)->make();
        $chunks = $data->chunk(30);
        $chunks->each(function ($chunk) {
            Announcement::insert($chunk->toArray());
        });
    }
}
