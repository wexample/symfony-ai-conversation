<?php

namespace Wexample\SymfonyAiConversation\Api\Normalizer\Entity\ConversationSession;

use ArrayObject;
use Wexample\SymfonyAiConversation\Api\Dto\SessionDto;
use Wexample\SymfonyAiConversation\Entity\ConversationSession;
use Wexample\SymfonyAiConversation\Entity\Traits\Manipulator\SessionEntityManipulatorTrait;
use Wexample\SymfonyHelpers\Entity\AbstractEntity;
use Wexample\SymfonyHelpers\Interface\NormalizableDataInterface;
use Wexample\SymfonyHelpers\Normalizer\AbstractEntityNormalizer;

class DefaultSessionNormalizer extends AbstractEntityNormalizer
{
    use SessionEntityManipulatorTrait;

    public function normalizeEntity(
        ConversationSession|AbstractEntity $entity,
        ?string $format = null,
        array $context = []
    ): array|string|int|float|bool|ArrayObject|NormalizableDataInterface|null {
        return SessionDto::fromEntity($entity);
    }
}
