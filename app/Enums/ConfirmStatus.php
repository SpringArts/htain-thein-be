<?php

namespace App\Enums;

enum ConfirmStatus: string
{
    public const PENDING = "PENDING"; // Pending Value
    public const ACCEPTED = "ACCEPTED"; // Accepted Value
    public const REJECTED = "REJECTED"; // Rejected Value
}
