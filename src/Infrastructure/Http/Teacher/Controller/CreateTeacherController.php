<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Teacher\Controller;

use App\Application\Teacher\CreateTeacherUseCase;
use App\Infrastructure\Services\TeacherService;
use Doctrine\DBAL\Connection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CreateTeacherController extends AbstractController
{
    public function __construct(
        private CreateTeacherUseCase $createTeacherUseCase
    ){}

    public function createTeacher(Connection $connection)
    {
        $result = $connection->fetchAllAssociative('SELECT version();');

        return $this->json(['status' => $result]);
    }

//    public function createTeacher(): Response
//    {
//        $worker = $this->createTeacherUseCase->execute();
//        dd($worker);
//    }

    public function newMessage(TeacherService $teacherService): Response
    {
        // thanks to the type-hint, the container will instantiate a
        // new MessageGenerator and pass it to you!
        // ...

        $message = $teacherService->getHappyMessage();

        dd($message);

        //$this->addFlash('success', $message);
        // ...
    }


//    public function getTeachersList(): Response
//    {
//        return $this->render('teachers.html.twig');
//    }
}
