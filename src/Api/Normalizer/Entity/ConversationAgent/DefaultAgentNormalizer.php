<?php

namespace Wexample\SymfonyAiConversation\Api\Normalizer\Entity\ConversationAgent;

use ArrayObject;
use Wexample\SymfonyAiConversation\Api\Dto\AgentDto;
use Wexample\SymfonyAiConversation\Entity\ConversationAgent;
use Wexample\SymfonyAiConversation\Entity\Traits\Manipulator\AgentEntityManipulatorTrait;
use Wexample\SymfonyHelpers\Entity\AbstractEntity;
use Wexample\SymfonyHelpers\Interface\NormalizableDataInterface;
use Wexample\SymfonyHelpers\Normalizer\AbstractEntityNormalizer;

class DefaultAgentNormalizer extends AbstractEntityNormalizer
{
    use AgentEntityManipulatorTrait;

    public function normalizeEntity(
        ConversationAgent|AbstractEntity $entity,
        ?string $format = null,
        array $context = []
    ): array|string|int|float|bool|ArrayObject|NormalizableDataInterface|null {
        return AgentDto::fromEntity($entity);
    }
}
