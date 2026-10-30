import AbstractApiRepository from '@wexample/js-api-entity/Common/AbstractApiRepository';
import ConversationAgent from '../Entity/ConversationAgent.js';

export default class AgentRepository extends AbstractApiRepository<ConversationAgent> {
  static getEntityType() {
    return ConversationAgent;
  }
}
