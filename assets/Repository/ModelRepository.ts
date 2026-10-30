import AbstractApiRepository from '@wexample/js-api-entity/Common/AbstractApiRepository';
import ConversationModel from '../Entity/ConversationModel.js';

export default class ModelRepository extends AbstractApiRepository<ConversationModel> {
  static getEntityType() {
    return ConversationModel;
  }
}
