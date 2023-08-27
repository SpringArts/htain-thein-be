<?php

namespace Database\Seeders;

use App\Models\GeneralOutcome;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneralOutcomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GeneralOutcome::truncate();
        $data = GeneralOutcome::factory(10)->make();
        $chunks = $data->chunk(30);
        $chunks->each(function ($chunk) {
            GeneralOutcome::insert($chunk->toArray());
        });
    }
}
