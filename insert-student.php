<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::create();

$student = new Student(
    id: null,
    name: 'Matheus',
    birthDate: new DateTimeImmutable('2000-01-01')
);

$sqlInsert = "
INSERT INTO students (name, birth_date)
VALUES (:name, :birth_date);
";
$statement = $pdo->prepare(query: $sqlInsert);
$statement->bindValue(
    param: ':name',
    value: $student->name()
);
$statement->bindValue(
    param: ':birth_date',
    value: $student->birthDate()->format('Y-m-d')
);
if ($statement->execute()) {
    echo "Aluno incluido";
}
