<div class="h-screen bg-gray-900 flex" x-data>
    <!-- Left Panel - Chat History -->
    <div class="bg-gray-800 border-r border-gray-700 flex flex-col transition-all duration-300"
         :class="$wire.sidebarOpen ? 'w-64' : 'w-16'">

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
        <div class="flex-1 overflow-y-auto p-2 space-y-1">
            <!-- Loop through $chats -->
            @foreach($chats as $chat)
                <!-- Add chat item button with wire:click="selectChat() -->
                <!-- Show chat title when expanded, bullet when collapsed -->
            @endforeach
        </div>
    </div>

    <!-- Main Chat Area -->
    <div class="flex-1 flex flex-col">
        <!-- Messages Container -->
        <div class="flex-1 overflow-y-auto p-6">
            <div class="mx-auto max-w-4xl space-y-6">
                @if($selectedChat)
                    <!-- Loop through $messages -->
                    @foreach($messages as $message)
                        @if($message->is_user)
                            <!-- User Message Layout -->
                            <!-- Right-aligned, purple background -->
                        @else
                            <!-- AI Message Layout -->
                            <!-- Left-aligned, gray background -->
                        @endif
                    @endforeach
                @else
                    <!-- Empty state - no chat selected -->
                @endif
            </div>
        </div>

        <!-- Input Area -->
        <div class="p-6">
            <div class="mx-auto max-w-4xl relative">
                <form wire:submit.prevent="sendMessage">
                    <!-- Message input field -->
                    <!-- Use textarea for multi-line input -->
                    <!-- Add send button with icon -->
                </form>
            </div>
        </div>
    </div>
</div>
