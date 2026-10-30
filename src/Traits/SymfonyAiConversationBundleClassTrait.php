<?php

namespace Wexample\SymfonyAiConversation\Traits;

use Wexample\SymfonyAiConversation\WexampleSymfonyAiConversationBundle;
use Wexample\SymfonyHelpers\Traits\BundleClassTrait;

trait SymfonyAiConversationBundleClassTrait
{
    use BundleClassTrait;

    public static function getBundleClassName(): string
    {
        return WexampleSymfonyAiConversationBundle::class;
    }
}
