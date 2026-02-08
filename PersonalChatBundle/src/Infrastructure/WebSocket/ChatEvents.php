<?php

namespace PersonalChatBundle\Infrastructure\WebSocket;

enum ChatEvents: string
{
    case LOAD_CHAT = 'load_chat';
    case ADD_MESSAGE = 'add_message';
}