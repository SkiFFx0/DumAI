<div class="w-full lg:w-1/2 flex items-center justify-center p-4 lg:p-12 animate-fade-in">
    <div class="w-full max-w-md bg-gray-800 rounded-xl shadow-2xl p-8 space-y-6 border border-gray-700">
        <div class="flex justify-center lg:hidden mb-8">
            <img src="{{ $logoPath }}" alt="DumAI Logo" class="w-12 h-12 logo-circle object-cover">
        </div>

        <h2 class="text-3xl font-bold text-center text-purple-400">Create Account</h2>
        <p class="text-center text-gray-400">Start your journey with DumAI</p>

        <form wire:submit="register" class="space-y-6">
            @csrf
            <div class="space-y-4">
                <div class="animate-fade-in-up delay-100">
                    <label class="block text-gray-300 mb-2 text-sm font-medium">Full Name</label>
                    <input type="text" wire:model="name"
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white
                                  focus:border-purple-500 focus:ring-2 focus:ring-purple-500 transition-all
                                  placeholder-gray-500"
                           placeholder="John Doe">
                    @error('name') <span class="text-red-400 text-sm block mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="animate-fade-in-up delay-150">
                    <label class="block text-gray-300 mb-2 text-sm font-medium">Email</label>
                    <input type="email" wire:model="email"
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white
                                  focus:border-purple-500 focus:ring-2 focus:ring-purple-500 transition-all
                                  placeholder-gray-500"
                           placeholder="your@email.com">
                    @error('email') <span class="text-red-400 text-sm block mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="animate-fade-in-up delay-200">
                    <label class="block text-gray-300 mb-2 text-sm font-medium">Password</label>
                    <input type="password" wire:model="password"
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white
                                  focus:border-purple-500 focus:ring-2 focus:ring-purple-500 transition-all
                                  placeholder-gray-500"
                           placeholder="••••••••">
                    @error('password') <span class="text-red-400 text-sm block mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="animate-fade-in-up delay-250">
                    <label class="block text-gray-300 mb-2 text-sm font-medium">Confirm Password</label>
                    <input type="password" wire:model="password_confirmation"
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg text-white
                                  focus:border-purple-500 focus:ring-2 focus:ring-purple-500 transition-all
                                  placeholder-gray-500"
                           placeholder="••••••••">
                </div>
            </div>

            <button type="submit"
                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-lg
                           transition-all duration-200 transform hover:scale-[1.01] shadow-lg
                           flex items-center justify-center space-x-2 animate-fade-in-up delay-300">
                <span>Create Account</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z"
                          clip-rule="evenodd"/>
                </svg>
            </button>
        </form>

        <div class="text-center text-gray-400 animate-fade-in-up delay-350">
            Already have an account?
            <a href="{{ route('login') }}"
               class="text-purple-400 hover:text-purple-300 font-medium ml-1 transition-colors">
                Sign in
            </a>
        </div>
    </div>
</div>
