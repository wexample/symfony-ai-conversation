<?php

namespace Wexample\SymfonyAiConversation\Service;

use Doctrine\ORM\EntityManagerInterface;
use Wexample\SymfonyAiConversation\Entity\AgentConversation;
use Wexample\SymfonyAiConversation\Entity\AgentConversationParticipant;
use Wexample\SymfonyConversation\Entity\Conversation;
use Wexample\SymfonyConversation\Entity\ConversationParticipant;
use Wexample\SymfonyConversation\Entity\UserConversationParticipant;
use Wexample\SymfonyHelpers\Entity\Interfaces\UserEntityInterface;

/**
 * Who speaks in a conversation with an agent: the agent, as a participant of
 * its own, and the people talking to it — what an engine's line, said by one
 * or the other (`speaker`), is written by.
 */
final readonly class AgentConversationService
{
    /** A line the agent said. */
    final public const string SPEAKER_AGENT = 'agent';

    /** A line a person said to it. */
    final public const string SPEAKER_USER = 'user';

    /** The chat a conversation with an agent is drawn by: the people's, running the agent's calls besides. */
    final public const string CHAT_COMPONENT = '@WexampleSymfonyAiConversationBundle/vue/collection/chat/message-chat';

    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    /** The agent as it takes part, given its part the first time it is asked. */
    public function agentParticipant(AgentConversation $conversation): AgentConversationParticipant
    {
        if ($participant = $conversation->getAgentParticipant()) {
            return $participant;
        }

        $participant = new AgentConversationParticipant($conversation, $conversation->getAgentName(), $conversation->getAgent());
        $this->entityManager->persist($participant);

        return $participant;
    }

    /**
     * Who wrote a line said by `speaker`: the agent, the person holding the
     * conversation — the first who joined —, nobody for the conversation's own.
     */
    public function authorFor(AgentConversation $conversation, ?string $speaker): ?ConversationParticipant
    {
        return match ($speaker) {
            self::SPEAKER_AGENT => $this->agentParticipant($conversation),
            self::SPEAKER_USER => $this->holderOf($conversation),
            default => null,
        };
    }

    /** What said a line, by its author: the opposite of authorFor(). */
    public static function speakerOf(?ConversationParticipant $author): ?string
    {
        return match (true) {
            $author instanceof AgentConversationParticipant => self::SPEAKER_AGENT,
            $author instanceof UserConversationParticipant => self::SPEAKER_USER,
            default => null,
        };
    }

    /** The person holding the conversation, whose account the agent's tools answer for. */
    public function holderOf(Conversation $conversation): ?UserConversationParticipant
    {
        $holder = null;

        foreach ($conversation->getParticipants() as $participant) {
            if ($participant instanceof UserConversationParticipant
                && (! $holder || $participant->getDateJoined() < $holder->getDateJoined())) {
                $holder = $participant;
            }
        }

        return $holder;
    }

    public function holderUserOf(Conversation $conversation): ?UserEntityInterface
    {
        return $this->holderOf($conversation)?->getUser();
    }
}
