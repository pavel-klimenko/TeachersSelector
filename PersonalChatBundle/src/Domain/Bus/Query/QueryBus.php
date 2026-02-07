<?php

declare(strict_types=1);

namespace PersonalChatBundle\Domain\Bus\Query;

interface QueryBus
{
    public function ask(Query $query);
}