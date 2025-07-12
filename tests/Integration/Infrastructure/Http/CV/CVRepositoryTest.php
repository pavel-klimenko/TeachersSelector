<?php

namespace App\Tests\Integration\Infrastructure\Http\CV;

use App\Application\Teacher\UseCase\GetTestTeacherEmail;
use App\Domain\Entity\CV;
use App\Domain\Entity\User;
use App\Infrastructure\Repository\CVRepository;
use App\Infrastructure\Repository\TeacherRepository;
use App\Infrastructure\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CVRepositoryTest extends WebTestCase
{
    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->userRepository = static::getContainer()->get(UserRepository::class);
        $this->teacherRepository = static::getContainer()->get(TeacherRepository::class);
        $this->CVRepository = static::getContainer()->get(CVRepository::class);
        $this->testTeacherUser = $this->userRepository->findOneByEmail(GetTestTeacherEmail::execute());
        $this->teacher = $this->testTeacherUser->getTeacher();
    }

    public function test_can_get_teacher_cv()
    {
        $cv = $this->teacher->getCv();
        $this->assertInstanceOf(CV::class, $cv);
    }

    public function test_can_get_teacher_related_user()
    {
        $relatedUser = $this->teacher->getRelatedUser();
        $this->assertInstanceOf(User::class, $relatedUser);
    }

    public function test_can_find_teacher_by_rate_par_hour()
    {
        $cv = $this->teacher->getCv();
        $ratePerHour = $cv->getRatePerHour();

        $teacherCV = $this->CVRepository->findOneBy(['rate_per_hour' => $ratePerHour]);
        $this->assertSame($ratePerHour, $teacherCV->getRatePerHour());
    }
}
