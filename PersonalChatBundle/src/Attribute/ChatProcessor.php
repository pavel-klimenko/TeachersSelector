<?php

declare(strict_types=1);

namespace PersonalChatBundle\Attribute;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class ChatProcessor
{
    public function __construct(
        public int $priority = 0,
        public string $channel = 'default'
    ) {}
}