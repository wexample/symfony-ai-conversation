<script>
import AbstractAgentChat from '@wexample/symfony-design-system/components/collection/chat/abstract-agent-chat/abstract-agent-chat.vue';
import ApiService from '@wexample/symfony-loader/js/Services/ApiService';
import ConversationChatMixin from '@wexample/symfony-conversation/js/Vue/ConversationChatMixin';

const ICON_BY_TYPE = {
  error: 'ph:bold/warning-circle',
  system: 'ph:bold/gear',
  tool: 'ph:bold/wrench'
};

// A tool turn is one of two things, both json in its body: what the agent
// called — `name`, `arguments` —, or what the page answered — `tool`,
// `callId`, `results`. Only the first is the page's to run.
const TYPE_TOOL = 'tool';

// A conversation with an agent: the same conversation as any other — its
// lines by their authors, faces and names, read marks, the people named, its
// sound (ConversationChatMixin) —, and besides, the calls the agent makes to
// the page's tools, run here and answered (abstract-agent-chat).
export default {
  extends: AbstractAgentChat,

  mixins: [ConversationChatMixin],

  template: '#vue-template-wexample-symfony-ai-conversation-bundle-vue-collection-chat-message-chat',

  methods: {
    // The reader's words, and only them: the wait for an answer ends on what
    // the agent says, not on a call's answer sent from here.
    isOwnMessage(entity) {
      return ConversationChatMixin.methods.isOwnMessage.call(this, entity) && entity.type === 'text';
    },

    // What the reader did in the page goes to the agent with the call answers
    // (postToolResult), not with what they write: taken here, it is not sent
    // twice.
    async postMessage(content, files = [], options = {}) {
      this.takeUserEvents();

      await ConversationChatMixin.methods.postMessage.call(this, content, files, options);
    },

    // A line nobody wrote — an error, a call — by what it is.
    getMessageIcon(entity) {
      return ICON_BY_TYPE[entity.type] ?? 'ph:bold/user';
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
    }
  }
};
</script>
