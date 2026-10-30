import AbstractApiEntity from '@wexample/js-api-entity/Common/AbstractApiEntity';
import type { ApiEntitySchema } from '@wexample/js-api-entity/Common/AbstractApiEntity';
import schema from '../data/entity/conversation_session.json';

export default class ConversationSession extends AbstractApiEntity {
  static readonly entityName = 'conversation-session';

  static retrieveEntitySchema(): ApiEntitySchema {
    return schema;
  }
}
