<?php

declare(strict_types=1);

namespace Wexample\SymfonyAiConversation\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Wexample\SymfonyAiConversation\Service\AgentConversationService;
use Wexample\SymfonyAiConversation\Service\ClaudeTranscriptReader;
use Wexample\SymfonyAiConversation\Service\MessageHydrator;
use Wexample\SymfonyConversation\Entity\ConversationMessage;

class ClaudeTranscriptReaderTest extends TestCase
{
    private string $path;

    protected function setUp(): void
    {
        $this->path = tempnam(sys_get_temp_dir(), 'transcript');
    }

    protected function tearDown(): void
    {
        if (is_file($this->path)) {
            unlink($this->path);
        }
    }

    /**
     * @param list<string> $lines
     *
     * @return list<array<string, mixed>>
     */
    private function read(array $lines): array
    {
        file_put_contents($this->path, implode("\n", $lines));

        return iterator_to_array((new ClaudeTranscriptReader())->read($this->path), false);
    }

    public function testCarriedLinesBecomeMessagesAndBookkeepingIsLeft(): void
    {
        $messages = $this->read([
            json_encode(['type' => 'summary', 'summary' => 'A title']),
            json_encode([
                'type' => 'user',
                'uuid' => 'u-1',
                'timestamp' => '2026-11-14T10:00:00Z',
                'message' => ['content' => '  Hello  '],
            ]),
            json_encode([
                'type' => 'assistant',
                'uuid' => 'a-1',
                'message' => [
                    'content' => [
                        ['type' => 'thinking', 'thinking' => 'hidden'],
                        ['type' => 'tool_use', 'name' => 'Read', 'input' => ['file_path' => '/a.php']],
                    ],
                    'usage' => ['input_tokens' => 3, 'output_tokens' => 4, 'cache_read_input_tokens' => 5],
                ],
            ]),
        ]);

        $this->assertCount(2, $messages);

        $this->assertSame(AgentConversationService::SPEAKER_USER, $messages[0][MessageHydrator::KEY_SPEAKER]);
        $this->assertSame('Hello', $messages[0][MessageHydrator::KEY_BODY]);
        $this->assertSame(ConversationMessage::TYPE_TEXT, $messages[0][MessageHydrator::KEY_TYPE]);
        $this->assertSame('u-1', $messages[0][MessageHydrator::KEY_PROVIDER_MESSAGE_IDENTIFIER]);
        $this->assertNull($messages[0][MessageHydrator::KEY_TOKENS]);

        $this->assertSame(AgentConversationService::SPEAKER_AGENT, $messages[1][MessageHydrator::KEY_SPEAKER]);
        $this->assertSame('Read /a.php', $messages[1][MessageHydrator::KEY_BODY]);
        $this->assertSame(ConversationMessage::TYPE_TOOL, $messages[1][MessageHydrator::KEY_TYPE]);
        $this->assertSame(12, $messages[1][MessageHydrator::KEY_TOKENS]);
    }

    public function testBlankPartialAndScalarLinesAreSkipped(): void
    {
        $messages = $this->read([
            '',
            '   ',
            '42',
            json_encode(['type' => 'user', 'message' => ['content' => 'kept']]),
            // The last line, the provider still writing it.
            '{"type":"assistant","message":{"content":"cut sho',
        ]);

        $this->assertCount(1, $messages);
        $this->assertSame('kept', $messages[0][MessageHydrator::KEY_BODY]);
    }

    public function testAnUnreadableTranscriptSaysSo(): void
    {
        unlink($this->path);

        $this->expectException(RuntimeException::class);

        iterator_to_array((new ClaudeTranscriptReader())->read($this->path));
    }

    public function testToolCallFallsBackToItsName(): void
    {
        $reader = new ClaudeTranscriptReader();

        $this->assertSame('Bash ls -la', $reader->toolCall(['name' => 'Bash', 'input' => ['command' => 'ls -la']]));
        $this->assertSame('TodoWrite', $reader->toolCall(['name' => 'TodoWrite', 'input' => ['todos' => []]]));
    }
}
