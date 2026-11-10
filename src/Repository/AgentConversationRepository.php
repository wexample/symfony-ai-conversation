<?php

namespace Wexample\SymfonyAiConversation\Repository;

use Doctrine\ORM\QueryBuilder;
use Wexample\SymfonyAiConversation\Entity\AgentConversation;
use Wexample\SymfonyAiConversation\Entity\ConversationAgent;
use Wexample\SymfonyAiConversation\Entity\Traits\Manipulator\AgentConversationEntityManipulatorTrait;
use Wexample\SymfonyHelpers\Repository\AbstractRepository;

/**
 * The conversations of every engine with an agent; what an engine alone can
 * answer is asked of its own repository, built on this one.
 *
 * @method AgentConversation|null find($id, $lockMode = null, $lockVersion = null)
 * @method AgentConversation|null findOneBy(array $criteria, array $orderBy = null)
 */
class AgentConversationRepository extends AbstractRepository
{
    use AgentConversationEntityManipulatorTrait;

    /** @return AgentConversation[] */
    public function findByAgent(ConversationAgent $agent): array
    {
        return $this->queryByAgent($agent)->getQuery()->getResult();
    }

    /** The conversations one agent held, the one last spoken to first. */
    public function queryByAgent(ConversationAgent $agent): QueryBuilder
    {
        return $this->queryLastSpokenFirst()
            ->where($this->queryField('agent').' = :agent')
            ->setParameter('agent', $agent);
    }

    /**
     * The conversations held under a qualified agent name, the only handle on
     * an agent a package ships.
     *
     * @return AgentConversation[]
     */
    public function findByAgentName(string $agentName): array
    {
        return $this->queryLastSpokenFirst()
            ->where($this->queryField('agentName').' = :agentName')
            ->setParameter('agentName', $agentName)
            ->getQuery()
            ->getResult();
    }

    /**
     * The conversations, the one last spoken to first: one nobody answered
     * falls back on the moment it was opened.
     */
    protected function queryLastSpokenFirst(): QueryBuilder
    {
        $alias = $this->getEntityQueryAlias();

        return $this->createQueryBuilder($alias)
            ->addSelect(
                sprintf('COALESCE(%s.dateLastMessage, %s.dateCreated) AS HIDDEN lastActivity', $alias, $alias)
            )
            ->orderBy('lastActivity', self::SORT_DESC);
    }
}
