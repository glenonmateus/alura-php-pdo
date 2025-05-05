<?php

namespace Alura\Pdo\Infrastructure\Persistence;

use PDO;

class ConnectionCreator
{
    public static function create(): PDO
    {
        $databasePath = __DIR__ . '/../../../banco.sqlite';
        $connection = new PDO(dsn: 'sqlite:' . $databasePath);
        $connection->setAttribute(
            attribute: PDO::ATTR_ERRMODE,
            value: PDO::ERRMODE_EXCEPTION
        );
        $connection->setAttribute(
            attribute: PDO::ATTR_DEFAULT_FETCH_MODE,
            value: PDO::FETCH_ASSOC
        );
        return $connection;
    }
}
