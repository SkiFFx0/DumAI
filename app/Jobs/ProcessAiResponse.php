<?php

namespace App\Jobs;

use App\Models\Chat;
use App\Models\Message;
use Cloudstudio\Ollama\Facades\Ollama;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessAiResponse implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(protected int $chatId, protected string $prompt) {}

    public function handle(): void
    {
        $chat = Chat::findOrFail($this->chatId);
        $user = $chat->user;
        $agentPrompt = $user->agent_prompt ?? 'You are a helpful assistant.';
        $temperature = $user->temperature ?? 0;

        $conversation = "[Agent Instructions]\n" . $agentPrompt . "\n\n";

        $chatMessages = Message::where('chat_id', $this->chatId)
            ->orderBy('created_at', 'asc')
            ->get();

        $contextMessages = [];
        if ($chatMessages->count() >= 2)
        {
            $contextMessages = $chatMessages->slice(-4)->values();
        } elseif ($chatMessages->count() == 1)
        {
            $contextMessages = $chatMessages->take(1);
        }

        $conversation .= "[Conversation History]\n";
        if ($contextMessages->isEmpty())
        {
            $conversation .= "No previous messages yet.\n";
        } else
        {
            foreach ($contextMessages as $msg)
            {
                $role = $msg->is_user ? 'User' : 'Assistant';
                $conversation .= $role . ': ' . $msg->content . "\n";
            }
        }

        $conversation .= "\n[Current Message]\nUser: " . $this->prompt . "\nAssistant:";

        Log::info('Ollama prompt:', ['prompt' => $conversation]);

        $ollama = Ollama::prompt($conversation)
            ->options(['temperature' => floatval($temperature)])
            ->stream(false);

        $askResult = $ollama->ask();
        Log::info('Ollama ask result:', ['result' => $askResult]);

        if (is_object($askResult))
        {
            if (property_exists($askResult, 'error'))
            {
                Log::error('Ollama error:', ['error' => $askResult->error]);
                $responseText = 'Error: ' . $askResult->error;
            } elseif (property_exists($askResult, 'response'))
            {
                $responseText = $askResult->response;
            } else
            {
                Log::error('Unexpected Ollama response object', ['result' => $askResult]);
                $responseText = 'Error: Unexpected response format';
            }
        } elseif (is_array($askResult))
        {
            if (array_key_exists('error', $askResult))
            {
                Log::error('Ollama error:', ['error' => $askResult['error']]);
                $responseText = 'Error: ' . $askResult['error'];
            } elseif (array_key_exists('response', $askResult))
            {
                $responseText = $askResult['response'];
            } else
            {
                Log::error('Unexpected Ollama response array', ['result' => $askResult]);
                $responseText = 'Error: Unexpected response format';
            }
        } else
        {
            Log::error('Ollama ask returned non-object/non-array', ['result' => $askResult]);
            $responseText = 'Error: Invalid response from AI';
        }

        if (str_starts_with($responseText, 'Assistant:'))
        {
            $responseText = trim(substr($responseText, strlen('Assistant:')));
        }

        Log::info('Processed response:', ['response' => $responseText]);

        Message::create([
            'content' => $responseText,
            'is_user' => false,
            'chat_id' => $this->chatId
        ]);
    }
}
