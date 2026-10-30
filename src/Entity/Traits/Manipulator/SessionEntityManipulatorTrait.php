<?php

namespace Wexample\SymfonyAiConversation\Entity\Traits\Manipulator;

use Wexample\SymfonyAiConversation\Entity\ConversationSession;
use Wexample\SymfonyHelpers\Entity\Traits\Manipulator\EntityManipulatorTrait;

trait SessionEntityManipulatorTrait
{
    use EntityManipulatorTrait;

    public static function getEntityClassName(): string
    {
        return ConversationSession::class;
    }
}
