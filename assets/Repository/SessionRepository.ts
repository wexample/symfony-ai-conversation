import AbstractApiRepository from '@wexample/js-api-entity/Common/AbstractApiRepository';
import ConversationSession from '../Entity/ConversationSession.js';

export default class SessionRepository extends AbstractApiRepository<ConversationSession> {
  static getEntityType() {
    return ConversationSession;
  }
}
