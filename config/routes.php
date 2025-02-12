<?php

use App\Infrastructure\Http\Teacher\Controller\TeacherController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes): void {
    $routes->add('teachers_get_all', '/teachers')->controller([TeacherController::class, 'getAll'])->methods(['GET']);
    $routes->add('teacher_get_by_id', '/teachers/{id}')->controller([TeacherController::class, 'getById'])->methods(['GET']);

    $routes->add('teacher_create', 'teacher-create')->controller([TeacherController::class, 'create']);
    $routes->add('teacher_update', 'teacher-update/{id}')->controller([TeacherController::class, 'update']);
    $routes->add('teacher_delete', 'teacher-delete/{id}')->controller([TeacherController::class, 'delete']);
};
