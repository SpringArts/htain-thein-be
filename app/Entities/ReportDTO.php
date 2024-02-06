<?php

namespace App\Entities;

class ReportDTO
{
    public int $amount;
    public string $description;
    public string $type;
    public bool $confirm_status;
    public int $reporter_id;
    public int $verifier_id;

    public function __construct(int $amount, string $description, string $type, bool $confirm_status, int $reporter_id, int $verifier_id)
    {
        $this->amount = $amount;
        $this->description = $description;
        $this->type = $type;
        $this->confirm_status = $confirm_status;
        $this->reporter_id = $reporter_id;
        $this->verifier_id = $verifier_id;
    }
}
