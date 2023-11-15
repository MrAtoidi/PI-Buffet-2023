<?php

namespace App\Enums;

enum TableStatus: string
{
    case Pending = 'pending';
    case Available = 'avaliable';
    case Unavaliable = 'unavaliable';
}
