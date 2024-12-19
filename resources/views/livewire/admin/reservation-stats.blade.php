<div>
    <div class="mb-4">
        <select wire:model="period" 
                class="rounded-md shadow-sm border-gray-300 dark:border-gray-600 
                       bg-white dark:bg-gray-500 text-gray-900 dark:text-gray-100">
            <option value="year">Rok</option>
            <option value="month">Miesiąc</option>
            <option value="week">Tydzień</option>
        </select>
    </div>
    

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
        <!-- Tabela statystyk -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Okres
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Liczba rezerwacji
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($stats as $stat)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                                @if($period === 'week')
                                    {{ $stat->date }}
                                @elseif($period === 'month')
                                    {{ $stat->date }}
                                @elseif($period === 'year')
                                    {{ $stat->date }}
                                @else
                                    {{ $stat->date }}
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 dark:text-gray-100">
                                {{ $stat->count }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

<!-- Podsumowanie -->
<div class="mt-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-md">
    <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
        Podsumowanie:
    </div>
    <div class="mt-2 text-gray-900 dark:text-gray-100">
        Łączna liczba rezerwacji: {{ $this->getTotalCount() }}
    </div>
    <div class="mt-1 text-gray-900 dark:text-gray-100">
        Średnia liczba rezerwacji: {{ number_format($this->getAverageCount(), 2) }}
    </div>
    <div class="mt-1 text-gray-900 dark:text-gray-100">
        Łączny zysk w okresie: {{ number_format($this->getTotalEarnings(), 2) }} zł
    </div>
    <div class="mt-1 text-gray-900 dark:text-gray-100">
        Średni zysk dzienny: {{ number_format($this->getAverageEarnings(), 2) }} zł
    </div>
</div>

<!-- Wizualizacja w formie paska postępu -->
<div class="mt-6">
    <div class="grid gap-4">
        @foreach($stats as $stat)
            <div class="flex items-center">
                <div class="w-32 text-gray-900 dark:text-gray-100">
                    @if($period === 'week')
                        {{ $stat->date }}
                    @elseif($period === 'month')
                        {{ $stat->date }}
                    @elseif($period === 'year')
                        {{ $stat->date }}
                    @else
                        {{ $stat->date }}
                    @endif
                </div>
                <div class="flex-1">
                    <div class="bg-gray-200 dark:bg-gray-600 rounded-full h-2.5">
                        <div class="bg-blue-600 dark:bg-blue-400 h-2.5 rounded-full transition-all duration-200" 
                            style="width: {{ ($stat->count / $this->getMaxCount()) * 100 }}%">
                        </div>
                    </div>
                </div>
                <div class="w-32 text-right text-gray-900 dark:text-gray-100">
                    {{ $stat->count }} ({{ number_format($stat->earnings, 2) }} zł)
                </div>
            </div>
        @endforeach
    </div>
</div>
</div>