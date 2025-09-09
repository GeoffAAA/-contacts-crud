<x-guest-layout>
    <div class="flex flex-col items-center justify-center bg-gradient-to-br from-indigo-50 via-sky-50 to-emerald-50 p-2 sm:p-6">
        <!-- App Title at the top, outside the login container -->
        <header class="mt-4 sm:mt-8 mb-6 sm:mb-12">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-800 text-center">
                Contacts Dashboard
            </h1>
            <p class="text-sm sm:text-base text-gray-600 text-center mt-2">
                Manage your contacts with ease
            </p>
        </header>
        
        <div class="w-full max-w-sm sm:max-w-md bg-white/90 backdrop-blur-md shadow-lg rounded-xl p-4 sm:p-8">
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-6 text-center">
                {{ session('has_visited_before') && !session('fresh_logout') ? 'Welcome Back' : 'Welcome' }}
            </h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4" autocomplete="off" novalidate>
                @csrf

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ session('fresh_logout') ? '' : old('email') }}" required autofocus 
                        autocomplete="off" 
                        autocorrect="off" 
                        autocapitalize="off" 
                        spellcheck="false"
                        class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" required 
                        autocomplete="new-password" 
                        autocorrect="off" 
                        autocapitalize="off" 
                        spellcheck="false"
                        class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Remember / Forgot -->
                <div class="flex items-center justify-between">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="remember" class="rounded border-gray-300">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full bg-indigo-500 text-white py-2 px-4 rounded-lg font-semibold hover:bg-indigo-600 transition">
                    Log in
                </button>
            </form>

            <p class="mt-6 text-center text-gray-600 text-sm">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Register</a>
            </p>
        </div>
    </div>

    <!-- Hidden fake form to prevent browser autofill -->
    <form style="display: none;" autocomplete="off">
        <input type="text" name="fake_username" autocomplete="off">
        <input type="password" name="fake_password" autocomplete="off">
    </form>

    <script>
        // Clear any remaining browser data on page load
        if (typeof(Storage) !== "undefined") {
            try {
                // Clear localStorage
                localStorage.clear();
                // Clear sessionStorage
                sessionStorage.clear();
            } catch(e) {
                // Ignore errors
            }
        }
        
        // Clear form data on page unload
        window.addEventListener('beforeunload', function() {
            document.querySelectorAll('input[type="email"], input[type="password"]').forEach(function(input) {
                input.value = '';
            });
        });
        
        // Additional autofill prevention
        document.addEventListener('DOMContentLoaded', function() {
            // Clear any pre-filled values
            document.querySelectorAll('input[type="email"], input[type="password"]').forEach(function(input) {
                if (input.value && !input.hasAttribute('data-user-entered')) {
                    input.value = '';
                }
            });
            
            // Mark inputs as user-entered when they type
            document.querySelectorAll('input[type="email"], input[type="password"]').forEach(function(input) {
                input.addEventListener('input', function() {
                    this.setAttribute('data-user-entered', 'true');
                });
            });
        });
    </script>
</x-guest-layout>
