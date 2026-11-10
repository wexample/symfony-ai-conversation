<?php

namespace Wexample\SymfonyAiConversation\Controller\Pages\Entity;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Wexample\SymfonyAiConversation\Entity\AgentConversation;
use Wexample\SymfonyAiConversation\Entity\Traits\Manipulator\AgentConversationEntityManipulatorTrait;
use Wexample\SymfonyAiConversation\Service\FormProcessor\SessionFormProcessor;
use Wexample\SymfonyAiConversation\Traits\SymfonyAiConversationBundleClassTrait;
use Wexample\SymfonyForms\Attribute\EntityFormProcessor;
use Wexample\SymfonyLoader\Controller\AbstractEntityPagesController;

#[Route(path: 'session/', name: 'entity_session_')]
class SessionController extends AbstractEntityPagesController
{
    use AgentConversationEntityManipulatorTrait;
    use SymfonyAiConversationBundleClassTrait;

    final public const string ROUTE_EDIT = self::DEFAULT_ROUTE_NAME_EDIT;

    #[EntityFormProcessor(SessionFormProcessor::class, AgentConversation::class)]
    #[Route(name: self::ROUTE_EDIT, path: '{id}/'.self::ROUTE_EDIT, options: self::ROUTE_OPTIONS_ONLY_EXPOSE)]
    public function edit(
        FormInterface $sessionForm
    ): Response {
        return $this->renderPage(self::ROUTE_EDIT, [
            'form_edit' => $sessionForm->createView(),
        ]);
    }
}
