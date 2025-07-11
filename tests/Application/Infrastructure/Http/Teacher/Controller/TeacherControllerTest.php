<?php

namespace App\Tests\Application\Infrastructure\Http\Teacher\Controller;

use App\Application\Teacher\UseCase\GetTeacherHtmlData;
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
        $randomTeacherId = 1; //TODO запросить рандомный ID учителя
        $client->request(Request::METHOD_GET, '/teachers/'.$randomTeacherId);
        $this->assertResponseIsSuccessful();
    }
}
