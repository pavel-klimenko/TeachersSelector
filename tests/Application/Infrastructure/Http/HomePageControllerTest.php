<?php

namespace App\Tests\Application\Infrastructure\Http;

use App\Application\Homepage\UseCase\GetHomePageHtmlData;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomePageControllerTest extends WebTestCase
{
    public function test_homepage()
    {
        $client = static::createClient();
        $client->request(Request::METHOD_GET, '/');
        $this->assertResponseIsSuccessful();

        $homePageHtmlData = GetHomePageHtmlData::execute();

        $this->assertSelectorTextContains('h4', $homePageHtmlData['main_title']['content']);
    }

}
