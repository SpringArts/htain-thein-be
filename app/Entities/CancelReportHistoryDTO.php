<?php

namespace App\Entities;

class CancelReportHistoryDTO
{
    public int $reporter_id;
    public int $rejecter_id;
    public string $description;
    public string $amount;
    public string $type;

    public function __construct(int $reporter_id, int $rejecter_id, string $description, string $amount, string $type)
    {
        $this->reporter_id = $reporter_id;
        $this->rejecter_id = $rejecter_id;
        $this->description = $description;
        $this->amount = $amount;
        $this->type = $type;
    }
}
