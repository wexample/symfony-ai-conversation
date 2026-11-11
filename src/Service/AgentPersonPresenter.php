<?php

namespace Wexample\SymfonyAiConversation\Service;

use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use Symfony\Component\DependencyInjection\Attribute\AutowireDecorated;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;
use Wexample\SymfonyAiConversation\Entity\AgentConversationParticipant;
use Wexample\SymfonyAiConversation\Interface\AgentIdentityProviderInterface;
use Wexample\SymfonyConversation\Entity\ConversationParticipant;
use Wexample\SymfonyConversation\Interface\ConversationPersonPresenterInterface;

/**
 * An agent among the people of a conversation, read as its runner says it is
 * (AgentIdentityProviderInterface) — its name, its face —, a robot's face when
 * it says none. Anyone else, as the application presents them.
 */
#[AsDecorator(ConversationPersonPresenterInterface::class)]
final readonly class AgentPersonPresenter implements ConversationPersonPresenterInterface
{
    /** The face of an agent that has none of its own. */
    final public const string DEFAULT_EMOJI = '🤖';

    public function __construct(
        #[AutowireDecorated]
        private ConversationPersonPresenterInterface $inner,
        /** @var iterable<AgentIdentityProviderInterface> */
        #[AutowireIterator(AgentIdentityProviderInterface::TAG)]
        private iterable $identities,
    ) {
    }

    public function present(ConversationParticipant $participant): array
    {
        $person = $this->inner->present($participant);

        if (! $participant instanceof AgentConversationParticipant) {
            return $person;
        }

        $identity = $this->identify($participant->getAgentName()) ?? [];

        return array_merge($person, [
            'label' => $identity['label'] ?? $person['label'],
            'src' => $identity['src'] ?? $person['src'],
            'emoji' => $identity['emoji'] ?? $person['emoji'] ?? (($identity['src'] ?? $person['src']) ? null : self::DEFAULT_EMOJI),
        ]);
    }

    /** @return array{label: string, src?: ?string, emoji?: ?string}|null */
    public function identify(string $agentName): ?array
    {
        foreach ($this->identities as $provider) {
            if ($identity = $provider->identify($agentName)) {
                return $identity;
            }
        }

        return null;
    }
}
