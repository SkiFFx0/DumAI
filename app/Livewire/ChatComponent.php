<?php

namespace App\Livewire;

use App\Jobs\ProcessAiResponse;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class ChatComponent extends Component
{
    use WithFileUploads;

    public $logoPath = 'images/logo.png';
    public $sidebarOpen = true;
    public $selectedChat = null;
    public $chats;
    public $showSettingsModal = false;
    public $messageHistory;
    public $prompt;
    public $isAiResponding = false;
    public $activeTab = 'profile';
    public $avatar;
    public $name;
    public $email;
    public $password;
    public $agentPrompt;
    public $temperature;
    public $modalName;
    public $modalEmail;
    public $modalPassword;
    public $modalAgentPrompt;
    public $modalTemperature;
    public $modalAvatar;

    public function mount()
    {
        if (Auth::id() === null)
        {
            return redirect()->route('login');
        }

        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->agentPrompt = Auth::user()->agent_prompt ?? 'You are a helpful assistant.';
        $this->temperature = Auth::user()->temperature ?? 0;

        $this->loadChats();

        $selectedChatId = session('selectedChatId');
        if ($selectedChatId)
        {
            $this->selectChat($selectedChatId);
        }
    }

    protected function loadChats()
    {
        $this->chats = Chat::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        if ($this->chats->isNotEmpty() && !$this->selectedChat)
        {
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
        session(['selectedChatId' => null]);
    }

    public function selectChat($chatId)
    {
        $this->selectedChat = Chat::with('messages')
            ->where('user_id', Auth::id())
            ->findOrFail($chatId);

        $this->messageHistory = $this->selectedChat->messages;
        session(['selectedChatId' => $chatId]);
    }

    public function toggleSettingsModal()
    {
        $this->showSettingsModal = !$this->showSettingsModal;
        if ($this->showSettingsModal)
        {
            $this->modalName = $this->name;
            $this->modalEmail = $this->email;
            $this->modalAgentPrompt = $this->agentPrompt;
            $this->modalTemperature = $this->temperature;
            $this->modalPassword = null;
            $this->modalAvatar = null;
        }
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
            'prompt' => 'required|string|max:2000',
            'modalAvatar' => 'nullable|image|max:10240',
            'modalName' => 'required|string|max:255',
            'modalEmail' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'modalPassword' => 'nullable|string|min:8',
            'modalAgentPrompt' => 'nullable|string|max:50',
            'modalTemperature' => 'required|numeric|min:0|max:1',
        ];
    }

    public function saveSettings()
    {
        $this->validate([
            'modalName' => 'required|string|max:255',
            'modalEmail' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'modalPassword' => 'nullable|string|min:8',
            'modalAgentPrompt' => 'nullable|string|max:50',
            'modalTemperature' => 'required|numeric|min:0|max:1',
            'modalAvatar' => 'nullable|image|max:10240',
        ]);

        $user = Auth::user();

        if ($this->modalAvatar)
        {
            $path = $this->modalAvatar->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->name = $this->modalName;
        $user->email = $this->modalEmail;
        if ($this->modalPassword)
        {
            $user->password = bcrypt($this->modalPassword);
        }
        $user->agent_prompt = $this->modalAgentPrompt;
        $user->temperature = $this->modalTemperature;

        $user->save();

        $this->name = $this->modalName;
        $this->email = $this->modalEmail;
        $this->agentPrompt = $this->modalAgentPrompt;
        $this->temperature = $this->modalTemperature;

        $this->showSettingsModal = false;
        $this->reset('modalAvatar', 'modalPassword');
    }

    public function sendMessage()
    {
        $this->validateOnly('prompt');

        if (!$this->selectedChat)
        {
            $this->selectedChat = Chat::create([
                'title' => $this->prompt,
                'user_id' => Auth::id()
            ]);
            $this->chats->prepend($this->selectedChat);
        }

        Message::create([
            'content' => $this->prompt,
            'is_user' => true,
            'chat_id' => $this->selectedChat->id
        ]);

        $this->messageHistory = $this->selectedChat->refresh()->messages;
        $this->isAiResponding = true;
        ProcessAiResponse::dispatch($this->selectedChat->id, $this->prompt);
        $this->prompt = '';
    }

    public function checkAiResponse()
    {
        if (!$this->isAiResponding) return;

        if ($this->selectedChat !== null)
        {
            $this->selectedChat->load('messages');
            $this->messageHistory = $this->selectedChat->messages;

            if ($this->messageHistory->last()?->is_user === false)
            {
                $this->isAiResponding = false;
            }
        }
    }

    public function render()
    {
        return view('livewire.chat-component');
    }
}
