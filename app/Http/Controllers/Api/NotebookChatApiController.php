<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreChatMessageRequest;
use App\Models\Chat;
use App\Models\Notebook;
use App\Services\NotebookRagService;
use App\Services\OpenAIService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class NotebookChatApiController extends Controller
{
    /**
     * Store a new AI exchange for the notebook chat.
     */
    public function store(
        StoreChatMessageRequest $request,
        Notebook $notebook,
        Chat $chat,
        NotebookRagService $rag,
        OpenAIService $openAI,
    ): Response|JsonResponse|StreamedResponse {
        abort_unless($chat->notebook_id === $notebook->id, 404);

        $prompt = $request->string('prompt')->trim()->toString();
        $mode = $request->string('mode')->toString() ?: ($chat->mode ?: 'qa');
        $selectedSourceIds = $request->input('selected_source_ids');
        $selectedSourceIds = is_array($selectedSourceIds)
            ? array_values(array_map('intval', array_filter($selectedSourceIds, fn ($id) => is_int($id) || ctype_digit((string) $id))))
            : null;

        $contextPayload = $rag->buildContext($notebook, $prompt, 4, $selectedSourceIds ?: null);

        $userMessage = $chat->messages()->create([
            'user_id' => null,
            'role' => 'user',
            'content' => $prompt,
            'metadata' => ['mode' => $mode, 'selected_source_ids' => $selectedSourceIds ?: null],
        ]);

        $answer = $openAI->answer($prompt, $contextPayload['context'], $contextPayload['citations'], $mode);

        $assistantMessage = $chat->messages()->create([
            'role' => 'assistant',
            'content' => $answer['text'],
            'citations' => $answer['citations'],
            'metadata' => ['provider' => $answer['provider'], 'mode' => $mode],
        ]);

        $chat->update([
            'mode' => $mode,
            'last_message_at' => now(),
            'title' => $chat->title === 'Primary workspace' ? str($prompt)->limit(48)->toString() : $chat->title,
        ]);

        if ($request->boolean('stream')) {
            return response()->stream(function () use ($assistantMessage): void {
                foreach (str_split($assistantMessage->content, 140) as $chunk) {
                    echo 'data: '.json_encode(['chunk' => $chunk])."\n\n";
                    @ob_flush();
                    flush();
                    usleep(20000);
                }

                echo 'data: '.json_encode([
                    'done' => true,
                    'message' => [
                        'id' => $assistantMessage->id,
                        'content' => $assistantMessage->content,
                        'citations' => $assistantMessage->citations,
                    ],
                ])."\n\n";
            }, 200, [
                'Content-Type' => 'text/event-stream',
                'Cache-Control' => 'no-cache',
                'X-Accel-Buffering' => 'no',
            ]);
        }

        return response()->json([
            'message' => 'AI response generated successfully.',
            'user_message' => $userMessage,
            'assistant_message' => $assistantMessage,
            'context' => $contextPayload,
        ]);
    }
}
