<?php

namespace Alura\Pdo\Domain\Model;

use DateTimeInterface;

class Student
{
    public function __construct(
        private ?int $id,
        private string $name,
        private DateTimeInterface $birthDate
    ) {
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function birthDate(): \DateTimeInterface
    {
        return $this->birthDate;
    }

    public function age(): int
    {
        return $this->birthDate
            ->diff(new \DateTimeImmutable())
            ->y;
    }
}
