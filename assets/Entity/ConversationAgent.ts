import AbstractApiEntity from '@wexample/js-api-entity/Common/AbstractApiEntity';
import schema from '../data/entity/conversation_agent.json';

export default class ConversationAgent extends AbstractApiEntity {
  static readonly entityName = 'conversationAgent';

  static retrieveEntitySchema() {
    return schema;
  }
}
