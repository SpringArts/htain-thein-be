<?php

namespace Database\Seeders;

use App\Models\ReportEditHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReportEditHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReportEditHistory::truncate();
        $data = ReportEditHistory::factory(30)->make();
        $chunks = $data->chunk(30);
        $chunks->each(function ($chunk) {
            ReportEditHistory::insert($chunk->toArray());
        });
    }
}
