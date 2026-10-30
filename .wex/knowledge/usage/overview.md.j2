# Conversations held in the application

`symfony-ai-conversation` keeps the conversations an application holds with agents: a `ConversationSession` per thread, its `ConversationMessage`s, the `ConversationAgent`s and `ConversationModel`s they run on. An engine adds its own kind of session under the same root — `ClaudeConversationSession` here, `SyrtisConversationSession` in `syrtis/symfony-client` —, named so that the discriminator stays the engine's word: `claude`, `syrtis`.

## Names that stay out of the application's way

The entities are named after the package, and so is everything the stack derives from a name:

| | |
|---|---|
| Tables | `ai_conversation_session`, `ai_conversation_message`, `ai_conversation_agent`, `ai_conversation_model`, `ai_conversation_claude_session` — and `ai_conversation_syrtis_session` in the Syrtis client |
| Api | `/_api/conversation-message/` (`api_conversation_message_*`), `/_api/conversation-session/` (`api_conversation_session_*`) |
| Live topic | `entity/conversation-session/event/{id}` |
| Browser entities | `conversation-message`, `conversation-session`… (`assets/Entity/`), their repositories registered by the application's api client |

An application that already has a `session`, a `message` or a `model` of its own — the Syrtis manager — can thus hold conversations beside them. An application coming from the former names (`session`, `message`…) renames its tables; the rows and the discriminator values stay (portfolio, `Version20261030120000`).

## What runs on it

- The chat of a conversation, `vue/collection/chat/message-chat`, stands on the design system's `abstract-agent-chat`: the agent's tool calls run in the page, their answers come back through `MessageController::create`, the server's tools are answered by `AgentBackToolListener` (`wexample/symfony-ai`).
- Whoever answers a turn listens to `MessageCreatedEvent`: the Syrtis client sends the message on and brings the agent's answer back; a transcript reader fills the thread from Claude's files.
