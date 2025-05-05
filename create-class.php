<?php

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once 'vendor/autoload.php';

$connection = ConnectionCreator::create();
$studentRepository = new PdoStudentRepository($connection);

$connection->beginTransaction();
try {
    $aStudent = new Student(
        id: null,
        name: 'Glenon',
        birthDate: new DateTimeImmutable('2000-01-01')
    );
    $studentRepository->save($aStudent);
    $bStudent = new Student(
        id: null,
        name: 'Mateus',
        birthDate: new DateTimeImmutable('2000-01-01')
    );
    $studentRepository->save($bStudent);
    $connection->commit();
} catch (PDOException $e) {
    echo $e->getMessage();
    $connection->rollBack();
}
