<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Proxy') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="max-w-7xl mx-auto flex gap-10 px-4 sm:px-6 lg:px-8">
                <div class="flex-1 max-w-xl">
                    <form method="POST" action="{{ route('proxies.store') }}">
                        @csrf

                        {{-- IP --}}
                        <div class="mb-4">
                            <label for="ip" class="block font-medium text-sm text-gray-700 dark:text-gray-300">IP Address</label>
                            <input id="ip" name="ip" type="text" value="{{ old('ip') }}" required autofocus
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('ip')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Port --}}
                        <div class="mb-4">
                            <label for="port" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Port</label>
                            <input id="port" name="port" type="text" value="{{ old('port') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('port')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Type --}}
                        <div class="mb-4">
                            <label for="type" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Proxy Type</label>
                            <input id="type" name="type" type="text" value="{{ old('type') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('type')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Username --}}
                        <div class="mb-4">
                            <label for="username" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Username</label>
                            <input id="username" name="username" type="text" value="{{ old('username') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('username')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="mb-6">
                            <label for="password" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Password</label>
                            <input id="password" name="password" type="password" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('password')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                Create Proxy
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Rules Section --}}
                <div class="flex-1 max-w-xl text-gray-700 dark:text-gray-300">
                    <h3 class="text-2xl font-semibold mb-6 border-b-2 border-indigo-600 pb-2">Proxy Info Guidelines</h3>
                    <ul class="space-y-5">
                        <li class="flex items-start space-x-3">
                            <x-icon-check />
                            <span class="text-base leading-relaxed">
                                IP must be <strong>valid</strong> (e.g. 192.168.1.1)
                            </span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <x-icon-check />
                            <span class="text-base leading-relaxed">
                                Port should be <strong>numeric</strong> and within valid range.
                            </span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <x-icon-check />
                            <span class="text-base leading-relaxed">
                                Type can be <strong>HTTP / SOCKS5</strong>, etc.
                            </span>
                        </li>
                        <li class="flex items-start space-x-3">
                            <x-icon-check />
                            <span class="text-base leading-relaxed">
                                Provide <strong>correct authentication</strong> if needed.
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
