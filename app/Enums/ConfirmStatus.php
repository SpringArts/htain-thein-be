<?php

namespace App\Enums;

enum ConfirmStatus: int
{
    case UNCHECKED = 0;
    case CHECKED = 1;
    case ACCEPTED = 2;
    case REJECTED = 3;
}
