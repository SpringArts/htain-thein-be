<?php


namespace App\Entities;

class GeneralOutComeDTO
{
    public int $reporter_id;
    public int $description;
    public string $amount;

    public function __construct(int $reporter_id, int $description, string $amount)
    {
        $this->reporter_id = $reporter_id;
        $this->description = $description;
        $this->amount = $amount;
    }
}
