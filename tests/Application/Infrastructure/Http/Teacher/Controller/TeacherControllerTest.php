<?php

namespace App\Tests\Application\Infrastructure\Http\Teacher\Controller;

use App\Application\Student\UseCase\GetTestStudentEmail;
use App\Application\Teacher\UseCase\GetTeacherHtmlData;
use App\Application\Teacher\UseCase\GetTestTeacherEmail;
use App\Infrastructure\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class TeacherControllerTest extends WebTestCase
{
    public function test_teachers_page_is_available()
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/teachers');
        $this->assertResponseIsSuccessful();
        $arTeacherHtmlData = GetTeacherHtmlData::execute();
        $this->assertSelectorTextContains('h1', $arTeacherHtmlData['list_main_title']['content']);
    }

    public function test_teacher_detail_page_is_available()
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testTeacherUser = $userRepository->findOneByEmail(GetTestTeacherEmail::execute());
        $teacher = $testTeacherUser->getTeacher();

        $client->request(Request::METHOD_GET, '/teachers/'.$teacher->getId());
        $this->assertResponseIsSuccessful();
    }

    public function test_select_teacher_page_is_available_for_student()
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);
        $testStudentUser = $userRepository->findOneByEmail(GetTestStudentEmail::execute());
        $client->loginUser($testStudentUser);

        $arTeacherHtmlData = GetTeacherHtmlData::execute();
        $client->request(Request::METHOD_GET, '/select_teachers');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', $arTeacherHtmlData['select_teachers_page_title']['content']);
    }
}
