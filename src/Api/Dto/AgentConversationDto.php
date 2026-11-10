<?php

namespace Wexample\SymfonyAiConversation\Api\Dto;

use Wexample\SymfonyConversation\Api\Dto\ConversationDto;
use Wexample\SymfonyHelpers\Entity\AbstractEntity;

/**
 * What a conversation with an agent says beyond what every conversation does:
 * which agent, the model it was pinned to, how far it got.
 */
class AgentConversationDto extends ConversationDto
{
    /** Qualified name, which is what a package agent has instead of a record. */
    public string $agentName;

    public ?AgentDto $agent;

    public ?ModelDto $model;

    public int $turnCount;

    /**
     * @param \Wexample\SymfonyAiConversation\Entity\AgentConversation $entity
     */
    public static function fromConversation(AbstractEntity $entity, array $participants): static
    {
        $dto = parent::fromConversation($entity, $participants);

        $dto->agentName = $entity->getAgentName();
        $dto->agent = $entity->getAgent() ? AgentDto::fromEntity($entity->getAgent()) : null;
        $dto->model = $entity->getModel() ? ModelDto::fromEntity($entity->getModel()) : null;
        $dto->turnCount = $entity->getTurnCount();

        return $dto;
    }
}
