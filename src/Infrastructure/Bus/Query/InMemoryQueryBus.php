<?php

declare(strict_types=1);

namespace App\Infrastructure\Bus\Query;

use App\Domain\Bus\Query\Query;
use App\Domain\Bus\Query\QueryBus;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use App\Infrastructure\Bus\HandlerBuilder;
use InvalidArgumentException;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Exception;

final class InMemoryQueryBus implements QueryBus
{
    private MessageBus $bus;

    public function __construct(iterable $queryHandlers)
    {
        $this->bus = new MessageBus([
            new HandleMessageMiddleware(
                new HandlersLocator(
                    HandlerBuilder::fromCallables($queryHandlers),
                ),
            ),
        ]);
    }

    public function ask(Query $query)
    {
        try {
            /** @var HandledStamp $stamp */
            $stamp = $this->bus->dispatch($query)->last(HandledStamp::class);
            return $stamp->getResult();
        } catch (Exception $exception) {
            print_r($exception->getMessage());
            throw new InvalidArgumentException(sprintf('The query has not a valid handler: %s', $query::class));
        }
    }
}
