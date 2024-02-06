<?php

namespace App\Entities;

class ContactInfoDTO
{
    public int $name;
    public string $email;
    public string $message;

    public function __construct(int $name, string $email, string $message)
    {
        $this->name = $name;
        $this->email = $email;
        $this->message = $message;
    }
}
