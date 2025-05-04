<?php

use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::create();

$statement = $pdo->query(
    query: 'CREATE TABLE IF NOT EXISTS students (id INT PRIMARY KEY AUTOINCREMENT, name TEXT, birth_date TEXT);'
);
var_dump($statement->execute());
