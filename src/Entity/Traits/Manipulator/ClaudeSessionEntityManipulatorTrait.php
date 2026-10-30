<?php

namespace Wexample\SymfonyAiConversation\Entity\Traits\Manipulator;

use Wexample\SymfonyAiConversation\Entity\ClaudeConversationSession;
use Wexample\SymfonyHelpers\Entity\Traits\Manipulator\EntityManipulatorTrait;

trait ClaudeSessionEntityManipulatorTrait
{
    use EntityManipulatorTrait;

    public static function getEntityClassName(): string
    {
        return ClaudeConversationSession::class;
    }
}
