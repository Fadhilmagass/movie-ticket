<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="relative mt-3">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full rounded-lg pr-10" type="password" name="password"
                required autocomplete="current-password" />
            <button type="button" onclick="togglePassword()"
                class="absolute inset-y-0 right-3 top-8 flex items-center text-gray-500 dark:text-gray-300">
                <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm-9.88 1.53C6.22 15.75 8.94 18 12 18s5.78-2.25 6.88-4.47a1 1 0 00-1.76-.96C16.1 14.36 14.28 16 12 16s-4.1-1.64-5.12-3.43a1 1 0 00-1.76.96z" />
                </svg>
            </button>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    {{-- Register Link --}}
    <div class="text-center mt-6">
        <span class="text-sm text-gray-700 dark:text-gray-400">
            {{ __("Don't hava an account?") }}
            <a href="{{ route('register') }}"
                class="text-indigo-600 dark:text-indigo-400 font-semibold hover:underline">
                {{ __('Register here') }}
            </a>
        </span>
    </div>

    <!-- OR Divider -->
    <div class="flex items-center my-4">
        <hr class="flex-grow border-gray-300 dark:border-gray-600">
        <span class="px-2 text-gray-500 dark:text-gray-400 text-sm">OR</span>
        <hr class="flex-grow border-gray-300 dark:border-gray-600">
    </div>

    {{-- Social Media Login --}}
    <div class="flex items-center justify-center mt-4">
        <a href="{{ route('login.google') }}" class="btn btn-google">
            <img src="https://lh3.googleusercontent.com/COxitqgJr1sJnIDe8-jiKhxDx1FrYbtRHKJ9z_hELisAlapwE9LUPh6fcXIfb5vwpbMl4xl9H9TRFPc5NOO8Sb3VSgIBrfRYvW6cUA"
                alt="Google Logo" class="w-8 h-8 mr-2">
        </a>
    </div>

    {{-- Toogle Password Script --}}
    <script>
        function togglePassword() {
            const passwordField = document.getElementById("password");
            const eyeIcon = document.getElementById("eye-icon");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                eyeIcon.innerHTML =
                    `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5C7.03 4.5 2.7 7.61 1 12c1.7 4.39 6.03 7.5 11 7.5s9.3-3.11 11-7.5c-1.7-4.39-6.03-7.5-11-7.5zm0 11a4 4 0 110-8 4 4 0 010 8z"/>`;
            } else {
                passwordField.type = "password";
                eyeIcon.innerHTML =
                    `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm-9.88 1.53C6.22 15.75 8.94 18 12 18s5.78-2.25 6.88-4.47a1 1 0 00-1.76-.96C16.1 14.36 14.28 16 12 16s-4.1-1.64-5.12-3.43a1 1 0 00-1.76.96z"/>`;
            }
        }
    </script>
</x-guest-layout>
