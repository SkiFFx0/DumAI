<div class="min-h-screen bg-gray-900 flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-gray-800 rounded-lg shadow-lg p-8 space-y-6">
        <h2 class="text-3xl font-bold text-center text-purple-400">Sign up</h2>

        <form wire:submit="register" class="space-y-6">
            @csrf
            <div>
                <label class="block text-gray-300 mb-2">Name</label>
                <input type="text" wire:model="name"
                       class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white
                              focus:border-purple-500 focus:ring-2 focus:ring-purple-500">
                @error('name') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-gray-300 mb-2">Email</label>
                <input type="email" wire:model="email"
                       class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white
                              focus:border-purple-500 focus:ring-2 focus:ring-purple-500">
                @error('email') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-gray-300 mb-2">Password</label>
                <input type="password" wire:model="password"
                       class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white
                              focus:border-purple-500 focus:ring-2 focus:ring-purple-500">
                @error('password') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-gray-300 mb-2">Confirm Password</label>
                <input type="password" wire:model="password_confirmation"
                       class="w-full px-4 py-2 bg-gray-700 border border-gray-600 rounded-lg text-white
                              focus:border-purple-500 focus:ring-2 focus:ring-purple-500">
            </div>

            <button type="submit"
                    class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg
                           transition-colors duration-200">
                Create Account
            </button>
        </form>

        <p class="text-gray-400 text-center">
            Already have an account?
            <a href="{{ route('login') }}" class="text-purple-400 hover:text-purple-300">Sign in!</a>
        </p>
    </div>
</div>
