<?php

declare(strict_types=1);

namespace App\Core;

use Dotenv\Dotenv;

use function file_exists;

class DotenvHandler
{
    /**
     * Load the environment variables from the .env file.
     *
     * @param string $envFilePath
     */
    public static function load(string $envFilePath): void
    {
        // Ensure .env file exists before loading
        if (!file_exists($envFilePath)) {
            throw new \RuntimeException("Environment file not found at {$envFilePath}");
        }

        // Load the environment variables
        $dotenv = Dotenv::createImmutable($envFilePath);
        $dotenv->load();
    }
}
