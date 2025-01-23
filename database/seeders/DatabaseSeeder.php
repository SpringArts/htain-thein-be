<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ReportSeeder::class,
            AnnouncementSeeder::class,

            NotiInfoSeeder::class,
            // CancelReportHistorySeeder::class,
            // ReportEditHistorySeeder::class,
            // GeneralOutcomeSeeder::class,
            NotificationReadSeeder::class
        ]);
    }
}
