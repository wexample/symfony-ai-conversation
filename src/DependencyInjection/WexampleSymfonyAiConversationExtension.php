<?php

namespace Wexample\SymfonyAiConversation\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Wexample\SymfonyAiConversation\Interface\AgentIdentityProviderInterface;
use Wexample\SymfonyHelpers\DependencyInjection\AbstractWexampleSymfonyExtension;

class WexampleSymfonyAiConversationExtension extends AbstractWexampleSymfonyExtension
{
    public function load(
        array $configs,
        ContainerBuilder $container
    ): void {
        $container->registerForAutoconfiguration(AgentIdentityProviderInterface::class)
            ->addTag(AgentIdentityProviderInterface::TAG);

        $this->loadConfig(
            __DIR__,
            $container
        );
    }
}
