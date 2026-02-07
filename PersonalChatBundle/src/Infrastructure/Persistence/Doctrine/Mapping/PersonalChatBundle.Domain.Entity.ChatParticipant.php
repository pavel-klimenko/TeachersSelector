<?php

use Doctrine\ORM\Mapping\ClassMetadata;
use PersonalChatBundle\Domain\Entity\ChatUserInterface;

/** @var ClassMetadata $metadata */
$metadata->setTableName('personal_chat_participant');
$metadata->setCustomRepositoryClass(\PersonalChatBundle\Infrastructure\Persistence\ChatParticipantRepository::class);

$metadata->mapField([
    'id'         => true,
    'fieldName'  => 'id',
    'type'       => 'integer',
]);

$metadata->mapField([
    'id'         => false,
    'fieldName'  => 'name',
    'type'       => 'string',
]);

$metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_AUTO);

$metadata->mapOneToOne([
    'fieldName' => 'user',
    'targetEntity' => ChatUserInterface::class,
    'joinColumns' => [
        [
            'name' => 'user_id',
            'referencedColumnName' => 'id',
            'nullable' => false,
            'unique' => true,
            'onDelete' => 'CASCADE',
        ],
    ],
]);
