<?php

namespace Wexample\SymfonyAiConversation\Interface;

/**
 * Who an agent is to the people talking with it — its name, its face —, said
 * by the package or the application that runs it: an agent known only by its
 * qualified name (`syrtis:<scenario>`) is otherwise shown as that name. Tagged
 * by being one (the bundle's extension); the first to know the agent answers.
 */
interface AgentIdentityProviderInterface
{
    public const string TAG = 'wexample_symfony_ai_conversation.agent_identity_provider';

    /**
     * The agent named so, or null when it is not one of this provider's.
     *
     * @return array{label: string, src?: ?string, emoji?: ?string}|null
     */
    public function identify(string $agentName): ?array;
}
