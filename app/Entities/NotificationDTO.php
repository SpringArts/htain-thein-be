<?php

namespace App\Entities;

class NotificationDTO
{
    public int $user_id;
    public int $report_id;
    public bool $check_status;

    public function __construct(int $user_id, int $report_id, bool $check_status)
    {
        $this->user_id = $user_id;
        $this->report_id = $report_id;
        $this->check_status = $check_status;
    }
}
