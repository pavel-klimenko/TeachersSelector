<?php

namespace App\Tests\Application\Infrastructure\Http\Security\Controller;

use App\Application\Student\UseCase\GetTestStudentEmail;
use App\Infrastructure\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
class SecurityControllerTest extends WebTestCase
{
    #[\Override]
    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->userRepository = static::getContainer()->get(UserRepository::class);
        $this->testStudentUser = $this->userRepository->findOneByEmail(GetTestStudentEmail::execute());
    }

    public function test_profile_page_is_available_for_authorized_user()
    {
        $this->client->loginUser($this->testStudentUser);
        $this->client->request(Request::METHOD_GET, '/profile');
        $this->assertResponseIsSuccessful();
    }

    public function test_login_page_is_available_for_unauthorized_user()
    {
        $this->client->request(Request::METHOD_GET, '/login');
        $this->assertResponseIsSuccessful();
    }

    public function test_register_page_is_available_for_unauthorized_user()
    {
        $this->client->request(Request::METHOD_GET, '/register');
        $this->assertResponseIsSuccessful();
    }
}
