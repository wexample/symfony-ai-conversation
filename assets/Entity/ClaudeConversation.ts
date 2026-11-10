import AgentConversation from './AgentConversation.js';
import type { ApiEntitySchema } from '@wexample/js-api-entity/Common/AbstractApiEntity';
import schema from '../data/entity/claude_conversation.json';

export default class ClaudeConversation extends AgentConversation {
  static retrieveEntitySchema(): ApiEntitySchema {
    return schema;
  }
}
