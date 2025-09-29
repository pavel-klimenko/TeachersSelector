<?php

use App\Infrastructure\Http\Student\Controller\CommandStudentController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\Routing\Requirement\Requirement;

return function (RoutingConfigurator $routes): void {



    $routes->add('make-payment', '/make-payment')->controller([CommandStudentController::class, 'makePayment'])
        ->methods(['GET']);


    $routes->add('homepage', '/')->controller([\App\Infrastructure\Http\HomePageController::class, 'make'])
        ->methods(['GET']);

    $routes->add('health-check', '/health-check')->controller([\App\Infrastructure\Http\HealthCheckAction::class, '__invoke'])
        ->methods(['GET']);

    $routes->add('app_login', '/login')->controller([\App\Infrastructure\Http\Security\Controller\SecurityController::class, 'login']);
    $routes->add('app_profile', '/profile')->controller([\App\Infrastructure\Http\Security\Controller\SecurityController::class, 'profile']);
    $routes->add('app_logout', '/logout')->controller([\App\Infrastructure\Http\Security\Controller\SecurityController::class, 'logout']);
    $routes->add('app_register', '/register')->controller([\App\Infrastructure\Http\Security\Controller\SecurityController::class, 'register']);
    //$routes->add('app_verify_email', '/verify/email')->controller([\App\Infrastructure\Http\Security\Controller\SecurityController::class, 'verifyUserEmail']);

    $routes->add('select_teachers', '/select_teachers')->controller([CommandStudentController::class, 'selectTeachers']);
    $routes->add('teachers_get_all', '/teachers')->controller([CommandStudentController::class, 'getAll']);

    $routes->add('teacher_get_by_id', '/teachers/{id}')->controller([CommandStudentController::class, 'getById'])
        ->requirements(['id' => Requirement::DIGITS])
        ->methods(['GET']);
};
