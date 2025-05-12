<?php

namespace App\Livewire;

use App\Models\ChatHistory;
use App\Models\MessageHistory;
use Livewire\Component;

class Chat extends Component
{
    // [1] Component Properties
    public $message = '';          // Holds current message input
    public $sidebarOpen = true;    // Controls sidebar visibility
    public $selectedChat = null;   // Currently active chat
    public $chats = [];            // List of user's chats
    public $messages = [];         // Messages in selected chat
    public string $logoPath = 'images/DumAI-logo.png';

    // [2] Initial component setup
    public function mount()
    {
        // Add logic to load user's chat history
        // Example: $this->chats = ChatHistory::where(...)->get();
    }

    // [3] Chat selection handler
    public function selectChat($chatId)
    {
        // Add logic to load messages for selected chat
        // Example: $this->messages = MessageHistory::where(...)->get();
    }

    // [4] Sidebar toggle
    public function toggleSidebar()
    {
        $this->sidebarOpen = !$this->sidebarOpen;
    }

    // [5] Message sending handler
    public function sendMessage()
    {
        // Add validation: $this->validate([...]);

        // Add logic for:
        // - Creating new chat if none selected
        // - Saving user message
        // - Getting AI response
        // - Saving AI response
        // - Refreshing messages list

        $this->reset('message');
    }

    // [6] Create new chat button
    public function createNewChat()
    {
//        $this->selectedChat = null;
//        $this->message = '';
//        $this->chats = ChatHistory::where('user_id', Auth::id())
//            ->orderByDesc('created_at')
//            ->get();
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
