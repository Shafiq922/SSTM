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

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <div class="relative mt-1">
                            <x-text-input id="password"
                                class="block w-full px-3 py-2 !bg-gray-100 !border-gray-300 !text-gray-900 text-sm rounded-md focus:!ring-teal-500 focus:!border-teal-500"
                                type="password" name="password" required placeholder="Create a password"
                                autocomplete="new-password" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                        <div class="relative mt-1">
                            <x-text-input id="password_confirmation"
                                class="block w-full px-3 py-2 !bg-gray-100 !border-gray-300 !text-gray-900 text-sm rounded-md focus:!ring-teal-500 focus:!border-teal-500"
                                type="password" name="password_confirmation" required
                                placeholder="Confirm your password" autocomplete="new-password" />
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