<?php

namespace Wexample\SymfonyAiConversation\Api\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;
use Wexample\SymfonyAi\Service\AgentBackToolsService;
use Wexample\SymfonyAiConversation\Api\Dto\Entity\AgentConversation\ToolResultDto;
use Wexample\SymfonyAiConversation\EventListener\AgentBackToolListener;
use Wexample\SymfonyApi\Api\Attribute\ValidateRequestContent;
use Wexample\SymfonyApi\Api\Class\ApiResponse;
use Wexample\SymfonyApi\Api\Controller\AbstractApiController;
use Wexample\SymfonyConversation\Api\Normalizer\Entity\ConversationMessage\DefaultMessageNormalizer;
use Wexample\SymfonyConversation\Entity\ConversationMessage;
use Wexample\SymfonyConversation\Repository\ConversationRepository;
use Wexample\SymfonyConversation\Repository\MessageRepository;
use Wexample\SymfonyConversation\Repository\UserParticipantRepository;
use Wexample\SymfonyHelpers\Controller\AbstractController;
use Wexample\SymfonyHelpers\Voter\AbstractEntityVoter;

/**
 * What the page answers to a tool an agent called, written as a tool line by
 * the person answering it — once per call, however many pages ran it.
 */
#[Route(path: '_api/agent-conversation/', name: 'api_agent_conversation_')]
class ToolResultController extends AbstractApiController
{
    /** What names the answer to a tool call, by the call: one per call. */
    final public const string TOOL_RESULT_PREFIX = 'tool_result:';

    #[Route(path: 'tool-result', name: 'tool_result', methods: [Request::METHOD_POST], options: AbstractController::ROUTE_OPTIONS_ONLY_EXPOSE)]
    #[ValidateRequestContent(dto: ToolResultDto::class, attributeName: 'toolResultDto')]
    public function create(
        ToolResultDto $toolResultDto,
        ConversationRepository $conversationRepository,
        UserParticipantRepository $userParticipantRepository,
        MessageRepository $messageRepository,
        DefaultMessageNormalizer $normalizer,
        AgentBackToolsService $agentBackTools,
    ): ApiResponse {
        $conversation = $conversationRepository->find($toolResultDto->conversation);

        if (! $conversation) {
            return self::apiResponseError('Unknown conversation.');
        }

        $this->denyAccessUnlessGranted(AbstractEntityVoter::EDIT, $conversation);

        $result = $toolResultDto->toolResult;

        if (! is_string($result['tool'] ?? null) || ! is_string($result['callId'] ?? null)) {
            return self::apiResponseError('A tool result names its tool and the call it answers.');
        }

        // A call is answered once: the second answer is the first one, and
        // the engine is not asked again.
        $identifier = self::TOOL_RESULT_PREFIX.$result['callId'];

        if ($existing = $messageRepository->findOneByProviderMessageIdentifier($identifier)) {
            return self::apiResponseSuccess(data: $normalizer->normalize($existing));
        }

        // The page lists its own tools; the server's join them here, on their
        // way to the agent, the page knowing nothing of them.
        $called = Uuid::isValid($result['callId']) ? $messageRepository->find($result['callId']) : null;
        $call = $called ? AgentBackToolListener::readCall($called) : null;

        if ($call && is_array($result['results'] ?? null) && $agentBackTools->isToolList($call)) {
            $result['results'] = $agentBackTools->completeToolList($call, $result['results']);
            $result['count'] = count($result['results']);
        }

        try {
            $message = $messageRepository->saveNewMessageAndPushEvent(
                conversation: $conversation,
                type: ConversationMessage::TYPE_TOOL,
                body: json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                author: $userParticipantRepository->findOneByConversationAndUser($conversation, $this->getUser()),
                providerMessageIdentifier: $identifier,
            );
        } catch (UniqueConstraintViolationException) {
            // Two pages answered the same call at the same instant: the other
            // was written first, and is the answer.
            return self::apiResponseSuccess(data: ['duplicate' => true]);
        }

        return self::apiResponseSuccess(data: $normalizer->normalize($message));
    }
}
