<?php

namespace Wexample\SymfonyAiConversation\Api\Normalizer\Entity\ConversationModel;

use ArrayObject;
use Wexample\SymfonyAiConversation\Api\Dto\ModelDto;
use Wexample\SymfonyAiConversation\Entity\ConversationModel;
use Wexample\SymfonyAiConversation\Entity\Traits\Manipulator\ModelEntityManipulatorTrait;
use Wexample\SymfonyHelpers\Entity\AbstractEntity;
use Wexample\SymfonyHelpers\Interface\NormalizableDataInterface;
use Wexample\SymfonyHelpers\Normalizer\AbstractEntityNormalizer;

class DefaultModelNormalizer extends AbstractEntityNormalizer
{
    use ModelEntityManipulatorTrait;

    public function normalizeEntity(
        ConversationModel|AbstractEntity $entity,
        ?string $format = null,
        array $context = []
    ): array|string|int|float|bool|ArrayObject|NormalizableDataInterface|null {
        return ModelDto::fromEntity($entity);
    }
}
