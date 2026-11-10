import agent from '../data/entity/conversation_agent.json';
import agentConversation from '../data/entity/agent_conversation.json';
import claudeConversation from '../data/entity/claude_conversation.json';
import model from '../data/entity/conversation_model.json';

type EntitySchema = { name: string };

export default function getGeneratedEntitySchemas(): Record<string, EntitySchema> {
  return {
    [agent.name]: agent,
    [agentConversation.name]: agentConversation,
    [claudeConversation.name]: claudeConversation,
    [model.name]: model,
  };
}
