<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

use function getenv;

class Database
{
    /**
     * @var \PDO|null
     */
    private static ?PDO $connection = null;

    /**
     * @return \PDO
     */
    public static function connect(): PDO
    {
        if (self::$connection === null) {
            $host = getenv('DB_HOST');
            $dbname = getenv('DB_NAME');
            $user = getenv('DB_USER');
            $pass = getenv('DB_PASS');

            try {
                self::$connection = new PDO(
                    "mysql:host={$host};dbname={$dbname}",
                    $user,
                    $pass
                );
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Database connection failed: ".$e->getMessage());
            }
        }

        return self::$connection;
    }
}
