<?php

namespace Database\Seeders;

use App\Models\Report;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Report::truncate();
        $data = Report::factory(10)->make();
        $chunks = $data->chunk(30);
        $chunks->each(function ($chunk) {
            Report::insert($chunk->toArray());
        });
    }
}
