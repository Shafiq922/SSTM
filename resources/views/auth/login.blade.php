<x-guest-layout>
    <div class="flex flex-col md:flex-row w-full h-screen">
        <!-- Left Side: Login Form -->
        <section class="w-full md:w-1/2 flex items-center justify-center px-8 py-10 bg-white">
            <div class="w-full max-w-md space-y-6">
                <!-- Logo + Title -->
                <div class="flex items-center space-x-2 mb-4">
                    <div class="flex items-center justify-center w-8 h-8 bg-teal-600 text-white font-bold rounded">T</div>
                    <h1 class="text-2xl font-extrabold tracking-tight text-gray-900">
                        MyTicket+ <span class="font-semibold">Admin Portal</span>
                    </h1>
                </div>

                <h2 class="text-lg font-semibold text-gray-900">Welcome Back!</h2>
                <p class="text-sm text-gray-600 mb-4">Sign in to access your dashboard</p>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.003 5.884L10 10.882l7.997-4.998M18 8v8a2 2 0 01-2 2H4a2 2 0 01-2-2V8" />
                                </svg>
                            </div>
                            <x-text-input id="email"
                                class="block w-full pl-10 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-teal-500 focus:border-teal-500"
                                type="email"
                                name="email"
                                :value="old('email')"
                                required autofocus autocomplete="username" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <div class="relative mt-1">
                            <x-text-input id="password"
                                class="block w-full pr-10 bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-teal-500 focus:border-teal-500"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                            <button type="button" class="absolute inset-y-0 right-0 flex items-center pr-3" onclick="togglePassword()">
                                <svg id="eyeIcon" class="w-5 h-5 text-gray-500 hover:text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        @if (Route::has('password.request'))
                            <div class="text-right mt-2">
                                <a href="{{ route('password.request') }}" class="text-sm text-teal-600 hover:underline">
                                    {{ __('Forgot your password?') }}
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Remember Me -->
                    <div class="block mt-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" name="remember"
                                class="rounded border-gray-300 text-teal-600 shadow-sm focus:ring-teal-500" />
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <!-- Login Button -->
                    <div class="mt-6">
                        <x-primary-button
                            class="w-full justify-center bg-teal-600 hover:bg-teal-700 focus:ring-teal-300 text-white font-semibold px-5 py-2.5 rounded-md">
                            {{ __('Sign in') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Right Side: Teal Info Panel -->
        <section class="hidden md:flex w-full md:w-1/2 bg-teal-600 text-white items-center justify-center px-12">
            <div class="max-w-md space-y-4">
                <h2 class="text-3xl font-serif font-semibold leading-snug">
                    Streamlined Administrative Excellence
                </h2>
                <p class="text-teal-100 text-sm leading-relaxed">
                    “Completely transformed your administrative processes.
                    It’s intuitive, powerful, and keeps your operations running smoothly.”
                </p>
            </div>
        </section>
    </div>

    <!-- Toggle password visibility -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
        }
    </script>
</x-guest-layout>
