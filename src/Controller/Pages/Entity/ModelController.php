<?php

namespace Wexample\SymfonyAiConversation\Controller\Pages\Entity;

use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Wexample\SymfonyAiConversation\Entity\Model;
use Wexample\SymfonyAiConversation\Entity\Traits\Manipulator\ModelEntityManipulatorTrait;
use Wexample\SymfonyAiConversation\Repository\ModelRepository;
use Wexample\SymfonyAiConversation\Traits\SymfonyAiConversationBundleClassTrait;
use Wexample\SymfonyLoader\Controller\AbstractEntityPagesController;

/**
 * The models an agent can be pointed at, as the catalogue holds them.
 *
 * Read only: the list is projected from whoever runs the turns, so a model is
 * neither created nor edited from here.
 */
#[Route(path: 'model/', name: 'entity_model_')]
class ModelController extends AbstractEntityPagesController
{
    use ModelEntityManipulatorTrait;
    use SymfonyAiConversationBundleClassTrait;

    final public const string ROUTE_INDEX = self::DEFAULT_ROUTE_NAME_INDEX;
    final public const string ROUTE_SHOW = self::DEFAULT_ROUTE_NAME_SHOW;

    #[Route(name: self::ROUTE_INDEX, path: '')]
    public function index(
        ModelRepository $modelRepository
    ): Response {
        return $this->renderPage(self::ROUTE_INDEX, [
            // The list arrives ranked, most capable first, and sorting it on any
            // field of its own is what would lose that.
            'models' => $modelRepository->findBy(
                [],
                ['position' => ModelRepository::SORT_ASC]
            ),
        ]);
    }

    #[Route(name: self::ROUTE_SHOW, path: '{id}/', options: self::ROUTE_OPTIONS_ONLY_EXPOSE)]
    public function show(
        #[MapEntity] Model $model
    ): Response {
        return $this->renderPage(self::ROUTE_SHOW, [
            'model' => $model,
        ]);
    }
}
