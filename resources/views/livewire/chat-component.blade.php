<div class="h-screen bg-gray-900 flex" x-data>
    <!-- Left Panel - Chat History -->
    <div class="bg-gray-800 border-r border-gray-700 flex flex-col transition-all duration-300"
         :class="$wire.sidebarOpen ? 'w-60' : 'w-16'">

        <!-- Sidebar Header -->
        <div class="p-4 relative min-h-[70px]">
            <!-- Collapse Button -->
            <button
                wire:click="toggleSidebar"
                class="absolute left-4 top-4 z-10 w-8 h-8 bg-gray-800 border border-gray-700 rounded-full p-1.5 hover:bg-gray-700 transition-colors"
            >
                <svg class="w-full h-full text-white transform transition-transform"
                     :class="$wire.sidebarOpen ? 'rotate-180' : ''"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>

            <!-- Open State Content -->
            <div class="flex items-center gap-3 transition-all duration-300 ml-12"
                 x-show="$wire.sidebarOpen">
                <img
                    src="{{ asset($logoPath) }}"
                    alt="DumAI Logo"
                    class="w-8 h-8 rounded-lg object-contain"
                >
                <h1 class="text-xl font-bold text-purple-400">DumAI</h1>
                <button
                    wire:click="createNewChat"
                    class="ml-auto w-8 h-8 bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors flex items-center justify-center"
                >
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </button>
            </div>

            <!-- Closed State Content -->
            <div class="absolute left-4 top-16 flex flex-col gap-5 transition-all duration-300"
                 x-show="!$wire.sidebarOpen">
                <img
                    src="{{ asset($logoPath) }}"
                    alt="DumAI Logo"
                    class="w-8 h-8 rounded-lg object-contain"
                >
                <button
                    wire:click="createNewChat"
                    class="w-8 h-8 bg-gray-700 hover:bg-gray-600 rounded-lg transition-colors flex items-center justify-center"
                >
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Chat List -->
        <div class="flex-1 overflow-y-auto p-2 space-y-1" x-show="$wire.sidebarOpen">
            @forelse($chats as $chat)
                <div
                    class="flex items-center justify-between w-full p-2 text-gray-300 hover:bg-gray-700 rounded-lg transition-colors {{ $selectedChat?->id === $chat->id ? 'bg-gray-700' : '' }}"
                    wire:key="chat-{{ $chat->id }}">
                    @if($renamingChatId === $chat->id)
                        <input
                            type="text"
                            wire:model="tempTitle"
                            wire:keydown.enter="saveRename"
                            wire:blur="cancelRename"
                            class="flex-1 p-1 bg-gray-700 border border-gray-600 rounded text-gray-100 focus:outline-none focus:border-purple-500"
                            autofocus
                            x-init="$el.select()"
                        >
                    @else
                        <button
                            wire:click="selectChat({{ $chat->id }})"
                            class="flex-1 text-left truncate"
                        >
                            {{ Str::limit($chat->title, 22) }}
                        </button>
                    @endif
                    <div class="relative" x-data="{ open: false }">
                        <button
                            @click="open = !open"
                            class="p-1 hover:bg-gray-600 rounded"
                        >
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                            </svg>
                        </button>
                        <div
                            x-show="open"
                            @click.outside="open = false"
                            class="absolute right-0 mt-2 w-48 bg-gray-800 rounded-md shadow-lg z-20 border border-gray-700"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                        >
                            <div class="py-1">
                                <button
                                    wire:click="renameChat({{ $chat->id }})"
                                    class="w-full px-4 py-2 text-left text-gray-300 hover:bg-gray-700 flex items-center gap-2"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                    Rename
                                </button>
                                <button
                                    wire:click="confirmDelete({{ $chat->id }})"
                                    class="w-full px-4 py-2 text-left text-gray-300 hover:bg-gray-700 flex items-center gap-2"
                                >
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-gray-500 text-center py-4" x-show="$wire.sidebarOpen">
                    No chat history found
                </div>
            @endforelse
        </div>

        <!-- Bottom Buttons -->
        <div class="mt-auto border-t border-gray-700 p-2 space-y-2">
            <!-- Profile Button with Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button
                    @click="open = !open"
                    class="w-full p-2 text-gray-300 hover:bg-gray-700 rounded-lg flex items-center gap-2 transition-colors"
                >
                    <img
                        src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/default-avatar.png') }}"
                        alt="User Avatar"
                        class="w-8 h-8 rounded-full object-cover shrink-0"
                    />
                    <span x-show="$wire.sidebarOpen"> {{ $name }} </span>
                </button>

                <!-- Dropdown Menu -->
                <div
                    x-show="open"
                    @click.outside="open = false"
                    class="absolute bottom-full mb-2 left-0 w-48 bg-gray-800 rounded-md shadow-lg z-20 border border-gray-700"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    x-cloak
                >
                    <div class="py-1">
                        <button
                            wire:click="toggleSettingsModal"
                            class="w-full px-4 py-2 text-left text-gray-300 hover:bg-gray-700 flex items-center gap-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Settings</span>
                        </button>
                        <button
                            wire:click="logout"
                            class="w-full px-4 py-2 text-left text-gray-300 hover:bg-gray-700 flex items-center gap-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span>Logout</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Chat Area -->
    <div class="flex-1 flex flex-col">
        <!-- Messages Container -->
        <div id="messages-container" class="flex-1 overflow-y-auto p-6"
             wire:key="messages-{{ $selectedChat?->id }}"
             @if($isAiResponding) wire:poll.500ms="checkAiResponse" @endif>
            <div class="mx-auto max-w-4xl space-y-6">
                @if($selectedChat)
                    @foreach($messageHistory as $message)
                        @if($message->is_user)
                            <!-- User Message (Right-aligned) -->
                            <div class="flex space-x-4 justify-end">
                                <div class="bg-purple-600 p-4 rounded-lg border border-purple-700 max-w-[85%]">
                                    <p class="text-gray-100 whitespace-pre-wrap">{{ $message->content }}</p>
                                    <span class="text-xs text-purple-300 mt-2 block">
                                        {{ $message->created_at->format('g:i A') }}
                                    </span>
                                </div>
                                <img
                                    src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/default-avatar.png') }}"
                                    alt="User Avatar"
                                    class="w-10 h-10 rounded-full object-cover shrink-0"
                                />
                            </div>
                        @else
                            <!-- AI Message (Left-aligned) -->
                            <div class="flex space-x-4">
                                <img
                                    src="{{ asset($logoPath) }}"
                                    alt="DumAI Logo"
                                    class="w-8 h-8 rounded-lg object-contain"
                                >
                                <div class="bg-gray-800 p-4 rounded-lg border border-gray-700 flex-1">
                                    <p class="text-gray-100 whitespace-pre-wrap">{{ $message->content }}</p>
                                    <span class="text-xs text-gray-500 mt-2 block">
                                        {{ $message->created_at->format('g:i A') }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    @endforeach

                    <!-- AI Loading Indicator -->
                    @if($isAiResponding)
                        <div class="flex space-x-4">
                            <img
                                src="{{ asset($logoPath) }}"
                                alt="DumAI Logo"
                                class="w-8 h-8 rounded-lg object-contain"
                            >
                            <div class="bg-gray-800 p-4 rounded-lg border border-gray-700 flex-1">
                                <div class="flex items-center gap-2">
                                    <div class="animate-pulse">
                                        <div class="flex space-x-1">
                                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"
                                                 style="animation-delay: 0.2s"></div>
                                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"
                                                 style="animation-delay: 0.4s"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="text-center text-gray-400 py-12">
                        Select a chat or start a new conversation
                    </div>
                @endif
            </div>
        </div>

        <!-- Input Area -->
        <div class="border-t border-gray-700 p-6">
            <div class="mx-auto max-w-4xl relative">
                <form wire:submit.prevent="sendMessage">
                    <input
                        wire:model="prompt"
                        placeholder="{{ $selectedChat ? 'Type your message...' : 'Start a new chat' }}"
                        @disabled($isAiResponding)
                        @keydown.enter.prevent="$event.shiftKey || $wire.sendMessage()"
                        class="w-full p-4 pr-12 bg-gray-800 border border-gray-700 rounded-lg text-gray-100
           focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500
           resize-y transition-colors whitespace-pre-wrap
           @if($isAiResponding) opacity-75 @endif"
                    >
                    <button
                        type="submit"
                        @disabled($isAiResponding)
                        class="absolute right-3 bottom-3 p-2 bg-purple-600 hover:bg-purple-700 rounded-lg
                               transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-purple-500
                               @if($isAiResponding) opacity-75 cursor-not-allowed @endif"
                    >
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Settings Modal -->
    @if($showSettingsModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center"
             wire:click="toggleSettingsModal">
            <div class="bg-gray-800 rounded-lg p-6 w-96" wire:click.stop>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-purple-400">Settings</h3>
                    <button wire:click="toggleSettingsModal" class="text-gray-400 hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Tab Navigation -->
                <div class="flex border-b border-gray-700 mb-4">
                    <button
                        wire:click="$set('activeTab', 'profile')"
                        class="px-4 py-2 text-sm font-medium {{ $activeTab === 'profile' ? 'text-purple-400 border-b-2 border-purple-400' : 'text-gray-400' }}"
                    >
                        Profile
                    </button>
                    <button
                        wire:click="$set('activeTab', 'ai-model')"
                        class="px-4 py-2 text-sm font-medium {{ $activeTab === 'ai-model' ? 'text-purple-400 border-b-2 border-purple-400' : 'text-gray-400' }}"
                    >
                        Model
                    </button>
                </div>

                <!-- Tab Content -->
                <div>
                    @if($activeTab === 'profile')
                        <!-- Profile Settings -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-200 mb-4">Profile Settings</h4>
                            <!-- Avatar Upload -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-400 mb-2">Avatar</label>
                                <div class="flex items-center gap-4">
                                    <img
                                        src="{{ $modalAvatar ? $modalAvatar->temporaryUrl() : (Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('images/default-avatar.png')) }}"
                                        alt="Avatar Preview"
                                        class="w-16 h-16 rounded-full object-cover"
                                    >
                                    <input
                                        type="file"
                                        wire:model="modalAvatar"
                                        accept="image/*"
                                        class="text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-600 file:text-white hover:file:bg-purple-700"
                                    >
                                </div>
                                @error('modalAvatar') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <!-- Name -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-400 mb-2">Name</label>
                                <input
                                    type="text"
                                    wire:model="modalName"
                                    class="w-full p-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:outline-none focus:border-purple-500"
                                >
                                @error('modalName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-400 mb-2">Email</label>
                                <input
                                    type="email"
                                    wire:model="modalEmail"
                                    class="w-full p-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:outline-none focus:border-purple-500"
                                >
                                @error('modalEmail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-400 mb-2">New Password (leave blank to
                                    keep current)</label>
                                <input
                                    type="password"
                                    wire:model="modalPassword"
                                    class="w-full p-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:outline-none focus:border-purple-500"
                                >
                                @error('modalPassword') <span
                                    class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    @elseif($activeTab === 'ai-model')
                        <!-- Model Settings -->
                        <div>
                            <h4 class="text-lg font-semibold text-gray-200 mb-4">Model Settings</h4>
                            <!-- Assistant Personality -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-400 mb-2">Assistant
                                    Personality</label>
                                <textarea
                                    wire:model="modalAgentPrompt"
                                    class="w-full p-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:outline-none focus:border-purple-500"
                                    rows="3"
                                ></textarea>
                                @error('modalAgentPrompt') <span
                                    class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <!-- Creativity Level -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-400 mb-2">Creativity Level</label>
                                <select
                                    wire:model="modalTemperature"
                                    class="w-full p-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-100 focus:outline-none focus:border-purple-500"
                                >
                                    <option value="0">Stable</option>
                                    <option value="0.5">Balanced</option>
                                    <option value="1">Creative</option>
                                </select>
                                @error('modalTemperature') <span
                                    class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    @endif
                </div>
                <!-- Unified Save Button -->
                <button
                    wire:click="saveSettings"
                    class="mt-4 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700"
                >
                    Save Settings
                </button>
            </div>
        </div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center"
             wire:click="cancelDelete">
            <div class="bg-gray-800 rounded-lg p-6 w-96" wire:click.stop>
                <h3 class="text-xl font-semibold text-purple-400 mb-4">Delete Chat</h3>
                <p class="text-gray-300 mb-6">Are you sure you want to delete this chat? This action cannot be
                    undone.</p>
                <div class="flex justify-end gap-4">
                    <button
                        wire:click="cancelDelete"
                        class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700"
                    >
                        Cancel
                    </button>
                    <button
                        wire:click="deleteChat"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                    >
                        Delete
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
