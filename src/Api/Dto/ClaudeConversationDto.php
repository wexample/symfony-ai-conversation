<?php

namespace Wexample\SymfonyAiConversation\Api\Dto;

use Wexample\SymfonyHelpers\Entity\AbstractEntity;

/**
 * What a Claude conversation says beyond an agent's: where its record is, and
 * the thread back to its transcript.
 */
class ClaudeConversationDto extends AgentConversationDto
{
    public string $path;

    public ?string $sdkId;

    /**
     * @param \Wexample\SymfonyAiConversation\Entity\ClaudeConversation $entity
     */
    public static function fromConversation(AbstractEntity $entity, array $participants): static
    {
        $dto = parent::fromConversation($entity, $participants);

        $dto->path = $entity->getPath();
        $dto->sdkId = $entity->getSdkId();

        return $dto;
    }
}
