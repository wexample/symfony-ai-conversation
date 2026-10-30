<?php

namespace Wexample\SymfonyAiConversation\Service;

use Wexample\SymfonyAiConversation\Entity\ConversationModel;

/**
 * Translates a model between a plain array and its record, both ways.
 *
 * Where that array is read from is not known here: whoever holds the list —
 * a file, a payload, a fixture — passes the same thing.
 */
final readonly class ModelHydrator
{
    public const KEY_API_ID = 'api_id';
    public const KEY_DESCRIPTION = 'description';
    public const KEY_ID = 'id';
    public const KEY_MAKER = 'maker';
    public const KEY_NAME = 'name';
    public const KEY_POSITION = 'position';

    /**
     * @param array<string, mixed> $values
     */
    public function hydrate(
        ConversationModel $model,
        array $values
    ): ConversationModel {
        return $model
            ->setName($values[self::KEY_NAME])
            ->setMaker($values[self::KEY_MAKER])
            ->setApiId($values[self::KEY_API_ID])
            ->setDescription($values[self::KEY_DESCRIPTION] ?? null)
            ->setPosition($values[self::KEY_POSITION]);
    }

    /**
     * @return array<string, mixed>
     */
    public function dump(ConversationModel $model): array
    {
        return [
            self::KEY_ID => $model->getId()->toRfc4122(),
            self::KEY_NAME => $model->getName(),
            self::KEY_MAKER => $model->getMaker(),
            self::KEY_API_ID => $model->getApiId(),
            self::KEY_DESCRIPTION => $model->getDescription(),
            self::KEY_POSITION => $model->getPosition(),
        ];
    }
}
