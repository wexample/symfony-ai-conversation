import agent from '../data/entity/conversation_agent.json';
import claudeSession from '../data/entity/claude_conversation_session.json';
import message from '../data/entity/conversation_message.json';
import model from '../data/entity/conversation_model.json';
import session from '../data/entity/conversation_session.json';

type EntitySchema = { name: string };

export default function getGeneratedEntitySchemas(): Record<string, EntitySchema> {
  return {
    [agent.name]: agent,
    [claudeSession.name]: claudeSession,
    [message.name]: message,
    [model.name]: model,
    [session.name]: session,
  };
}
