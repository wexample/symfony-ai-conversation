<?php

namespace Wexample\SymfonyAiConversation\Api\Normalizer\Entity\Agent;

use ArrayObject;
use Wexample\SymfonyAiConversation\Api\Dto\AgentDto;
use Wexample\SymfonyAiConversation\Entity\Agent;
use Wexample\SymfonyAiConversation\Entity\Traits\Manipulator\AgentEntityManipulatorTrait;
use Wexample\SymfonyHelpers\Entity\AbstractEntity;
use Wexample\SymfonyHelpers\Interface\NormalizableDataInterface;
use Wexample\SymfonyHelpers\Normalizer\AbstractEntityNormalizer;

class DefaultAgentNormalizer extends AbstractEntityNormalizer
{
    use AgentEntityManipulatorTrait;

    public function normalizeEntity(
        Agent|AbstractEntity $entity,
        ?string $format = null,
        array $context = []
    ): array|string|int|float|bool|ArrayObject|NormalizableDataInterface|null {
        return AgentDto::fromEntity($entity);
    }
}
