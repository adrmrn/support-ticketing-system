<?php
declare(strict_types=1);

namespace App\Factories;

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class DbalConnectionFactory
{
    public static function create(): Connection
    {
        if (empty(env('DB_DATABASE')) ||
            empty(env('DB_USERNAME')) ||
            empty(env('DB_PASSWORD')) ||
            empty(env('DB_HOST')) ||
            empty(env('DB_CONNECTION'))
        ) {
            throw new \RuntimeException('Missing DbalConnection configuration.');
        }

        return DriverManager::getConnection([
            'dbname' => env('DB_DATABASE'),
            'user' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'host' => env('DB_HOST'),
            'driver' => sprintf('pdo_%s', env('DB_CONNECTION')),
        ], new Configuration());
    }
}
