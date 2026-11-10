<?php

namespace Wexample\SymfonyAiConversation\Api\Normalizer\Entity\AgentConversation;

use Wexample\SymfonyAiConversation\Api\Dto\AgentConversationDto;
use Wexample\SymfonyAiConversation\Entity\Traits\Manipulator\AgentConversationEntityManipulatorTrait;
use Wexample\SymfonyConversation\Api\Dto\ConversationDto;
use Wexample\SymfonyConversation\Api\Normalizer\Entity\Conversation\DefaultConversationNormalizer;
use Wexample\SymfonyConversation\Entity\Conversation;

class DefaultAgentConversationNormalizer extends DefaultConversationNormalizer
{
    use AgentConversationEntityManipulatorTrait;

    protected function createDto(Conversation $conversation, array $participants): ConversationDto
    {
        return AgentConversationDto::fromConversation($conversation, $participants);
    }
}
