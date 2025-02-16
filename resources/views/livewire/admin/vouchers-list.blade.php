<div>
    <div class="mb-4 flex justify-between items-center">
        <div class="flex-1 pr-4">
            <input wire:model.debounce.300ms="search" type="search"
                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:placeholder-gray-400"
                placeholder="Szukaj voucherów...">
        </div>
        <div class="flex items-center">
            <label class="flex items-center mr-4">
                <input type="checkbox" wire:model="showInactive"
                    class="form-checkbox dark:bg-gray-700 dark:border-gray-600 dark:text-blue-500">
                <span class="ml-2 text-gray-700 dark:text-gray-200">Pokaż nieaktywne</span>
            </label>
            <a href="{{ route('admin.vouchers.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Dodaj voucher
            </a>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Kod
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Typ rabatu
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Wartość
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Użycia
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Ważność
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Status
                    </th>
                    <th
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                        Akcje
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @foreach ($vouchers as $voucher)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">
                            {{ $voucher->code }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">
                            {{ $voucher->discount_type === 'percentage' ? 'Procentowy' : 'Kwotowy' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">
                            {{ $voucher->discount_type === 'percentage'
                                ? $voucher->discount_value . '%'
                                : number_format($voucher->discount_value, 2) . ' zł' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">
                            {{ $voucher->times_used }}/{{ $voucher->usage_limit ?? '∞' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-200">
                            @if ($voucher->valid_until)
                                {{ $voucher->valid_until->format('d.m.Y') }}
                            @else
                                Bezterminowo
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $voucher->is_active
                                    ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                    : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                {{ $voucher->is_active ? 'Aktywny' : 'Nieaktywny' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('admin.vouchers.edit', $voucher) }}"
                                class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 mr-3">
                                Edytuj
                            </a>
                            <button wire:click="toggleActive({{ $voucher->id }})"
                                class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3">
                                {{ $voucher->is_active ? 'Dezaktywuj' : 'Aktywuj' }}
                            </button>
                            <button wire:click="delete({{ $voucher->id }})"
                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                Usuń
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="px-4 py-3 dark:bg-gray-800">
            {{ $vouchers->links() }}
        </div>
    </div>
</div>
