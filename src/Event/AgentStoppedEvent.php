<?php

namespace Wexample\SymfonyAiConversation\Event;

use Symfony\Contracts\EventDispatcher\Event;
use Wexample\SymfonyConversation\Entity\Conversation;

/**
 * Said once the person stopped the agent of a conversation, for whatever
 * drives it: an engine running a turn for it cuts it short. The package
 * says so and stops there.
 */
class AgentStoppedEvent extends Event
{
    public function __construct(
        public readonly Conversation $conversation,
    ) {
    }
}
