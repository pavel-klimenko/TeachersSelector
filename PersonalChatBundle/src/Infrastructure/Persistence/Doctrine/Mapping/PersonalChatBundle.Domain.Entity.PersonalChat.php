<?php

use Doctrine\ORM\Mapping\ClassMetadata;
use PersonalChatBundle\Domain\Entity\ChatParticipant;
use PersonalChatBundle\Domain\Entity\PersonalChatMessage;

/** @var ClassMetadata $metadata */

$metadata->setTableName('personal_chats');
$metadata->setCustomRepositoryClass(\PersonalChatBundle\Infrastructure\Persistence\PersonalChatRepository::class);

// Primary Key
$metadata->mapField([
    'id'         => true,
    'fieldName'  => 'id',
    'type'       => 'integer',
]);
$metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_AUTO);

// Связь с первым участником (Many-To-One)
$metadata->mapManyToOne([
    'fieldName'    => 'chatParticipantOne',
    'targetEntity' => ChatParticipant::class,
    'joinColumns'  => [
        [
            'name'                 => 'participant_one_id', // Имя колонки в БД
            'referencedColumnName' => 'id',
            'nullable'             => false,
            'onDelete'             => 'CASCADE',
        ],
    ],
]);

// Связь со вторым участником (Many-To-One)
$metadata->mapManyToOne([
    'fieldName'    => 'chatParticipantTwo',
    'targetEntity' => ChatParticipant::class,
    'joinColumns'  => [
        [
            'name'                 => 'participant_two_id', // Имя колонки в БД
            'referencedColumnName' => 'id',
            'nullable'             => false,
            'onDelete'             => 'CASCADE',
        ],
    ],
]);

// Связь с сообщениями (One-To-Many)
// Сообщения являются частью агрегата, поэтому ставим orphanRemoval
$metadata->mapOneToMany([
    'fieldName'    => 'messages',
    'targetEntity' => PersonalChatMessage::class,
    'mappedBy'     => 'chat',
    'cascade'      => ['persist', 'remove'],
    'orphanRemoval' => true,
]);


