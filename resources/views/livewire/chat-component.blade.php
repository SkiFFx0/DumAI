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
                <!-- Logo display -->
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
                <!-- Logo display -->
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
                <button
                    wire:click="selectChat({{ $chat->id }})"
                    class="w-full p-2 text-gray-300 hover:bg-gray-700 rounded-lg cursor-pointer transition-colors truncate
                   {{ $selectedChat?->id === $chat->id ? 'bg-gray-700' : '' }}"
                    :class="$wire.sidebarOpen ? 'px-3' : 'px-2 text-center'"
                >
            <span class="{{ $sidebarOpen ? 'block' : 'hidden' }}">
                {{ Str::limit($chat->title, 22) }}
            </span>
                    <span class="{{ $sidebarOpen ? 'hidden' : 'block' }}">•</span>
                </button>
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
                    <!-- User Avatar Placeholder -->
                    <div class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <span x-show="$wire.sidebarOpen">My Profile</span>
                </button>

                <!-- Dropdown Menu -->
                <div
                    x-show="open"
                    @click.outside="open = false"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute bottom-full mb-2 left-0 w-full bg-gray-800 rounded-md shadow-lg z-10 border border-gray-700"
                    x-cloak
                >
                    <div class="py-1">
                        <button
                            wire:click="toggleSettingsModal"
                            class="w-full px-4 py-2 text-left text-gray-300 hover:bg-gray-700 flex items-center gap-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span>Settings</span>
                        </button>
                        <button
                            wire:click="logout"
                            class="w-full px-4 py-2 text-left text-gray-300 hover:bg-gray-700 flex items-center gap-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
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
        <div class="flex-1 overflow-y-auto p-6"
             wire:key="messages-{{ $selectedChat?->id }}"
             wire:poll.1s="checkAiResponse">
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
                                <!-- User Avatar Placeholder -->
                                <div class="w-10 h-10 bg-gray-700 rounded-lg shrink-0"></div>
                            </div>
                        @else
                            <!-- AI Message (Left-aligned) -->
                            <div class="flex space-x-4">
                                <!-- AI Avatar -->
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
                        class="w-full p-4 pr-12 bg-gray-800 border border-gray-700 rounded-lg text-gray-100
                               focus:outline-none focus:border-purple-500 focus:ring-2 focus:ring-purple-500
                               resize-y transition-colors whitespace-pre-wrap
                               @if($isAiResponding) opacity-75 @endif"
                        @if(!$selectedChat) x-data
                        @keydown.enter.prevent="if($event.shiftKey) return; $wire.sendMessage()" @endif
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
        <div class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
            <div class="bg-gray-800 rounded-lg p-6 w-96">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-purple-400">Settings</h3>
                    <button wire:click="toggleSettingsModal" class="text-gray-400 hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <!-- Empty settings content for now -->
                <div class="text-gray-400 text-center py-8">
                    Settings will be added here
                </div>
            </div>
        </div>
    @endif
</div>
