<?php

namespace Wexample\SymfonyAiConversation\Service;

use Wexample\SymfonyAiConversation\Entity\ConversationAgent;
use Wexample\SymfonyAiConversation\Entity\ConversationModel;
use Wexample\SymfonyAiConversation\Repository\ModelRepository;

/**
 * Translates an agent between a plain array and its record, both ways.
 *
 * Where that array is read from and written to is not known here: a caller
 * holding a file, a payload or a fixture passes the same thing.
 */
final readonly class AgentHydrator
{
    public const KEY_DESCRIPTION = 'description';
    public const KEY_MODEL = 'model';
    public const KEY_NAME = 'name';
    public const KEY_QUALIFIED_NAME = 'qualified_name';

    public function __construct(
        private ModelRepository $modelRepository,
    ) {
    }

    /**
     * @param array<string, mixed> $values
     */
    public function hydrate(
        ConversationAgent $agent,
        array $values
    ): ConversationAgent {
        return $agent
            ->setName($values[self::KEY_NAME] ?? null)
            ->setDescription($values[self::KEY_DESCRIPTION] ?? null)
            ->setQualifiedName($values[self::KEY_QUALIFIED_NAME] ?? null)
            ->setModel($this->model($values[self::KEY_MODEL] ?? null));
    }

    /**
     * @return array<string, mixed>
     */
    public function dump(ConversationAgent $agent): array
    {
        return [
            self::KEY_NAME => $agent->getName(),
            self::KEY_DESCRIPTION => $agent->getDescription(),
            self::KEY_QUALIFIED_NAME => $agent->getQualifiedName(),
            self::KEY_MODEL => $agent->getModel()?->getName(),
        ];
    }

    /**
     * The model that name points at, or null when the catalogue holds no such
     * model: an agent naming one that is gone is still an agent.
     */
    private function model(?string $name): ?ConversationModel
    {
        return $name
            ? $this->modelRepository->findOneBy([ModelHydrator::KEY_NAME => $name])
            : null;
    }
}
