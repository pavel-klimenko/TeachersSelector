<?php

declare(strict_types=1);

namespace PersonalChatBundle\DependencyInjection\Compiler;

use PersonalChatBundle\Application\Processors\ChainChatProcessor;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Argument\ServiceLocatorArgument;

final class ChatProcessorPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition(ChainChatProcessor::class) && !$container->hasAlias(ChainChatProcessor::class)) {
            return;
        }

        $chainDef = $container->findDefinition(ChainChatProcessor::class);

        $tagged = $container->findTaggedServiceIds('app.chat.processor');

        $byChannel = [];
        foreach ($tagged as $id => $tags) {
            foreach ($tags as $attributes) {
                $channel = $attributes['channel'] ?? 'default';
                $priority = (int)($attributes['priority'] ?? 0);
                $byChannel[$channel][$priority][] = $id;
            }
        }

        foreach ($byChannel as $channel => $groups) {
            krsort($groups); // higher priority first
            $flat = [];
            foreach ($groups as $group) {
                foreach ($group as $serviceId) {
                    $flat[$serviceId] = new Reference($serviceId);
                }
            }

            // Создаём ServiceLocatorArgument из массива Reference
            $locator = new ServiceLocatorArgument($flat);

            // Регистрируем локатор как приватный сервис и передаём в ChainChatProcessor
            $locatorServiceId = 'app.chat.processor_locator.' . $channel;
            $container->setDefinition($locatorServiceId, (new Definition(\Psr\Container\ContainerInterface::class))
                ->setFactory([ServiceLocatorArgument::class, 'create']) // не обязательно, можно оставить ServiceLocatorArgument напрямую
                ->setPublic(false)
            );

            // Вместо отдельной дефиниции используем ServiceLocatorArgument напрямую в методе
            $chainDef->addMethodCall('setProcessorLocatorForChannel', [$channel, $locator]);
        }
    }
}
