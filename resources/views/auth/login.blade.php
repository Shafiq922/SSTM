<x-guest-layout>
    <div class="flex flex-col md:flex-row w-full h-screen">
        <!-- Left Side: Login Form -->
        <section class="w-full md:w-1/2 flex items-center justify-center px-4 sm:px-8 py-10 bg-white">
            <div class="w-full max-w-md space-y-6">
                <!-- Logo + Title -->
                <div class="flex items-center space-x-2 mb-4">
                    <div class="flex items-center justify-center w-8 h-8 bg-teal-600 text-white font-bold rounded">T
                    </div>
                    <h1 class="text-2xl font-extrabold tracking-tight text-gray-900">
                        MyTicket+ <span class="font-semibold">Portal</span>
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
                                <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 20 20" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.003 5.884L10 10.882l7.997-4.998M18 8v8a2 2 0 01-2 2H4a2 2 0 01-2-2V8" />
                                </svg>
                            </div>
                            <x-text-input id="email"
                                class="block w-full pl-10 !bg-gray-100 !border-gray-300 !text-gray-900 text-sm rounded-md focus:!ring-teal-500 focus:!border-teal-500"
                                type="email" name="email" :value="old('email')" required autofocus
                                autocomplete="username" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4" x-data="{ show: false }">
                        <x-input-label for="password" :value="__('Password')" />
                        <div class="relative mt-1">
                            <x-text-input id="password"
                                class="block w-full pr-10 !bg-gray-100 !border-gray-300 !text-gray-900 text-sm rounded-md focus:!ring-teal-500 focus:!border-teal-500"
                                ::type="show ? 'text' : 'password'" name="password" required
                                autocomplete="current-password" />
                            <button type="button"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer z-10"
                                @click="show = !show">
                                <!-- Eye Open (Show) -->
                                <svg x-show="!show" class="w-5 h-5 text-gray-500 hover:text-gray-700"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <!-- Eye Closed (Hide) -->
                                <svg x-show="show" x-cloak class="w-5 h-5 text-gray-500 hover:text-gray-700"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
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

                    <!-- Register Link -->
                    <div class="flex items-center justify-center mt-4">
                        <span class="text-sm text-gray-600">{{ __("Don't have an account?") }}</span>
                        <a class="ml-1 text-sm text-teal-600 hover:underline font-medium"
                            href="{{ route('register') }}">
                            {{ __('Register') }}
                        </a>
                    </div>
                </form>
            </div>
        </section>

        <!-- Right Side: Teal Info Panel -->
        <section class="hidden md:flex w-full md:w-1/2 bg-teal-600 text-white items-center justify-center px-12">
            <div class="max-w-md space-y-4">
                <h2 class="text-3xl font-serif font-semibold leading-snug">
                    Submit tickets. Track progress.
                </h2>
                <p class="text-teal-100 text-sm leading-relaxed">
                    “Smart prioritization for smarter support.”
                </p>
            </div>
        </section>
    </div>

    <!-- Toggle password visibility -->

</x-guest-layout>