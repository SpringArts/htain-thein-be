<?php

namespace Database\Seeders;

use App\Models\CancelReportHistory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CancelReportHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CancelReportHistory::truncate();
        $data = CancelReportHistory::factory(10)->make();
        $chunks = $data->chunk(30);
        $chunks->each(function ($chunk) {
            CancelReportHistory::insert($chunk->toArray());
        });
    }
}
