<?php

namespace Wexample\SymfonyAiConversation\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Wexample\Pseudocode\Attribute\PseudocodeExport;
use Wexample\SymfonyAiConversation\Repository\AgentConversationRepository;
use Wexample\SymfonyConversation\Entity\Conversation;

/**
 * A conversation an engine holds with an agent: which agent, the model it was
 * pinned to, how many turns it ran. What ties it to its engine — a transcript
 * on disk, a session on a remote server — is the engine's subclass's, each in
 * a table of its own. The agent takes part as a participant of its own
 * (AgentConversationParticipant), beside the people talking to it.
 */
#[PseudocodeExport(inherited: true)]
#[ORM\Entity(repositoryClass: AgentConversationRepository::class)]
#[ORM\Table(name: 'agent_conversation')]
abstract class AgentConversation extends Conversation
{
    /**
     * Null for an agent a package ships: that one is code, it has no record,
     * and `agentName` is all there is to remember it by.
     */
    #[ORM\ManyToOne(targetEntity: ConversationAgent::class)]
    protected ?ConversationAgent $agent = null;

    /** Qualified name the operator recognises: `app:main`, `syrtis:<scenario>`. */
    #[ORM\Column(type: Types::STRING, length: 255)]
    protected string $agentName = '';

    /** The model the conversation was pinned to, null while the agent's own decides. */
    #[ORM\ManyToOne(targetEntity: ConversationModel::class)]
    protected ?ConversationModel $model = null;

    #[ORM\Column(type: Types::INTEGER)]
    protected int $turnCount = 0;

    public function getAgent(): ?ConversationAgent
    {
        return $this->agent;
    }

    public function setAgent(?ConversationAgent $agent): static
    {
        $this->agent = $agent;

        return $this;
    }

    public function getAgentName(): string
    {
        return $this->agentName;
    }

    public function setAgentName(string $agentName): static
    {
        $this->agentName = $agentName;

        return $this;
    }

    public function getModel(): ?ConversationModel
    {
        return $this->model;
    }

    public function setModel(?ConversationModel $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getTurnCount(): int
    {
        return $this->turnCount;
    }

    public function setTurnCount(int $turnCount): static
    {
        $this->turnCount = $turnCount;

        return $this;
    }

    /** The agent as it takes part, null before it was given a part. */
    public function getAgentParticipant(): ?AgentConversationParticipant
    {
        foreach ($this->getParticipants() as $participant) {
            if ($participant instanceof AgentConversationParticipant) {
                return $participant;
            }
        }

        return null;
    }
}
