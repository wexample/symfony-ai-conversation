import Conversation from '@wexample/symfony-conversation/Entity/Conversation';
import type { ApiEntitySchema } from '@wexample/js-api-entity/Common/AbstractApiEntity';
import schema from '../data/entity/agent_conversation.json';

export default class AgentConversation extends Conversation {
  static retrieveEntitySchema(): ApiEntitySchema {
    return schema;
  }
}
