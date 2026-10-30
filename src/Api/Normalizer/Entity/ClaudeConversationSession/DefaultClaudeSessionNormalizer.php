<?php

namespace Wexample\SymfonyAiConversation\Api\Normalizer\Entity\ClaudeConversationSession;

use ArrayObject;
use Wexample\SymfonyAiConversation\Api\Dto\ClaudeSessionDto;
use Wexample\SymfonyAiConversation\Api\Normalizer\Entity\ConversationSession\DefaultSessionNormalizer;
use Wexample\SymfonyAiConversation\Entity\ClaudeConversationSession;
use Wexample\SymfonyAiConversation\Entity\Traits\Manipulator\ClaudeSessionEntityManipulatorTrait;
use Wexample\SymfonyHelpers\Entity\AbstractEntity;
use Wexample\SymfonyHelpers\Interface\NormalizableDataInterface;

/**
 * A Claude session under the session envelope: the kind's own words added to
 * every session's, and the engine named in the row.
 */
class DefaultClaudeSessionNormalizer extends DefaultSessionNormalizer
{
    use ClaudeSessionEntityManipulatorTrait;

    public function normalizeEntity(
        ClaudeConversationSession|AbstractEntity $entity,
        ?string $format = null,
        array $context = []
    ): array|string|int|float|bool|ArrayObject|NormalizableDataInterface|null {
        return ClaudeSessionDto::fromEntity($entity);
    }
}
