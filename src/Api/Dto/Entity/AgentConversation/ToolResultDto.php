<?php

namespace Wexample\SymfonyAiConversation\Api\Dto\Entity\AgentConversation;

use Symfony\Component\Validator\Constraints\Type;
use Wexample\SymfonyApi\Api\Attribute\RequiredDtoProperty;
use Wexample\SymfonyApi\Api\Dto\AbstractDto;
use Wexample\SymfonyHelpers\Helper\VariableHelper;

/**
 * What the page answers to a tool the agent called in a conversation: the
 * tool, the call it answers, the results.
 */
class ToolResultDto extends AbstractDto
{
    #[Type(VariableHelper::VARIABLE_TYPE_STRING)]
    #[RequiredDtoProperty]
    public string $conversation;

    /** @var array{tool: string, callId: string, results: array} */
    #[Type(VariableHelper::VARIABLE_TYPE_ARRAY)]
    #[RequiredDtoProperty]
    public array $toolResult;
}
