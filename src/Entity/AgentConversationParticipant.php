<?php

namespace Wexample\SymfonyAiConversation\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Wexample\Pseudocode\Attribute\PseudocodeExport;
use Wexample\SymfonyAiConversation\Repository\AgentParticipantRepository;
use Wexample\SymfonyConversation\Entity\Conversation;
use Wexample\SymfonyConversation\Entity\ConversationParticipant;

/**
 * An agent taking part in a conversation: the record of it when the app holds
 * one, its qualified name always — what an agent a package ships is known by.
 */
#[PseudocodeExport(inherited: true)]
#[ORM\Entity(repositoryClass: AgentParticipantRepository::class)]
#[ORM\Table(name: 'conversation_agent_participant')]
class AgentConversationParticipant extends ConversationParticipant
{
    #[ORM\ManyToOne(targetEntity: ConversationAgent::class)]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    protected ?ConversationAgent $agent = null;

    #[ORM\Column(type: Types::STRING, length: 255)]
    protected string $agentName;

    public function __construct(Conversation $conversation, string $agentName, ?ConversationAgent $agent = null)
    {
        $this->agentName = $agentName;
        $this->agent = $agent;

        parent::__construct($conversation);
    }

    public function getAgent(): ?ConversationAgent
    {
        return $this->agent;
    }

    public function getAgentName(): string
    {
        return $this->agentName;
    }

    public function getLabel(): string
    {
        return $this->agent?->getName() ?: $this->agentName;
    }
}
