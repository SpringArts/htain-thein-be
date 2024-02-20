<?php

namespace Database\Seeders;

use App\Models\CancelReportHistory;
use Illuminate\Database\Seeder;

class CancelReportHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CancelReportHistory::truncate();
        $data = CancelReportHistory::factory(30)->make();
        $chunks = $data->chunk(30);
        $chunks->each(function ($chunk) {
            CancelReportHistory::insert($chunk->toArray());
        });
    }
}
