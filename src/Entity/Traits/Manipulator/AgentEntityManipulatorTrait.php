<?php

namespace Wexample\SymfonyAiConversation\Entity\Traits\Manipulator;

use Wexample\SymfonyAiConversation\Entity\ConversationAgent;
use Wexample\SymfonyHelpers\Entity\Traits\Manipulator\EntityManipulatorTrait;

trait AgentEntityManipulatorTrait
{
    use EntityManipulatorTrait;

    public static function getEntityClassName(): string
    {
        return ConversationAgent::class;
    }
}
