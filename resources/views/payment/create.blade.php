<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create Payment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="max-w-7xl mx-auto flex gap-10 px-4 sm:px-6 lg:px-8">
                <div class="flex-1 max-w-xl">
                    <form method="POST" action="{{ route('payment.store') }}">
                        @csrf

                        {{-- Payment ID --}}
                        <div class="mb-4">
                            <label for="payment_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Payment ID</label>
                            <input id="payment_id" name="payment_id" type="text" value="{{ old('payment_id') }}" required autofocus
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('payment_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Number --}}
                        <div class="mb-4">
                            <label for="number" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Number</label>
                            <input id="number" name="number" type="text" value="{{ old('number') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('number')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Amount --}}
                        <div class="mb-4">
                            <label for="amount" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Amount</label>
                            <input id="amount" name="amount" type="number" step="0.01" value="{{ old('amount') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('amount')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Date of Payment --}}
                        <div class="mb-4">
                            <label for="date_of_payment" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Date of Payment</label>
                            <input id="date_of_payment" name="date_of_payment" type="date" value="{{ old('date_of_payment') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('date_of_payment')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Date of Accept --}}
                        <div class="mb-4">
                            <label for="date_of_accept" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Date of Accept</label>
                            <input id="date_of_accept" name="date_of_accept" type="date" value="{{ old('date_of_accept') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('date_of_accept')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="mb-4">
                            <label for="status" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Status</label>
                            <select id="status" name="status" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Select Status --</option>
                                <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="accepted" {{ old('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            @error('status')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Telegram ID --}}
                        <div class="mb-6">
                            <label for="telegram_id" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Telegram ID</label>
                            <input id="telegram_id" name="telegram_id" type="text" value="{{ old('telegram_id') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('telegram_id')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end gap-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                Create Payment
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Info Section --}}
                <div class="flex-1 max-w-xl text-gray-700 dark:text-gray-300">
                    <h3 class="text-2xl font-semibold mb-6 border-b-2 border-indigo-600 pb-2">Payment Guidelines</h3>
                    <ul class="space-y-5 list-disc list-inside">
                        <li>Use a unique Payment ID.</li>
                        <li>Enter the correct number related to the payment.</li>
                        <li>Amount should be a positive number.</li>
                        <li>Dates must be valid and in the correct format.</li>
                        <li>Status should reflect the current payment state.</li>
                        <li>Telegram ID is optional but useful for contact.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
