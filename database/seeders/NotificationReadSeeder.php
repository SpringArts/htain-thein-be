<?php

namespace Database\Seeders;

use App\Models\NotificationRead;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotificationReadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = NotificationRead::factory(40)->make();
        $chunks = $data->chunk(30);
        $chunks->each(function ($chunk) {
            NotificationRead::insert($chunk->toArray());
        });
    }
}
