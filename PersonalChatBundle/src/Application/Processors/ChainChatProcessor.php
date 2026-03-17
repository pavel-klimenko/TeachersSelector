<?php

declare(strict_types=1);

namespace PersonalChatBundle\Application\Processors;

use Psr\Container\ContainerInterface;
use PersonalChatBundle\Domain\Entity\PersonalChatMessage;

final class ChainChatProcessor
{
    /** @var array<string, ContainerInterface|array> */
    private array $locators = [];

    public function setProcessorLocatorForChannel(string $channel, ContainerInterface $locator): void
    {
        $this->locators[$channel] = $locator;
    }

    public function handle(PersonalChatMessage $message, string $channel = 'default'): PersonalChatMessage
    {
        $locator = $this->locators[$channel] ?? null;
        if ($locator === null) {
            return $message;
        }

        // Получаем список сервис id из локатора
        $serviceIds = array_keys($locator->getProvidedServices ? $locator->getProvidedServices() : []);

        $index = 0;
        $next = function(PersonalChatMessage $msg) use (&$index, $serviceIds, $locator, &$next) : PersonalChatMessage {
            if (!isset($serviceIds[$index])) {
                return $msg;
            }
            $serviceId = $serviceIds[$index++];
            $processor = $locator->get($serviceId);
            return $processor->process($msg, $next);
        };

        return $next($message);
    }
}
