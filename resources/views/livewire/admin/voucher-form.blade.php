<div class="max-w-3xl mx-auto">
    <form wire:submit.prevent="save" class="space-y-6">
        <div class="bg-white dark:bg-gray-800 shadow px-4 py-5 sm:rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">
                        Podstawowe informacje
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Podstawowe informacje o voucherze
                    </p>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2 space-y-4">
                    <div class="flex items-center space-x-4">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Kod vouchera
                            </label>
                            <input type="text" wire:model="voucher.code"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm">
                            @error('voucher.code')
                                <span class="text-red-500 dark:text-red-400 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="button" wire:click="generateCode"
                            class="mt-6 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 font-bold py-2 px-4 rounded">
                            Generuj kod
                        </button>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Typ rabatu
                            </label>
                            <select wire:model="voucher.discount_type"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm">
                                <option value="percentage">Procentowy</option>
                                <option value="fixed">Kwotowy</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Wartość rabatu
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="number" step="0.01" wire:model="voucher.discount_value"
                                    class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400 sm:text-sm">
                                        {{ $voucher->discount_type === 'percentage' ? '%' : 'zł' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow px-4 py-5 sm:rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">
                        Ograniczenia
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Ustaw ograniczenia dla vouchera
                    </p>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Limit użyć
                        </label>
                        <input type="number" wire:model="voucher.usage_limit"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm"
                            placeholder="Pozostaw puste dla braku limitu">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Email (opcjonalnie)
                        </label>
                        <input type="email" wire:model="voucher.email"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm"
                            placeholder="Pozostaw puste dla vouchera ogólnego">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Ważny od
                            </label>
                            <input type="datetime-local" wire:model="voucher.valid_from"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('voucher.valid_from') border-red-500 @enderror">
                            @error('voucher.valid_from')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Ważny do
                            </label>
                            <input type="datetime-local" wire:model="voucher.valid_until"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 @error('voucher.valid_until') border-red-500 @enderror">
                            @error('voucher.valid_until')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Minimalna wartość zamówienia
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="number" step="0.01" wire:model="voucher.minimum_order_value"
                                    class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400 sm:text-sm">zł</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Maksymalny rabat
                            </label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="number" step="0.01" wire:model="voucher.maximum_discount"
                                    class="block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 dark:text-gray-400 sm:text-sm">zł</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow px-4 py-5 sm:rounded-lg sm:p-6">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">
                        Dodatkowe informacje
                    </h3>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Opis (widoczny tylko dla administratora)
                        </label>
                        <textarea wire:model="voucher.description" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <a href="{{ route('admin.vouchers.index') }}"
                class="bg-white dark:bg-gray-700 py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                Anuluj
            </a>
            <button type="submit"
                class="bg-blue-600 border border-transparent rounded-md shadow-sm py-2 px-4 text-sm font-medium text-white hover:bg-blue-700 dark:hover:bg-blue-500">
                {{ $isEdit ? 'Zapisz zmiany' : 'Utwórz voucher' }}
            </button>
        </div>
    </form>
</div>
