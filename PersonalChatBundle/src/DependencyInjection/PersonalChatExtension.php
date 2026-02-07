<?php

namespace PersonalChatBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Argument\TaggedIteratorArgument;
use PersonalChatBundle\Infrastructure\Bus\Command\InMemoryCommandBus;


class PersonalChatExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../../Resources/config'));
        $loader->load('services.yaml');

        $container->register(InMemoryCommandBus::class)
            ->setArguments([
                new TaggedIteratorArgument('personal_chat.command_handler')
            ])
            ->setPublic(true);

        // Автоматически помечаем все классы, реализующие CommandHandler, нужным тегом
        $container->registerForAutoconfiguration(\PersonalChatBundle\Domain\Bus\Command\CommandHandler::class)
            ->addTag('personal_chat.command_handler');
    }

    public function prepend(ContainerBuilder $container): void
    {

        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);


        $container->prependExtensionConfig('doctrine', [
            'orm' => [
                'mappings' => [
                    'PersonalChatBundle' => [
                        'is_bundle' => false,
                        'type' => 'php',
                        'dir' => __DIR__ . '/../Infrastructure/Persistence/Doctrine/Mapping',
                        'prefix' => 'PersonalChatBundle\Domain\Entity',
                        'alias' => 'PersonalChat',
                    ],
                ],
            ],
        ]);

        $container->prependExtensionConfig('framework', [
            'messenger' => [
                'transports' => [
                    'personalChats' => [
                        'dsn' => '%env(MESSENGER_TRANSPORT_DSN)%',
                        'options' => [
                            'queues' => [
                                'personal_chats' => [
                                    'binding_keys' => ['personal_chats'],
                                ],
                            ],
                            // 'exchange' => [
                            //     'name' => 'personal_chats_exchange',
                            //     'type' => 'direct',
                            // ],
                        ],
                    ],
                ],
                'routing' => [
                    'PersonalChatBundle\Application\Chats\PersonalChat\Symfony\Message\SendChatMessage' => 'personalChats',
                ],
            ],
        ]);

        $container->prependExtensionConfig('twig', [
            'paths' => [
                __DIR__ . '/../../templates' => 'PersonalChat'
        ]]);
    }

    public function getAlias(): string
    {
        return 'personal_chat';
    }
}
