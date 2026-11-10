<?php

namespace Wexample\SymfonyAiConversation\Entity\Traits\Manipulator;

use Wexample\SymfonyAiConversation\Entity\ClaudeConversation;
use Wexample\SymfonyHelpers\Entity\Traits\Manipulator\EntityManipulatorTrait;

trait ClaudeConversationEntityManipulatorTrait
{
    use EntityManipulatorTrait;

    public static function getEntityClassName(): string
    {
        return ClaudeConversation::class;
    }
}
