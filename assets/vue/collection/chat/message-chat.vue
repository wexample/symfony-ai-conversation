<script>
import AbstractAgentChat from '@wexample/symfony-design-system/components/collection/chat/abstract-agent-chat/abstract-agent-chat.vue';
import ApiService from '@wexample/symfony-loader/js/Services/ApiService';
import ConversationMessage from '@wexample/symfony-conversation/Entity/ConversationMessage';

const ICON_BY_TYPE = {
  error: 'ph:bold/warning-circle',
  system: 'ph:bold/gear',
  tool: 'ph:bold/wrench'
};

// Words, by who wrote them: the agent, or the person talking to it.
const ICON_BY_SPEAKER = {
  agent: 'ph:bold/robot',
  user: 'ph:bold/user'
};

// What the server publishes on the conversation's topic when a line is written.
const EVENT_MESSAGE_CREATED = 'message-created';

// A tool turn is one of two things, both json in its body: what the agent
// called — `name`, `arguments` —, or what the page answered — `tool`,
// `callId`, `results`. Only the first is the page's to run.
const TYPE_TOOL = 'tool';

export default {
  extends: AbstractAgentChat,

  template: '#vue-template-wexample-symfony-ai-conversation-bundle-vue-collection-chat-message-chat',

  props: {
    // A thread is the thread of one conversation, and which one is decided by
    // whoever places the component.
    conversationId: {
      type: String,
      required: true
    }
  },

  methods: {
    getEntityClass() {
      return ConversationMessage;
    },

    getEntitiesFetchParams() {
      return {
        query: {
          conversation: this.conversationId
        }
      };
    },

    getPageLength() {
      return 20;
    },

    startsAtLastPage() {
      return true;
    },

    // What the operator writes is answered by an agent, in the background:
    // the thread shows the answer is coming.
    expectsReply() {
      return true;
    },

    // Who spoke: the agent, the person talking to it — the reader, said so —,
    // the conversation itself for a line nobody wrote.
    getMessageAuthor(entity) {
      if (this.isOwnMessage(entity)) {
        return this.trans('@vue::author.user');
      }

      return entity.author?.label ?? this.trans(`@vue::author.${entity.type}`);
    },

    getSpeaker(entity) {
      return entity.author?.kind ?? null;
    },

    getMessageContent(entity) {
      return entity.body ?? '';
    },

    // The wait for an answer ends on what the agent says, not on what the
    // operator wrote.
    isOwnMessage(entity) {
      return this.getSpeaker(entity) === 'user' && entity.type === 'text';
    },

    readToolBody(entity) {
      if (entity.type !== TYPE_TOOL) {
        return null;
      }

      try {
        return JSON.parse(entity.body ?? '');
      } catch (error) {
        return null;
      }
    },

    // The call the agent made, null for any other line.
    readToolCall(entity) {
      const body = this.readToolBody(entity);

      return typeof body?.name === 'string' && !body.callId ? body : null;
    },

    isToolResult(entity) {
      return Boolean(this.readToolBody(entity)?.callId);
    },

    // The call's own turn names it: the engine answers a call by the id of
    // the turn that carried it.
    getToolCallId(entity) {
      return entity.id ?? null;
    },

    getConversationKey() {
      return this.conversationId;
    },

    async postToolResult(call, callId, results) {
      await this.app.getServiceOrFail(ApiService).getClient().post({
        path: 'agent-conversation/tool-result',
        options: {
          json: {
            conversation: this.conversationId,
            toolResult: {
              tool: call.name,
              callId,
              results
            }
          }
        }
      });
    },

    getMessageDate(entity) {
      return entity.dateCreated ?? null;
    },

    getMessageIcon(entity) {
      return ICON_BY_TYPE[entity.type] ?? ICON_BY_SPEAKER[this.getSpeaker(entity)] ?? ICON_BY_SPEAKER.user;
    },

    // The variants the thread draws: an agent's words as `assistant`, the
    // person's as `user`, the others by their type.
    getMessageVariant(entity) {
      if (entity.type !== 'text') {
        return entity.type;
      }

      return this.getSpeaker(entity) === 'agent' ? 'assistant' : 'user';
    },

    // Who spoke is not sent: the endpoint knows a turn arriving from here was
    // spoken by the operator, and refuses anything else in the payload.
    buildMessageEntity(content) {
      return new ConversationMessage({
        conversation: this.conversationId,
        body: content
      });
    },

    getLiveThread() {
      return {
        entityName: 'conversation',
        id: this.conversationId,
        event: EVENT_MESSAGE_CREATED
      };
    }
  }
};
</script>
