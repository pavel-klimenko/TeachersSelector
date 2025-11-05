<?php

use App\Infrastructure\Http\Payment\Controller\PaymentController;
use App\Infrastructure\Http\Student\Controller\CommandStudentController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\Routing\Requirement\Requirement;
use App\Infrastructure\Http\Teacher\Controller\TeacherController;

return function (RoutingConfigurator $routes): void {


    $routes->add('personal-chats', '/personal-chats')->controller([\App\Infrastructure\Http\Chats\PersonalChat\Controller\ChatController::class, 'openChat'])
        ->methods(['GET']);

    //TODO CQRS (create protected API methods)
    $routes->add('create-chat', '/create-chat')->controller([\App\Infrastructure\Http\Chats\PersonalChat\Controller\CommandPersonalChatController::class, 'createChat'])
        ->methods(['GET']);
    $routes->add('create-chat-message', '/create-chat-message')->controller([\App\Infrastructure\Http\Chats\PersonalChatMessages\Controller\CommandPersonalChatMessagesController::class, 'createChatMessage'])
        ->methods(['GET']);
    $routes->add('make-payment', '/make-payment')->controller([CommandStudentController::class, 'makePayment'])
        ->methods(['GET']);
    $routes->add('get-payment', '/get-payment')->controller([\App\Infrastructure\Http\Student\Controller\QueryStudentController::class, 'getPayment'])
        ->methods(['GET']);
    $routes->add('stripe-show-payment-from', '/stripe-show-payment-from')->controller([PaymentController::class, 'showPaymentFrom'])
        ->methods(['GET','POST']);


    $routes->add('homepage', '/')->controller([\App\Infrastructure\Http\HomePageController::class, 'index'])
        ->methods(['GET']);

    $routes->add('health-check', '/health-check')->controller([\App\Infrastructure\Http\HealthCheckAction::class, '__invoke'])
        ->methods(['GET']);

    $routes->add('app_login', '/login')->controller([\App\Infrastructure\Http\Security\Controller\SecurityController::class, 'login']);
    $routes->add('app_profile', '/profile')->controller([\App\Infrastructure\Http\Security\Controller\SecurityController::class, 'profile']);
    $routes->add('app_logout', '/logout')->controller([\App\Infrastructure\Http\Security\Controller\SecurityController::class, 'logout']);
    $routes->add('app_register', '/register')->controller([\App\Infrastructure\Http\Security\Controller\SecurityController::class, 'register']);
    //$routes->add('app_verify_email', '/verify/email')->controller([\App\Infrastructure\Http\Security\Controller\SecurityController::class, 'verifyUserEmail']);

    $routes->add('select_teachers', '/select_teachers')->controller([TeacherController::class, 'selectTeachers']);
    $routes->add('teachers_get_all', '/teachers')->controller([TeacherController::class, 'getAll']);

    $routes->add('teacher_get_by_id', '/teachers/{id}')->controller([TeacherController::class, 'getById'])
        ->requirements(['id' => Requirement::DIGITS])
        ->methods(['GET']);
};
