import ConversationSession from './ConversationSession.js';
import type { ApiEntitySchema } from '@wexample/js-api-entity/Common/AbstractApiEntity';
import schema from '../data/entity/claude_conversation_session.json';

export default class ClaudeConversationSession extends ConversationSession {
  // Typed as any schema, so that a subclass may answer its own.
  static retrieveEntitySchema(): ApiEntitySchema {
    return schema;
  }
}
