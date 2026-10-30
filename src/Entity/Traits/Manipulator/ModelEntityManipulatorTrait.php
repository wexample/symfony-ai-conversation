<?php

namespace Wexample\SymfonyAiConversation\Entity\Traits\Manipulator;

use Wexample\SymfonyAiConversation\Entity\ConversationModel;
use Wexample\SymfonyHelpers\Entity\Traits\Manipulator\EntityManipulatorTrait;

trait ModelEntityManipulatorTrait
{
    use EntityManipulatorTrait;

    public static function getEntityClassName(): string
    {
        return ConversationModel::class;
    }
}
