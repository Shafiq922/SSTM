<x-guest-layout>
    <div class="flex flex-col md:flex-row w-full h-screen">
        <!-- Left Side: Registration Form -->
        <section class="w-full md:w-1/2 flex items-center justify-center px-8 py-10 bg-white overflow-y-auto">
            <div class="w-full max-w-md space-y-6">
                <!-- Logo + Title -->
                <div class="flex items-center space-x-2 mb-4">
                    <div class="flex items-center justify-center w-8 h-8 bg-teal-600 text-white font-bold rounded">T
                    </div>
                    <h1 class="text-2xl font-extrabold tracking-tight text-gray-900">
                        MyTicket+ <span class="font-semibold">Portal</span>
                    </h1>
                </div>

                <h2 class="text-lg font-semibold text-gray-900">Create Account</h2>
                <p class="text-sm text-gray-600 mb-4">Register to get started with your dashboard</p>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <div class="relative mt-1">
                            <x-text-input id="name"
                                class="block w-full px-3 py-2 !bg-gray-100 !border-gray-300 !text-gray-900 text-sm rounded-md focus:!ring-teal-500 focus:!border-teal-500"
                                type="text" name="name" :value="old('name')" required autofocus
                                placeholder="Enter your full name" autocomplete="name" />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <div class="relative mt-1">
                            <x-text-input id="email"
                                class="block w-full px-3 py-2 !bg-gray-100 !border-gray-300 !text-gray-900 text-sm rounded-md focus:!ring-teal-500 focus:!border-teal-500"
                                type="email" name="email" :value="old('email')" required placeholder="Enter your email"
                                autocomplete="username" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <x-input-label for="user_phone" :value="__('Phone Number')" />
                        <div class="relative mt-1">
                            <x-text-input id="user_phone"
                                class="block w-full px-3 py-2 !bg-gray-100 !border-gray-300 !text-gray-900 text-sm rounded-md focus:!ring-teal-500 focus:!border-teal-500"
                                type="text" name="user_phone" :value="old('user_phone')" required
                                placeholder="Enter your phone number" autocomplete="tel" />
                        </div>
                        <x-input-error :messages="$errors->get('user_phone')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div x-data="{ show: false }">
                        <x-input-label for="password" :value="__('Password')" />
                        <div class="relative mt-1">
                            <x-text-input id="password"
                                class="block w-full pl-3 pr-10 py-2 !bg-gray-100 !border-gray-300 !text-gray-900 text-sm rounded-md focus:!ring-teal-500 focus:!border-teal-500"
                                ::type="show ? 'text' : 'password'" name="password" required
                                placeholder="Create a password" autocomplete="new-password" />
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
                    </div>

                    <!-- Confirm Password -->
                    <div x-data="{ show: false }">
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <div class="relative mt-1">
                            <x-text-input id="password_confirmation"
                                class="block w-full pl-3 pr-10 py-2 !bg-gray-100 !border-gray-300 !text-gray-900 text-sm rounded-md focus:!ring-teal-500 focus:!border-teal-500"
                                ::type="show ? 'text' : 'password'" name="password_confirmation" required
                                placeholder="Confirm your password" autocomplete="new-password" />
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
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Role -->
                    <div>
                        <x-input-label for="roleID" :value="__('Role')" />
                        <div class="relative mt-1">
                            <select id="roleID" name="roleID"
                                class="block w-full px-3 py-2 !bg-gray-100 !border-gray-300 !text-gray-900 text-sm rounded-md focus:!ring-teal-500 focus:!border-teal-500"
                                required>
                                <option value="" disabled selected>{{ __('Select your role') }}</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->roleID }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-input-error :messages="$errors->get('roleID')" class="mt-2" />
                    </div>

                    <!-- Department -->
                    <div>
                        <x-input-label for="departmentID" :value="__('Department')" />
                        <div class="relative mt-1">
                            <select id="departmentID" name="departmentID"
                                class="block w-full px-3 py-2 !bg-gray-100 !border-gray-300 !text-gray-900 text-sm rounded-md focus:!ring-teal-500 focus:!border-teal-500"
                                required>
                                <option value="" disabled selected>{{ __('Select your department') }}</option>
                                @foreach($departments as $department)
                                    <option value="{{ $department->departmentID }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-input-error :messages="$errors->get('departmentID')" class="mt-2" />
                    </div>

                    <!-- Register Button -->
                    <div class="mt-6">
                        <x-primary-button
                            class="w-full justify-center bg-teal-600 hover:bg-teal-700 focus:ring-teal-300 text-white font-semibold px-5 py-2.5 rounded-md">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>

                    <!-- Already Registered -->
                    <div class="flex items-center justify-center mt-4">
                        <span class="text-sm text-gray-600">Already registered? </span>
                        <a class="ml-1 text-sm text-teal-600 hover:underline font-medium" href="{{ route('login') }}">
                            {{ __('Sign in') }}
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
                <div class="pt-8 grid grid-cols-2 gap-4">
                    <!-- Example badges/icons to match the vibe (Optional, keeping simple text for now) -->
                </div>
            </div>
        </section>
    </div>
</x-guest-layout>