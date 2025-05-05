<?php

use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;
use Alura\Pdo\Infrastructure\Repository\PdoStudentRepository;

require_once 'vendor/autoload.php';

$pdo = ConnectionCreator::create();
$respository = new PdoStudentRepository($pdo);
$studentList = $respository->allStudents();

var_dump($studentList);
