<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="py-4">
        <!-- Filtry podstawowe -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 mb-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data od</label>
                    <input type="date" wire:model="dateFrom"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Data do</label>
                    <input type="date" wire:model="dateTo"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select wire:model="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        <option value="">Wszystkie</option>
                        <option value="upcoming">Nadchodzące</option>
                        <option value="current">Obecne</option>
                        <option value="past">Zakończone</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button wire:click="toggleAdvancedFilters"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-4 rounded inline-flex items-center">
                        <span>{{ $showAdvancedFilters ? 'Ukryj dodatkowe' : 'Dodatkowe' }}</span>
                        <svg class="w-4 h-4 ml-2 transform transition-transform duration-200 {{ $showAdvancedFilters ? 'rotate-180' : '' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Filtry zaawansowane -->
            <div class="overflow-hidden transition-all duration-1000 ease-in-out" x-data="{ show: @entangle('showAdvancedFilters') }" x-show="show"
                x-transition:enter="transition ease-out duration-1000"
                x-transition:enter-start="opacity-0 transform -translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform -translate-y-4" x-cloak>
                <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Liczba gości</label>
                        <input type="number" wire:model="guestsCount"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <input type="email" wire:model="email"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="flex items-end">
                        <button wire:click="resetFilters"
                            class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                            Resetuj filtry
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Lista rezerwacji -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Pokój
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Data rezerwacji
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Kwota
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Email
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Akcje
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($reservations as $reservation)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ $reservation->room->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ Carbon\Carbon::parse($reservation->check_in)->format('d.m.Y') }} -
                                {{ Carbon\Carbon::parse($reservation->check_out)->format('d.m.Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ number_format($reservation->total_price, 2) }} zł
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ $reservation->guest_email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                <button wire:click="showReservationDetails({{ $reservation->id }})"
                                    class="text-blue-600 hover:text-blue-900">
                                    Pokaż więcej
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-4 py-3">
                {{ $reservations->links() }}
            </div>
        </div>
    </div>

    <!-- Modal ze szczegółami rezerwacji -->
    @if ($showModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" id="modal">
            <div
                class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white dark:bg-gray-800">
                <div class="flex justify-between items-center pb-3">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                        Szczegóły rezerwacji
                    </h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="mt-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Pokój</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $selectedReservation->room->name }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Liczba gości</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $selectedReservation->guests_number }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Data zameldowania</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ Carbon\Carbon::parse($selectedReservation->check_in)->format('d.m.Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Data wymeldowania</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ Carbon\Carbon::parse($selectedReservation->check_out)->format('d.m.Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Email</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $selectedReservation->guest_email }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Imię i nazwisko</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $selectedReservation->guest_name }}
                            </p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm font-medium text-gray-500">Goście</p>
                            <div class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                @if ($selectedReservation->guests)
                                    <div class="grid grid-cols-[auto,1fr] gap-x-2">
                                        @if ($selectedReservation->guests['adults'] > 0)
                                            <div class="flex items-center">Dorośli:</div>
                                            <div class="flex items-center">
                                                {{ $selectedReservation->guests['adults'] }}
                                            </div>
                                        @endif

                                        @if ($selectedReservation->guests['teenagers'] > 0)
                                            <div class="flex items-center">Nastolatkowie:</div>
                                            <div class="flex items-center">
                                                {{ $selectedReservation->guests['teenagers'] }}</div>
                                        @endif

                                        @if ($selectedReservation->guests['children'] > 0)
                                            <div class="flex items-center">Dzieci:</div>
                                            <div class="flex items-center">
                                                {{ $selectedReservation->guests['children'] }}</div>
                                        @endif

                                        @if ($selectedReservation->guests['infants'] > 0)
                                            <div class="flex items-center">Niemowlęta:</div>
                                            <div class="flex items-center">
                                                {{ $selectedReservation->guests['infants'] }}</div>
                                        @endif

                                        @if ($selectedReservation->guests['seniors'] > 0)
                                            <div class="flex items-center">Seniorzy:</div>
                                            <div class="flex items-center">
                                                {{ $selectedReservation->guests['seniors'] }}</div>
                                        @endif
                                    </div>
                                @else
                                    Brak dodatkowych gości
                                @endif
                            </div>
                        </div>
                        <div class="col-span-2 mt-2">
                            <p class="text-sm font-medium text-gray-500">Łączna liczba gości</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $selectedReservation->guests ? array_sum($selectedReservation->guests) : 0 }}
                            </p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm font-medium text-gray-500">Kod anulowania</p>
                            <p class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                {{ $selectedReservation->cancellation_code }}
                            </p>
                        </div>
                    </div>
                </div>


                <div class="mt-6">
                    <button wire:click="closeModal"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                        Zamknij
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
