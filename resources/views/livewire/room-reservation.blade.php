<div>
    <form wire:submit.prevent="reserve" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 dark:bg-gray-800">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-white" for="guest_name">
                {{ __('messages.guest_name') }}
            </label>
            <input wire:model="guest_name"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:bg-gray-700"
                id="guest_name" type="text" required>
            @error('guest_name')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-white" for="guest_email">
                {{ __('messages.guest_email') }}
            </label>
            <input wire:model="guest_email"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:bg-gray-700"
                id="guest_email" type="email" required>
            @error('guest_email')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4 mt-4">
            <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-white">
            </label>
            <div class="flex space-x-4">
                <div wire:ignore class="w-1/2">
                    <input x-data x-init="flatpickr($el, {
                        enableTime: false,
                        dateFormat: 'Y-m-d',
                        minDate: 'today',
                        disable: {{ json_encode($unavailableDates) }},
                        defaultDate: '{{ $check_in }}',
                        onChange: function(selectedDates, dateStr) {
                            @this.set('check_in', dateStr)
                        },
                        // ... reszta konfiguracji
                    })" type="text"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700"
                        placeholder="{{ __('messages.check_in') }}"
                        value="{{ $check_in }}">
                </div>
                <div wire:ignore class="w-1/2">
                    <input x-data x-init="flatpickr($el, {
                        enableTime: false,
                        dateFormat: 'Y-m-d',
                        minDate: 'today',
                        disable: {{ json_encode($unavailableDates) }},
                        defaultDate: '{{ $check_out }}',
                        onChange: function(selectedDates, dateStr) {
                            @this.set('check_out', dateStr)
                        },
                        // ... reszta konfiguracji
                    })" type="text"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700"
                        placeholder="{{ __('messages.check_out') }}"
                        value="{{ $check_out }}">
                </div>
            </div>
            @error('check_in')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
            @error('check_out')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-white">
                {{ __('messages.guests') }}
            </label>
            
            <div class="space-y-4">
                <!-- Dorośli -->
                <div class="flex items-center justify-between p-4 border rounded dark:border-gray-600">
                    <div>
                        <span class="font-bold dark:text-white">{{ __('messages.adults') }}</span>
                        <span class="text-sm text-gray-600 dark:text-gray-400">(19-74 lat)</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button type="button" wire:click="removeGuest('adults')" class="bg-red-500 hover:bg-red-600 text-white w-8 h-8 rounded-full">
                            -
                        </button>
                        <span class="w-8 text-center dark:text-white">{{ $guests['adults'] }}</span>
                        <button type="button" wire:click="addGuest('adults')" class="bg-green-500 hover:bg-green-600 text-white w-8 h-8 rounded-full">
                            +
                        </button>
                    </div>
                </div>
        
                <!-- Nastolatkowie -->
                <div class="flex items-center justify-between p-4 border rounded dark:border-gray-600">
                    <div>
                        <span class="font-bold dark:text-white">{{ __('messages.teenagers') }}</span>
                        <span class="text-sm text-gray-600 dark:text-gray-400">(13-18 lat)</span>
                        <span class="text-green-600">-20%</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button type="button" wire:click="removeGuest('teenagers')" class="bg-red-500 hover:bg-red-600 text-white w-8 h-8 rounded-full">
                            -
                        </button>
                        <span class="w-8 text-center dark:text-white">{{ $guests['teenagers'] }}</span>
                        <button type="button" wire:click="addGuest('teenagers')" class="bg-green-500 hover:bg-green-600 text-white w-8 h-8 rounded-full">
                            +
                        </button>
                    </div>
                </div>
        
                <!-- Dzieci -->
                <div class="flex items-center justify-between p-4 border rounded dark:border-gray-600">
                    <div>
                        <span class="font-bold dark:text-white">{{ __('messages.children') }}</span>
                        <span class="text-sm text-gray-600 dark:text-gray-400">(4-12 lat)</span>
                        <span class="text-green-600">-50%</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button type="button" wire:click="removeGuest('children')" class="bg-red-500 hover:bg-red-600 text-white w-8 h-8 rounded-full">
                            -
                        </button>
                        <span class="w-8 text-center dark:text-white">{{ $guests['children'] }}</span>
                        <button type="button" wire:click="addGuest('children')" class="bg-green-500 hover:bg-green-600 text-white w-8 h-8 rounded-full">
                            +
                        </button>
                    </div>
                </div>
        
                <!-- Niemowlęta -->
                <div class="flex items-center justify-between p-4 border rounded dark:border-gray-600">
                    <div>
                        <span class="font-bold dark:text-white">{{ __('messages.infants') }}</span>
                        <span class="text-sm text-gray-600 dark:text-gray-400">(0-3 lat)</span>
                        <span class="text-green-600">{{ __('messages.for_free') }}</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button type="button" wire:click="removeGuest('infants')" class="bg-red-500 hover:bg-red-600 text-white w-8 h-8 rounded-full">
                            -
                        </button>
                        <span class="w-8 text-center dark:text-white">{{ $guests['infants'] }}</span>
                        <button type="button" wire:click="addGuest('infants')" class="bg-green-500 hover:bg-green-600 text-white w-8 h-8 rounded-full">
                            +
                        </button>
                    </div>
                </div>
        
                <!-- Seniorzy -->
                <div class="flex items-center justify-between p-4 border rounded dark:border-gray-600">
                    <div>
                        <span class="font-bold dark:text-white">{{ __('messages.seniors') }}</span>
                        <span class="text-sm text-gray-600 dark:text-gray-400">(75+ lat)</span>
                        <span class="text-green-600">-35%</span>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button type="button" wire:click="removeGuest('seniors')" class="bg-red-500 hover:bg-red-600 text-white w-8 h-8 rounded-full">
                            -
                        </button>
                        <span class="w-8 text-center dark:text-white">{{ $guests['seniors'] }}</span>
                        <button type="button" wire:click="addGuest('seniors')" class="bg-green-500 hover:bg-green-600 text-white w-8 h-8 rounded-full">
                            +
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        @if (session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="mb-6">
            <p class="text-lg font-bold">{{ __('messages.total_price') }}: {{ number_format($total_price, 2) }} PLN
            </p>
        </div>

        <div class="flex items-center justify-between">
            <button
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                type="submit">
                {{ __('messages.reserve') }}
            </button>
        </div>
    </form>
</div>
