<?php

namespace Wexample\SymfonyAiConversation\Api\Controller;

use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Wexample\SymfonyAiConversation\Api\Dto\Entity\AgentConversation\StopDto;
use Wexample\SymfonyAiConversation\Event\AgentStoppedEvent;
use Wexample\SymfonyApi\Api\Attribute\ApiAccess;
use Wexample\SymfonyApi\Api\Attribute\ValidateRequestContent;
use Wexample\SymfonyApi\Api\Class\ApiResponse;
use Wexample\SymfonyApi\Api\Controller\AbstractApiController;
use Wexample\SymfonyConversation\Repository\ConversationRepository;
use Wexample\SymfonyHelpers\Controller\AbstractController;
use Wexample\SymfonyHelpers\Voter\AbstractEntityVoter;

/**
 * The agent of a conversation stopped by the person talking with it: said
 * to whatever drives it (AgentStoppedEvent), which cuts its turn short. The
 * page has already stopped running its calls.
 */
#[Route(path: '_api/agent-conversation/', name: 'api_agent_conversation_')]
#[ApiAccess(ApiAccess::CONTROLLER, "the conversation's voter")]
class StopController extends AbstractApiController
{
    #[Route(path: 'stop', name: 'stop', methods: [Request::METHOD_POST], options: AbstractController::ROUTE_OPTIONS_ONLY_EXPOSE)]
    #[ValidateRequestContent(dto: StopDto::class, attributeName: 'stopDto')]
    public function stop(
        StopDto $stopDto,
        ConversationRepository $conversationRepository,
        EventDispatcherInterface $dispatcher,
    ): ApiResponse {
        $conversation = $conversationRepository->find($stopDto->conversation);

        if (! $conversation) {
            return self::apiResponseError('Unknown conversation.');
        }

        $this->denyAccessUnlessGranted(AbstractEntityVoter::EDIT, $conversation);

        $dispatcher->dispatch(new AgentStoppedEvent($conversation));

        return self::apiResponseSuccess();
    }
}
