<?php

namespace Database\Seeders;

use App\Models\NotiInfo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NotiInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NotiInfo::truncate();
        $data = NotiInfo::factory(30)->make();
        $chunks = $data->chunk(30);
        $chunks->each(function ($chunk) {
            NotiInfo::insert($chunk->toArray());
        });
    }
}
