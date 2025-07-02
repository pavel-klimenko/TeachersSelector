<?php

use App\Infrastructure\Http\Teacher\Controller\TeacherController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\Routing\Requirement\Requirement;

return function (RoutingConfigurator $routes): void {



    $routes->add('homepage', '/')->controller([\App\Infrastructure\Http\HomePageController::class, 'index'])
        ->methods(['GET']);

    $routes->add('test', '/test')->controller([\App\Infrastructure\Http\TestController::class, 'index'])
        ->methods(['GET']);


    $routes->add('app_login', '/login')->controller([\App\Infrastructure\Http\Security\Controller\LoginController::class, 'index']);
    $routes->add('app_register', '/register')->controller([\App\Infrastructure\Http\Security\Controller\RegistrationController::class, 'register']);
    $routes->add('app_verify_email', '/verify/email')->controller([\App\Infrastructure\Http\Security\Controller\RegistrationController::class, 'verifyUserEmail']);



    $routes->add('teachers_get_all', '/teachers')->controller([TeacherController::class, 'getAll'])->methods(['GET']);
    $routes->add('teacher_get_by_id', '/teachers/{id}')->controller([TeacherController::class, 'getById'])
        ->requirements(['id' => Requirement::DIGITS])
        ->methods(['GET']);

    //TODO use only POST
//    $routes->add('teacher_create', '/teacher-create')->controller([TeacherController::class, 'create'])
//        ->methods(['POST']);
//    $routes->add('teacher_update', 'teacher-update/{id}')->controller([TeacherController::class, 'update'])
//        ->requirements(['id' => Requirement::DIGITS]);
//    $routes->add('teacher_delete', 'teacher-delete/{id}')->controller([TeacherController::class, 'delete'])
//        ->requirements(['id' => Requirement::DIGITS]);
};
