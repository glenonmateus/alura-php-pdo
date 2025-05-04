<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::create();

$statement = $pdo->query(query: 'SELECT * FROM students');
$studentDataList = $statement->fetchAll(mode: PDO::FETCH_ASSOC);
$studentList = [];

foreach ($studentDataList as $student) {
    $studentList[] = new Student(
        id: $student['id'],
        name: $student['name'],
        birthDate: new DateTimeImmutable($student['birth_date'])
    );
}

var_dump($studentList);
