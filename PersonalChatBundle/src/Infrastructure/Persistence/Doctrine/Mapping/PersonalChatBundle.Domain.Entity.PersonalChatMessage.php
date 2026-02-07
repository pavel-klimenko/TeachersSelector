<?php

use Doctrine\ORM\Mapping\ClassMetadata;
use PersonalChatBundle\Domain\Entity\PersonalChat;
use PersonalChatBundle\Domain\Entity\ChatParticipant;

/** @var ClassMetadata $metadata */

$metadata->setTableName('personal_chat_messages');

// Primary Key
$metadata->mapField([
    'id'         => true,
    'fieldName'  => 'id',
    'type'       => 'integer',
]);
$metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_AUTO);

// Текст сообщения
$metadata->mapField([
    'fieldName' => 'message',
    'type'      => 'text', // Используем text для длинных сообщений
]);

// Даты
$metadata->mapField([
    'fieldName' => 'createdAt',
    'type'      => 'datetime_immutable',
]);

$metadata->mapField([
    'fieldName' => 'updatedAt',
    'type'      => 'datetime_immutable',
]);

// Связь с чатом (Многие сообщения к Одному чату)
$metadata->mapManyToOne([
    'fieldName'    => 'chat',
    'targetEntity' => PersonalChat::class,
    'inversedBy'   => 'messages', // Ссылка на свойство в PersonalChat
    'joinColumns'  => [
        [
            'name'                 => 'chat_id',
            'referencedColumnName' => 'id',
            'nullable'             => false,
            'onDelete'             => 'CASCADE',
        ],
    ],
]);

// Связь с автором (Многие сообщения к Одному участнику)
$metadata->mapManyToOne([
    'fieldName'    => 'author',
    'targetEntity' => ChatParticipant::class,
    'joinColumns'  => [
        [
            'name'                 => 'author_id',
            'referencedColumnName' => 'id',
            'nullable'             => false,
        ],
    ],
]);
