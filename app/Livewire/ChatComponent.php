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
    public $showSettingsModal = false;
    public $messageHistory;
    public $prompt;
    public $isAiResponding = false;
    public $showProfileDropdown = false;

    public function mount()
    {
        if (Auth::id() === null)
        {
            return redirect()->route('login');
        }

        $this->loadChats();

        $this->selectedChat = null;
    }

    protected function loadChats()
    {
        $this->chats = Chat::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        if ($this->chats->isNotEmpty()) {
            $this->selectChat($this->chats->first()->id);
        }
    }

    public function toggleSidebar()
    {
        $this->sidebarOpen = !$this->sidebarOpen;
    }

    public function createNewChat()
    {
        $this->selectedChat = null;
    }

    public function selectChat($chatId)
    {
        $this->selectedChat = Chat::with('messages')
            ->where('user_id', Auth::id())
            ->findOrFail($chatId);

        $this->messageHistory = $this->selectedChat->messages;
    }

    public function toggleSettingsModal()
    {
        $this->showSettingsModal = !$this->showSettingsModal;
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login');
    }

    protected function rules()
    {
        return [
            'prompt' => 'required|string|max:2000'
        ];
    }

    public function sendMessage()
    {
        $validated = $this->validate();

        if (!$this->selectedChat) {
            $this->selectedChat = Chat::create([
                'title' => $this->prompt,
                'user_id' => Auth::id()
            ]);
            $this->chats->prepend($this->selectedChat);
        }

        Message::create([
            'content' => $validated['prompt'],
            'is_user' => true,
            'chat_id' => $this->selectedChat->id
        ]);

        $this->messageHistory = $this->selectedChat->refresh()->messages;
        $this->isAiResponding = true;
        ProcessAiResponse::dispatch($this->selectedChat->id, $validated['prompt']);
        $this->prompt = '';
    }

    public function checkAiResponse()
    {
        if (!$this->isAiResponding) return;

        $this->messageHistory = $this->selectedChat->refresh()->messages;

        if ($this->messageHistory->last()?->is_user === false) {
            $this->isAiResponding = false;
        }
    }

    public function render()
    {
        return view('livewire.chat-component');
    }
}
