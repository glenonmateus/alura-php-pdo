<?php

use Alura\Pdo\Infrastructure\Persistence\ConnectionCreator;

require_once 'vendor/autoload.php';

$connection = ConnectionCreator::create();

$sql = '
  CREATE TABLE IF NOT EXISTS students (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT,
    birth_date TEXT
  );
  CREATE TABLE IF NOT EXISTS phones (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    area_code TEXT,
    number TEXT,
    student_id INTEGER,
    FOREIGN KEY (student_id) REFERENCES students (id)
  );
';

$connection->exec($sql);
