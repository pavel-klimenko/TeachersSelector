<?php

declare(strict_types=1);

namespace PersonalChatBundle;


use PersonalChatBundle\DependencyInjection\Compiler\ChatProcessorPass;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use PersonalChatBundle\DependencyInjection\PersonalChatExtension;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;


class PersonalChatBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        // Регистрируем CompilerPass, который соберёт теги и создаст ServiceLocator / pipeline
        $container->addCompilerPass(new ChatProcessorPass());
    }


    public function getContainerExtension(): ?PersonalChatExtension
    {
        return new PersonalChatExtension();
    }

    public function configureRoutes(RoutingConfigurator $routes): void {
         $routes->import(__DIR__.'/Infrastructure/HTTP/Controller/', 'attribute');
    }
}
