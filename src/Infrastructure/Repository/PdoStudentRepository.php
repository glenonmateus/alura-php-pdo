<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Model\Phone;
use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Domain\Repository\StudentRepository;
use DateTimeImmutable;
use DateTimeInterface;
use PDO;
use PDOStatement;

class PdoStudentRepository implements StudentRepository
{
    public function __construct(
        private PDO $_connection
    ) {
    }

    public function allStudents(): array
    {
        $statement = $this->_connection->query(
            query: 'SELECT * FROM students'
        );
        return $this->hydrateStudentList($statement);
    }

    public function studentBirthAt(DateTimeInterface $birthDate): array
    {
        $statement = $this->_connection->prepare(
            query: "SELECT * FROM students WHERE birth_date = :birth_date"
        );
        $statement->bindValue(':birth_date', $birthDate->format('Y-m-d'));
        $statement->execute();
        return $this->hydrateStudentList($statement);
    }

    /**
     * @return Student[]
     */
    public function hydrateStudentList(PDOStatement $statement): array
    {
        $studentDataList = $statement->fetchAll(mode: PDO::FETCH_ASSOC);
        $studentList = [];
        foreach ($studentDataList as $student) {
            $newStudent = new Student(
                id: $student['id'],
                name: $student['name'],
                birthDate: new DateTimeImmutable($student['birth_date'])
            );
            $studentList[] = $newStudent;
        }
        return $studentList;
    }

    public function save(Student $student): bool
    {
        if ($student->id() === null) {
            return $this->insert($student);
        }
        return $this->update($student);
    }

    public function insert(Student $student): bool
    {
        $statement = $this->_connection->prepare(
            query: "INSERT INTO students (name, birth_date) VALUES (:name, :birth_date)"
        );
        $success = $statement->execute(
            [
            ":name" => $student->name(),
            ":birth_date" => $student->birthDate()->format('Y-m-d')
            ]
        );
        if ($success) {
            $student->defineId($this->_connection->lastInsertId());
        }
        return $success;
    }

    public function update(Student $student): bool
    {
        $statement = $this->_connection->prepare(
            query: 'UPDATE students SET name = :name, birth_date = :birth_date WHERE id = :id'
        );
        return $statement->execute(
            [
            ':name' => $student->name(),
            ':birth_date' => $student->birthDate()->format('Y-m-d'),
            ':id' => $student->id()
            ]
        );
    }

    public function remove(Student $student): bool
    {
        $statement = $this->_connection->prepare(
            query: 'DELETE FROM students WHERE id = :id'
        );
        $statement->bindValue(':id', $student->id());
        return $statement->execute();
    }

    private function _fillPhoneOf(Student $student): void
    {
        $statement = $this->_connection->prepare(
            query: 'SELECT * FROM phones WHERE student_id = :student_id'
        );
        $statement->bindValue(':student_id', $student->id());
        $statement->execute();
        $phoneDataList = $statement->fetchAll();
        foreach ($phoneDataList as $phoneData) {
            $phone = new Phone(
                id: $phoneData['id'],
                areaCode: $phoneData['area_code'],
                number: $phoneData['number']
            );
            $student->addPhone($phone);
        }
    }

    public function studentsWithPhones(): array
    {
        $sql = '
          SELECT
            students.id,
            students.name,
            students.birth_date,
            phones.id AS phone_id,
            phones.area_code,
            phones.number
          FROM
            students
          JOIN
            phones ON students.id = phones.student_id
        ';
        $statement = $this->_connection->query($sql);
        $result = $statement->fetchAll();
        $studentList = [];
        foreach ($result as $row) {
            if (!array_key_exists($row['id'], $studentList)) {
                $studentList[$row['id']] = new Student(
                    id: $row['id'],
                    name: $row['name'],
                    birthDate: new DateTimeImmutable($row['birth_date'])
                );
            }
            $phone = new Phone(
                id: $row['phone_id'],
                areaCode: $row['area_code'],
                number: $row['number']
            );
            $studentList[$row['id']]->addPhone($phone);
        }
        return $studentList;
    }
}
