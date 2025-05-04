<?php

use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::create();

$statement = $pdo->prepare(
    query: "DELETE FROM students WHERE id = :id"
);
$statement->bindValue(
    param: ':id',
    value: 3,
    type: PDO::PARAM_INT
);
var_dump($statement->execute());
