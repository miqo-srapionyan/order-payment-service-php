<?php

declare(strict_types=1);

namespace App\Core;

use function file_put_contents;
use function date;

class Logger
{
    /**
     * @param string $message
     *
     * @return void
     */
    public static function log(string $message): void
    {
        file_put_contents(__DIR__ . "/../../logs/app.log", date("[Y-m-d H:i:s]") . " " . $message . PHP_EOL, FILE_APPEND);
    }
}
