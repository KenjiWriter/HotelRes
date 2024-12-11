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

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-white">
                {{ __('messages.select_dates') }}
            </label>
            <div class="flex space-x-4">
                <div wire:ignore class="w-1/2">
                    <input x-data x-init="flatpickr($el, {
                        enableTime: false,
                        dateFormat: 'Y-m-d',
                        minDate: 'today',
                        disable: {{ json_encode($unavailableDates) }},
                        onChange: function(selectedDates, dateStr) {
                            @this.set('check_in', dateStr)
                        },
                        theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',
                        onReady: function(selectedDates, dateStr, instance) {
                            const observer = new MutationObserver((mutations) => {
                                mutations.forEach((mutation) => {
                                    if (mutation.attributeName === 'class') {
                                        const isDark = document.documentElement.classList.contains('dark');
                                        instance.set('theme', isDark ? 'dark' : 'light');
                                    }
                                });
                            });
                    
                            observer.observe(document.documentElement, {
                                attributes: true
                            });
                        }
                    })" type="text"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700"
                        placeholder="{{ __('messages.check_in') }}">
                </div>
                <div wire:ignore class="w-1/2">
                    <input x-data x-init="flatpickr($el, {
                        enableTime: false,
                        dateFormat: 'Y-m-d',
                        minDate: 'today',
                        disable: {{ json_encode($unavailableDates) }},
                        onChange: function(selectedDates, dateStr) {
                            @this.set('check_out', dateStr)
                        },
                        theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light',
                        onReady: function(selectedDates, dateStr, instance) {
                            const observer = new MutationObserver((mutations) => {
                                mutations.forEach((mutation) => {
                                    if (mutation.attributeName === 'class') {
                                        const isDark = document.documentElement.classList.contains('dark');
                                        instance.set('theme', isDark ? 'dark' : 'light');
                                    }
                                });
                            });
                    
                            observer.observe(document.documentElement, {
                                attributes: true
                            });
                        }
                    })" type="text"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700"
                        placeholder="{{ __('messages.check_out') }}">
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
            <label class="block text-gray-700 text-sm font-bold mb-2 dark:text-white" for="guests_number">
                {{ __('messages.guests_number') }}
            </label>
            <input wire:model="guests_number"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline dark:text-gray-300 dark:bg-gray-700"
                id="guests_number" type="number" min="1" max="{{ $room->capacity }}" required>
            @error('guests_number')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>

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
