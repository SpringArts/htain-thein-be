<?php

namespace App\Console\Commands;

use App\Models\Announcement;
use Illuminate\Console\Command;

class DeleteAnnouncementCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:announcement-expired-records';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete records from the announcement where the due date has passed';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $now = now();
        Announcement::where('due_date', '<', $now)->delete();
        $this->info('Expired records deleted successfully.');
        return 0;
    }
}
