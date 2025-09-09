<x-guest-layout>
    <div class="flex flex-col items-center justify-center bg-gradient-to-br from-indigo-50 via-sky-50 to-emerald-50 p-2 sm:p-6">
        <!-- App Title at the top, outside the register container -->
        <header class="mt-4 sm:mt-8 mb-6 sm:mb-12">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-gray-800 text-center">
                Contacts Dashboard
            </h1>
            <p class="text-sm sm:text-base text-gray-600 text-center mt-2">
                Manage your contacts with ease
            </p>
        </header>
        
        <div class="w-full max-w-sm sm:max-w-md bg-white/90 backdrop-blur-md shadow-lg rounded-xl p-4 sm:p-8">
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-6 text-center">Create Account</h2>

            <form method="POST" action="{{ route('register') }}" class="space-y-4" autocomplete="off" novalidate>
                @csrf

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus 
                        autocomplete="off" 
                        autocorrect="off" 
                        autocapitalize="off" 
                        spellcheck="false"
                        class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required 
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

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" required 
                        autocomplete="off" 
                        autocorrect="off" 
                        autocapitalize="off" 
                        spellcheck="false"
                        class="w-full border rounded-lg px-3 py-2 mt-1 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400">
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full bg-indigo-500 text-white py-2 px-4 rounded-lg font-semibold hover:bg-indigo-600 transition">
                    Register
                </button>
            </form>

            <p class="mt-6 text-center text-gray-600 text-sm">
                Already have an account?
                <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">Log in</a>
            </p>
        </div>
    </div>

    <!-- Hidden fake form to prevent browser autofill -->
    <form style="display: none;" autocomplete="off">
        <input type="text" name="fake_username" autocomplete="off">
        <input type="password" name="fake_password" autocomplete="off">
        <input type="password" name="fake_password_confirmation" autocomplete="off">
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
            document.querySelectorAll('input[type="password"]').forEach(function(input) {
                input.value = '';
            });
        });
        
        // Additional autofill prevention
        document.addEventListener('DOMContentLoaded', function() {
            // Clear any pre-filled values
            document.querySelectorAll('input[type="password"]').forEach(function(input) {
                if (input.value && !input.hasAttribute('data-user-entered')) {
                    input.value = '';
                }
            });
            
            // Mark inputs as user-entered when they type
            document.querySelectorAll('input[type="password"]').forEach(function(input) {
                input.addEventListener('input', function() {
                    this.setAttribute('data-user-entered', 'true');
                });
            });
        });
    </script>
</x-guest-layout>
