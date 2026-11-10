<?php

namespace Wexample\SymfonyAiConversation\Service;

use DateTime;
use Wexample\SymfonyAiConversation\Entity\AgentConversation;
use Wexample\SymfonyConversation\Entity\ConversationMessage;

/**
 * Translates a line of a conversation with an agent between a plain array and
 * its record, both ways.
 *
 * The array is already neutral: turning a provider's own transcript into these
 * keys is the reader's job, the only place a provider is named. Who said the
 * line (`speaker`: the agent, the person talking to it, none) is written as
 * its author.
 */
final readonly class MessageHydrator
{
    public const KEY_BODY = 'body';
    public const KEY_DATE_CREATED = 'date_created';
    public const KEY_PROVIDER_MESSAGE_IDENTIFIER = 'provider_message_identifier';
    public const KEY_SPEAKER = 'speaker';
    public const KEY_TOKENS = 'tokens';
    public const KEY_TYPE = 'type';

    public function __construct(
        private AgentConversationService $agentConversations,
    ) {
    }

    /**
     * @param array<string, mixed> $values
     */
    public function hydrate(
        ConversationMessage $message,
        array $values
    ): ConversationMessage {
        if (isset($values[self::KEY_TYPE])) {
            $message->setType($values[self::KEY_TYPE]);
        }

        if (isset($values[self::KEY_DATE_CREATED])) {
            $message->setDateCreated(new DateTime($values[self::KEY_DATE_CREATED]));
        }

        $conversation = $message->getConversation();

        if ($conversation instanceof AgentConversation && array_key_exists(self::KEY_SPEAKER, $values)) {
            $message->setAuthor($this->agentConversations->authorFor($conversation, $values[self::KEY_SPEAKER]));
        }

        return $message
            ->setBody($values[self::KEY_BODY] ?? null)
            ->setTokens(
                isset($values[self::KEY_TOKENS])
                    ? (int) $values[self::KEY_TOKENS]
                    : null
            )
            ->setProviderMessageIdentifier(
                $values[self::KEY_PROVIDER_MESSAGE_IDENTIFIER] ?? null
            );
    }

    /**
     * @return array<string, mixed>
     */
    public function dump(ConversationMessage $message): array
    {
        return [
            self::KEY_TYPE => $message->getType(),
            self::KEY_SPEAKER => AgentConversationService::speakerOf($message->getAuthor()),
            self::KEY_BODY => $message->getBody(),
            self::KEY_DATE_CREATED => $message->getDateCreated()?->format(DATE_ATOM),
            self::KEY_TOKENS => $message->getTokens(),
            self::KEY_PROVIDER_MESSAGE_IDENTIFIER => $message->getProviderMessageIdentifier(),
        ];
    }
}
