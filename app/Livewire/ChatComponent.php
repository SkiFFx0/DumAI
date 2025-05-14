<?php

namespace App\Livewire;

use App\Models\Chat;
use App\Models\Message;
use Cloudstudio\Ollama\Facades\Ollama;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ChatComponent extends Component
{
    // Component Properties
    public $logoPath = 'images/logo.png';
    public $sidebarOpen = true;
    public $selectedChat = null;
    public $chats;
    public $messageHistory;
    public $prompt;

    // Initial component setup
    public function mount()
    {
        if (Auth::id() === null)
        {
            return redirect()->route('login');
        }

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

        Message::create([
            'content' => $validated['prompt'],
            'is_user' => true,
            'chat_id' => $this->selectedChat->id
        ]);

        $aiResponse = (object) Ollama::prompt($validated['prompt'])->ask();

        Message::create([
            'content' => $aiResponse->response,
            'is_user' => false,
            'chat_id' => $this->selectedChat->id
        ]);

        // Keep messages as Collection
        $this->messageHistory = $this->selectedChat->refresh()->messages;
        $this->prompt = '';
    }

    public function render()
    {
        return view('livewire.chat-component');
    }
}
