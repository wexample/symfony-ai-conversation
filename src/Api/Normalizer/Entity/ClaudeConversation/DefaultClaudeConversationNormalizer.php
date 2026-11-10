<?php

namespace Wexample\SymfonyAiConversation\Api\Normalizer\Entity\ClaudeConversation;

use Wexample\SymfonyAiConversation\Api\Dto\ClaudeConversationDto;
use Wexample\SymfonyAiConversation\Api\Normalizer\Entity\AgentConversation\DefaultAgentConversationNormalizer;
use Wexample\SymfonyAiConversation\Entity\Traits\Manipulator\ClaudeConversationEntityManipulatorTrait;
use Wexample\SymfonyConversation\Api\Dto\ConversationDto;
use Wexample\SymfonyConversation\Entity\Conversation;

class DefaultClaudeConversationNormalizer extends DefaultAgentConversationNormalizer
{
    use ClaudeConversationEntityManipulatorTrait;

    protected function createDto(Conversation $conversation, array $participants): ConversationDto
    {
        return ClaudeConversationDto::fromConversation($conversation, $participants);
    }
}
