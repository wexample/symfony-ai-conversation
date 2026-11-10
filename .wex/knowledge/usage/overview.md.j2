# Conversations with agents

`symfony-ai-conversation` is what a conversation of `wexample/symfony-conversation` has when an agent takes part in it: an `AgentConversation` — which agent, the model it was pinned to, how far it got —, the agent as a participant of its own (`AgentConversationParticipant`), the `ConversationAgent`s and `ConversationModel`s, Claude's transcripts, the tools an agent calls (`wexample/symfony-ai`). The conversation, its people, its lines and who may read them are symfony-conversation's.

An engine adds its own kind under `AgentConversation`: `ClaudeConversation` here, `SyrtisConversation` in `syrtis/symfony-client` — `claude`, `syrtis` in the conversation's `kind`.

| | |
|---|---|
| Tables | `agent_conversation`, `conversation_agent_participant`, `claude_conversation`; `ai_conversation_agent`, `ai_conversation_model` |
| Api | `/_api/agent-conversation/tool-result` (`api_agent_conversation_tool_result`): what the page answers to a tool call, once per call |
| Browser entities | `AgentConversation`, `ClaudeConversation`, `ConversationAgent`, `ConversationModel` (`assets/Entity/`) |

## Who speaks

A line of an engine says who said it — `speaker`: `agent`, `user`, none — and is written by its author (`AgentConversationService::authorFor`): the agent's participant, the person holding the conversation (the first who joined), nobody for the conversation's own line. `MessageHydrator` and `ClaudeTranscriptReader` carry `speaker` both ways.

## What runs on it

- The chat, `vue/collection/chat/message-chat`, on the design system's `abstract-agent-chat`: the agent's tool calls run in the page and are answered through `ToolResultController`; the server's tools are answered by `AgentBackToolListener`, as the person holding the conversation.
- Whoever answers a line listens to symfony-conversation's `MessageCreatedEvent`: the Syrtis client sends the person's line on and writes the agent's answer back.
