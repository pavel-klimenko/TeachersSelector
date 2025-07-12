<?php

namespace App\Tests\Integration\Infrastructure\Http\Student;

use App\Application\Student\UseCase\GetTestStudentEmail;
use App\Domain\Entity\Student;
use App\Infrastructure\Repository\StudentRepository;
use App\Infrastructure\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StudentRepositoryTest extends WebTestCase
{
    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->studentRepoMock = $this->getMockBuilder(StudentRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['findOneBy', 'getList'])
            ->getMock();

        $this->userRepository = static::getContainer()->get(UserRepository::class);
    }

    public function test_get_list_of_students()
    {
        $student1 = new Student();
        $student2 = new Student();
        $arTestStudents = [$student1, $student2];

        $this->studentRepoMock->method('getList')->willReturn($arTestStudents);

        $arStudents = $this->studentRepoMock->getList();
        $this->assertIsArray($arStudents);

        foreach ($arStudents as $item) {
            $this->assertInstanceOf(Student::class, $item);
        }

        $this->assertCount(count($arStudents), $arStudents);
    }

    public function test_get_student_returns_student(): void
    {
        $testStudentUser = $this->userRepository->findOneByEmail(GetTestStudentEmail::execute());
        $student = $testStudentUser->getStudent();
        $studentId = $student->getId();

        $this->studentRepoMock->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $studentId])
            ->willReturn($student);

        $resultStudent = $this->studentRepoMock->getStudent($studentId);
        $this->assertInstanceOf(Student::class, $resultStudent);
    }

    public function test_get_student_returns_null_if_not_found(): void
    {
        $invalidId = 999999;
        $this->studentRepoMock->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $invalidId])
            ->willReturn(null);

        $result = $this->studentRepoMock->getStudent($invalidId);
        $this->assertNull($result);
    }
}
