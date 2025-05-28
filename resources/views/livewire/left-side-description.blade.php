<div class="w-full lg:w-1/2 bg-gradient-to-br from-purple-900 via-purple-800 to-gray-900 p-8 lg:p-12 flex flex-col relative overflow-hidden">
    <!-- Decorative elements -->
    <div class="absolute -right-20 -top-20 w-64 h-64 rounded-full bg-purple-800 opacity-20 blur-xl"></div>
    <div class="absolute left-0 bottom-0 w-32 h-32 rounded-full bg-pink-600 opacity-10 blur-lg"></div>

    <!-- Glowing dots -->
    <div class="absolute right-1/3 top-1/4 w-2 h-2 rounded-full bg-purple-400 animate-pulse"></div>
    <div class="absolute left-1/4 bottom-1/3 w-3 h-3 rounded-full bg-pink-300 opacity-70 animate-pulse delay-300"></div>

    <div class="relative z-10">
        <div class="flex items-center space-x-4 mb-12">
            <div class="relative">
                <!-- Добавлен overflow-hidden и размеры для точного круга -->
                <div class="w-14 h-14 rounded-full overflow-hidden border-2 border-purple-400/30">
                    <img src="{{ $logoPath }}" alt="DumAI Logo"
                         class="w-full h-full object-cover">
                </div>
            </div>
            <span class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-300 via-pink-300 to-purple-400 tracking-tighter">DumAI</span>
        </div>

        <h1 class="text-5xl lg:text-6xl font-bold text-white mb-8 leading-tight animate-fade-in">
            Revolutionize Your Workflow <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-300 to-pink-400">with AI Power</span>
        </h1>

        <div class="space-y-8 text-gray-300 text-lg max-w-2xl">
            <div class="flex items-start space-x-5 animate-fade-in-up delay-100 bg-gradient-to-r from-purple-900/40 to-transparent p-4 rounded-xl backdrop-blur-sm border border-purple-800/30">
                <div class="flex-shrink-0 mt-1 p-2 bg-purple-900/50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-purple-300" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-purple-200 mb-1">Next-Gen AI Conversations</h3>
                    <p class="opacity-90">Harnessing the unparalleled capabilities of Ollama's most advanced AI models,
                        DumAI delivers human-like interactions that understand context, nuance, and complexity with
                        remarkable precision.</p>
                </div>
            </div>

            <div class="flex items-start space-x-5 animate-fade-in-up delay-200 bg-gradient-to-r from-purple-900/40 to-transparent p-4 rounded-xl backdrop-blur-sm border border-purple-800/30">
                <div class="flex-shrink-0 mt-1 p-2 bg-purple-900/50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-purple-300" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-purple-200 mb-1">Cutting-Edge Tech Stack</h3>
                    <p class="opacity-90">Engineered with Laravel's robust backend, Livewire's dynamic frontend
                        interactivity, and TailwindCSS's design flexibility, DumAI offers unparalleled performance and
                        scalability.</p>
                </div>
            </div>

            <div class="flex items-start space-x-5 animate-fade-in-up delay-300 bg-gradient-to-r from-purple-900/40 to-transparent p-4 rounded-xl backdrop-blur-sm border border-purple-800/30">
                <div class="flex-shrink-0 mt-1 p-2 bg-purple-900/50 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-purple-300" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                              d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-purple-200 mb-1">Open-Source Advantage</h3>
                    <p class="opacity-90">As a community-driven PHP solution, DumAI provides complete transparency,
                        endless customization possibilities, and hassle-free deployment for developers worldwide.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-auto pt-8 relative z-10 animate-fade-in-up delay-500">
        <div class="flex items-center space-x-6">
            <a href="https://github.com/SkiFFx0/DumAI" class="text-gray-400 hover:text-white transition-colors duration-300 transform hover:scale-110">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                </svg>
            </a>
        </div>
        <p class="text-gray-500/80 text-sm mt-4">© 2025 DumAI Technologies. All intellectual property rights reserved.
            <br> Revolutionizing human-AI interaction since 2025.</p>
    </div>
</div>
