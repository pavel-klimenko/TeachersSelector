<?php

declare(strict_types=1);

namespace PersonalChatBundle;


use Symfony\Component\HttpKernel\Bundle\Bundle;
use PersonalChatBundle\DependencyInjection\PersonalChatExtension;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;


class PersonalChatBundle extends Bundle
{
    public function getContainerExtension(): ?PersonalChatExtension
    {
        return new PersonalChatExtension();
    }

    public function configureRoutes(RoutingConfigurator $routes): void {
         $routes->import(__DIR__.'/Infrastructure/HTTP/Controller/', 'attribute');
    }

    // public function configureRoutes(RoutingConfigurator $routes): void
    // {
    //     // Импортируем атрибуты из контроллеров
    //     $routes->import(__DIR__ . '/Infrastructure/HTTP/Controller/', 'attribute');
    // }
}
