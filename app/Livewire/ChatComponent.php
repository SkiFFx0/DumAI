<?php

namespace App\Livewire;

use App\Jobs\ProcessAiResponse;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatComponent extends Component
{
    public $logoPath = 'images/logo.png';
    public $sidebarOpen = true;
    public $selectedChat = null;
    public $chats;
    public $messageHistory;
    public $prompt;
    public $isAiResponding = false; // Track AI response state

    public function mount()
    {
        if (Auth::id() === null)
        {
            return redirect()->route('login');
        }

        $this->loadChats();
    }

    protected function loadChats()
    {
        $this->chats = Chat::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        if ($this->chats->isNotEmpty())
        {
            $this->selectChat($this->chats->first()->id);
        }
    }

    // Sidebar toggle
    public function toggleSidebar()
    {
        $this->sidebarOpen = !$this->sidebarOpen;
    }

    // Create new chat button
    public function createNewChat()
    {
        $this->selectedChat = null;
    }

    // Chat selection handler
    public function selectChat($chatId)
    {
        $this->selectedChat = Chat::with('messages')
            ->where('user_id', Auth::id())
            ->findOrFail($chatId);

        $this->messageHistory = $this->selectedChat->messages;
    }

    protected $rules = [
        'prompt' => 'required|string|max:2000'
    ];

    // Message sending handler
    public function sendMessage()
    {
        $validated = $this->validate();

        if (!$this->selectedChat)
        {
            $this->selectedChat = Chat::create([
                'title' => 'New Chat',
                'user_id' => Auth::id()
            ]);
            $this->chats->prepend($this->selectedChat);
        }

        // Create user message
        Message::create([
            'content' => $validated['prompt'],
            'is_user' => true,
            'chat_id' => $this->selectedChat->id
        ]);

        // Refresh messages to show user input immediately
        $this->messageHistory = $this->selectedChat->refresh()->messages;
        $this->isAiResponding = true;

        // Dispatch AI processing job
        ProcessAiResponse::dispatch($this->selectedChat->id, $validated['prompt']);

        $this->prompt = '';
    }

    public function checkAiResponse()
    {
        if (!$this->isAiResponding) return;

        $this->messageHistory = $this->selectedChat->refresh()->messages;

        // Check if last message is AI response
        if ($this->messageHistory->last()?->is_user === false)
        {
            $this->isAiResponding = false;
        }
    }

    public function render()
    {
        return view('livewire.chat-component');
    }
}
