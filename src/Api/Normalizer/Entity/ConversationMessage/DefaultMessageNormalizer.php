<?php

namespace Wexample\SymfonyAiConversation\Api\Normalizer\Entity\ConversationMessage;

use ArrayObject;
use Wexample\SymfonyAiConversation\Api\Dto\MessageDto;
use Wexample\SymfonyAiConversation\Entity\ConversationMessage;
use Wexample\SymfonyAiConversation\Entity\Traits\Manipulator\MessageEntityManipulatorTrait;
use Wexample\SymfonyHelpers\Entity\AbstractEntity;
use Wexample\SymfonyHelpers\Interface\NormalizableDataInterface;
use Wexample\SymfonyHelpers\Normalizer\AbstractEntityNormalizer;

class DefaultMessageNormalizer extends AbstractEntityNormalizer
{
    use MessageEntityManipulatorTrait;

    public function normalizeEntity(
        ConversationMessage|AbstractEntity $entity,
        ?string $format = null,
        array $context = []
    ): array|string|int|float|bool|ArrayObject|NormalizableDataInterface|null {
        return MessageDto::fromEntity($entity);
    }
}
