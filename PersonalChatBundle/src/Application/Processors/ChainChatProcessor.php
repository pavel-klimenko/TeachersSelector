<?php

declare(strict_types=1);

namespace PersonalChatBundle\Application\Processors;

use Psr\Container\ContainerInterface;
use PersonalChatBundle\Domain\Entity\PersonalChatMessage;
use PersonalChatBundle\Domain\ValueObject\PersonalChatMessage\Message as MessageVO;


final class ChainChatProcessor
{

    /** @var array<string, ContainerInterface|array> */
    private array $locators;

    public function __construct(array $locators = [])
    {
        $this->locators['default'] = $locators;
    }

    public function setProcessorLocatorForChannel(string $channel, ContainerInterface $locator): void
    {
        $this->locators[$channel] = $locator;
    }

    public function handle(MessageVO $messageVO, string $channel = 'default'): MessageVO
    {
        dump('Handled message in processor');
        dd($messageVO);

//        $locator = $this->locators[$channel] ?? null;
//        if ($locator === null) {
//            return $message;
//        }
//
//        // Получаем список сервис id из локатора
//        $serviceIds = array_keys($locator->getProvidedServices ? $locator->getProvidedServices() : []);
//
//        $index = 0;
//        $next = function(PersonalChatMessage $msg) use (&$index, $serviceIds, $locator, &$next) : PersonalChatMessage {
//            if (!isset($serviceIds[$index])) {
//                return $msg;
//            }
//            $serviceId = $serviceIds[$index++];
//            $processor = $locator->get($serviceId);
//            return $processor->process($msg, $next);
//        };
//
//        return $next($message);
    }
}
