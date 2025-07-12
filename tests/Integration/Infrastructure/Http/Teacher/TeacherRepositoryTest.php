<?php

namespace App\Tests\Integration\Infrastructure\Http\Teacher;

use App\Application\Teacher\UseCase\GetTestTeacherEmail;
use App\Domain\Entity\Teacher;
use App\Infrastructure\Repository\TeacherRepository;
use App\Infrastructure\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TeacherRepositoryTest extends WebTestCase
{
    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->teacherRepoMock = $this->getMockBuilder(TeacherRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['findOneBy', 'getList'])
            ->getMock();

        $this->userRepository = static::getContainer()->get(UserRepository::class);
    }

    public function test_get_list_of_teachers()
    {
        $teacher1 = new Teacher();
        $teacher2 = new Teacher();
        $arTestTeachers = [$teacher1, $teacher2];

        $this->teacherRepoMock->method('getList')->willReturn($arTestTeachers);

        $arTeachers = $this->teacherRepoMock->getList();
        $this->assertIsArray($arTeachers);

        foreach ($arTeachers as $item) {
            $this->assertInstanceOf(Teacher::class, $item);
        }

        $this->assertCount(count($arTestTeachers), $arTeachers);
    }

    public function test_get_teacher_returns_teacher(): void
    {
        $testTeacherUser = $this->userRepository->findOneByEmail(GetTestTeacherEmail::execute());
        $teacher = $testTeacherUser->getTeacher();
        $teacherId = $teacher->getId();

        $this->teacherRepoMock->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $teacherId])
            ->willReturn($teacher);

        $resultTeacher = $this->teacherRepoMock->getTeacher($teacherId);
        $this->assertInstanceOf(Teacher::class, $resultTeacher);
    }

    public function test_get_teacher_returns_null_if_not_found(): void
    {
        $invalidId = 999999;
        $this->teacherRepoMock->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => $invalidId])
            ->willReturn(null);

        $result = $this->teacherRepoMock->getTeacher($invalidId);
        $this->assertNull($result);
    }
}
