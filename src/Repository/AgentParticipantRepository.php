<?php

namespace Wexample\SymfonyAiConversation\Repository;

use Wexample\SymfonyAiConversation\Entity\Traits\Manipulator\AgentParticipantEntityManipulatorTrait;
use Wexample\SymfonyHelpers\Repository\AbstractRepository;

class AgentParticipantRepository extends AbstractRepository
{
    use AgentParticipantEntityManipulatorTrait;
}
