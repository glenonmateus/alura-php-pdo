<?php

namespace Alura\Pdo\Domain\Repository;

use DateTimeInterface;
use Alura\Pdo\Domain\Model\Student;

interface StudentRepository
{
    public function allStudents(): array;
    public function studentsWithPhones(): array;
    public function studentBirthAt(DateTimeInterface $birthDate): array;
    public function save(Student $student): bool;
    public function remove(Student $student): bool;
}
