<?php

declare(strict_types=1);

namespace App\Infrastructure\Bus\Command;

use App\Domain\Bus\Command\CommandBus;
use App\Domain\Bus\Command\Command;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use App\Infrastructure\Bus\HandlerBuilder;
use Exception;
use InvalidArgumentException;

final class InMemoryCommandBus implements CommandBus
{
    private MessageBus $bus;

    public function __construct(
        iterable $commandHandlers
    ) {
        $this->bus = new MessageBus([
            new HandleMessageMiddleware(
                new HandlersLocator(
                    HandlerBuilder::fromCallables($commandHandlers),
                ),
            ),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function dispatch(Command $command): void
    {
        try {
            $this->bus->dispatch($command);
        } catch (Exception $e) {
            throw new InvalidArgumentException(sprintf('The command has not a valid handler: %s', $command::class));
        }
    }
}
