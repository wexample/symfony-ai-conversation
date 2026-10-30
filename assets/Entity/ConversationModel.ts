import AbstractApiEntity from '@wexample/js-api-entity/Common/AbstractApiEntity';
import schema from '../data/entity/conversation_model.json';

export default class ConversationModel extends AbstractApiEntity {
  static readonly entityName = 'conversationModel';

  static retrieveEntitySchema() {
    return schema;
  }
}
