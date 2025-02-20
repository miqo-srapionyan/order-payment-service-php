<?php

declare(strict_types=1);

namespace App\Enums;

enum OrderStatusEnum: int
{
    case PENDING = 0;
    case SUCCESS = 1;
}
