<?php

namespace App\Jobs;

use App\Models\Message;
use Cloudstudio\Ollama\Facades\Ollama;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessAiResponse implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected int    $chatId,
        protected string $prompt
    ) {}

    public function handle(): void
    {
        $response = (object)Ollama::prompt($this->prompt)->model('gemma3:1b')->ask();

        Message::create([
            'content' => $response->response,
            'is_user' => false,
            'chat_id' => $this->chatId
        ]);
    }
}
