<?php

namespace App\Tests\Application\Infrastructure\Http;

use App\Application\Homepage\UseCase\GetHomePageHtmlData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomePageControllerTest extends WebTestCase
{
    public function test_homepage_is_available()
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/');
        $this->assertResponseIsSuccessful();
        $arHomePageHtmlData = GetHomePageHtmlData::execute();

        $this->assertSelectorTextContains('h4', $arHomePageHtmlData['main_title']['content']);
    }

}
