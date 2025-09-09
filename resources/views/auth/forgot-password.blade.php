<x-guest-layout>
    <div class="flex flex-col items-center justify-center bg-gradient-to-br from-indigo-50 via-sky-50 to-emerald-50 p-2 sm:p-6">
        <!-- App Title at the top, outside the reset container -->
        <header class="mt-4 sm:mt-8 mb-6 sm:mb-12">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-800 text-center">
                Contacts Dashboard
            </h1>
            <p class="text-sm sm:text-base text-gray-600 text-center mt-2">
                Manage your contacts with ease
            </p>
        </header>
        
        <div class="w-full max-w-sm sm:max-w-md bg-white/90 backdrop-blur-md shadow-lg rounded-xl p-4 sm:p-8">
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-6 text-center">Reset Password</h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4" autocomplete="off" novalidate>
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        autocomplete="off" 
                        autocorrect="off" 
                        autocapitalize="off" 
                        spellcheck="false"
                        class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <button type="submit"
                    class="w-full bg-indigo-500 text-white py-2 px-4 rounded-lg font-semibold hover:bg-indigo-600 transition">
                    Send Password Reset Link
                </button>
            </form>

            <p class="mt-6 text-center text-gray-600 text-sm">
                Remembered your password?
                <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Log in</a>
            </p>
        </div>
    </div>
</x-guest-layout>
