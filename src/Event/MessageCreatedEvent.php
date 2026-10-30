<?php

namespace Wexample\SymfonyAiConversation\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Wexample\SymfonyAiConversation\Entity\ConversationMessage;

/**
 * Said once a turn has been written, for whoever knows how to answer it.
 *
 * The package writes the line and stops there: answering means reaching an
 * engine, which is the application's business and not this one's. An application
 * that has one listens; one that has none keeps a chat that only remembers.
 */
class MessageCreatedEvent extends Event
{
    public function __construct(
        public readonly ConversationMessage $message,
    ) {
    }
}
