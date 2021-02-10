<?php

declare(strict_types=1);

namespace App\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\EventDispatcher\EventDispatcher;

class EventCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $dispatcherDefinition = $container->findDefinition(EventDispatcher::class);

        $subscribersIds = $container->findTaggedServiceIds('app.event_subscriber');

        foreach ($subscribersIds as $id => $tagData) {
            $dispatcherDefinition->addMethodCall(
                'addSubscriber',
                [
                    new Reference($id)
                ]
            );
        }

        $listenersIds = $container->findTaggedServiceIds('app.event_listener');

        foreach ($listenersIds as $id => $tagData) {
            foreach ($tagData as $data) {
                $dispatcherDefinition->addMethodCall(
                    'addListener',
                    [
                        $data['event'],
                        [new Reference($id), $data['method']],
                        $data['priority']
                    ]
                );
            }
        }
    }
}
