<?php

namespace Alura\Pdo\Domain\Model;

use DateTimeInterface;
use DomainException;

class Student
{
    public function __construct(
        private ?int $id,
        private string $name,
        private DateTimeInterface $birthDate,
        private array $phones = []
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

    public function changeName(string $newName): void
    {
        $this->name = $newName;
    }

    public function defineId(int $id): void
    {
        if (!is_null($this->id)) {
            throw new DomainException("Você só pode definir o id uma vez");
        }
        $this->id = $id;
    }

    /**
     * @return Phone[]
     */
    public function phones(): array
    {
        return $this->phones;
    }

    public function addPhone(Phone $phone): void
    {
        $this->phones[] = $phone;
    }
}
