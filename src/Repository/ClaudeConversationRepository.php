<?php

namespace Wexample\SymfonyAiConversation\Repository;

use Symfony\Component\Uid\Uuid;
use Wexample\SymfonyAiConversation\Entity\ClaudeConversation;
use Wexample\SymfonyAiConversation\Entity\Traits\Manipulator\ClaudeConversationEntityManipulatorTrait;

/**
 * @method ClaudeConversation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClaudeConversation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClaudeConversation[]    findAll()
 */
class ClaudeConversationRepository extends AgentConversationRepository
{
    use ClaudeConversationEntityManipulatorTrait;

    /**
     * A conversation read from the record at that path: the record says what
     * it is, whoever wrote it hydrates the row from the file.
     */
    public function createNewClaudeConversation(string $path): ClaudeConversation
    {
        return new ClaudeConversation($path);
    }

    /**
     * The conversations held inside one app — the record they were read from
     * lies inside it —, the one last spoken to first.
     *
     * @return ClaudeConversation[]
     */
    public function findByPathPrefix(string $prefix): array
    {
        return $this->queryLastSpokenFirst()
            ->where($this->queryField('path').' LIKE :prefix')
            ->setParameter('prefix', addcslashes($prefix, '%_\\').'/%')
            ->getQuery()
            ->getResult();
    }

    /**
     * One conversation, on condition that it was held inside that directory:
     * another app's answering there would be shown under a name not holding it.
     */
    public function findByPathPrefixAndId(string $prefix, Uuid $id): ?ClaudeConversation
    {
        foreach ($this->findByPathPrefix($prefix) as $conversation) {
            if ($conversation->getId()->equals($id)) {
                return $conversation;
            }
        }

        return null;
    }
}
