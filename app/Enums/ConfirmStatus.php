<?php

namespace App\Enums;

enum ConfirmStatus: int
{
    case UNCHECKED = 0; //Unchecked Value
    case CHECKED = 1; //Checked Value
    case ACCEPTED = 2; //Accepted Value
    case REJECTED = 3; //Rejected Value
}
