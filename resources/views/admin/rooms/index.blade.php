@extends('layouts.admin')

@section('content')
<!-- Modal potwierdzenia usunięcia -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-lg px-8 py-6 max-w-md mx-auto">
        <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">Potwierdź usunięcie</h3>
        <p class="text-gray-700 dark:text-gray-300 mb-6">Czy na pewno chcesz usunąć ten pokój? Tej operacji nie można cofnąć.</p>
        <div class="flex justify-end space-x-4">
            <button onclick="closeDeleteModal()" 
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition duration-150 ease-in-out">
                Anuluj
            </button>
            <form id="deleteForm" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition duration-150 ease-in-out">
                    Usuń
                </button>
            </form>
        </div>
    </div>
</div>
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Lista pokoi</h2>
        <a href="{{ route('admin.rooms.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
            Dodaj nowy pokój
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Nazwa pokoju
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Pojemność
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Cena za osobę
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Rezerwacje (tydzień)
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Rezerwacje (rok)
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Średnia ocena
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Akcje
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($rooms as $room)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            {{ $room['name'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            {{ $room['capacity'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            {{ number_format($room['price_per_person'], 2) }} zł
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            {{ $room['weekly_reservations'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            {{ $room['yearly_reservations'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                            {{ number_format($room['average_rating'], 1) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $room['is_available'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $room['is_available'] ? 'Dostępny' : 'Niedostępny' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap ml- text-sm text-gray-900 dark:text-gray-100">
                            <a href="{{ route('admin.rooms.edit', $room['id']) }}" 
                               class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                Edytuj
                            </a>
                            <button onclick="showDeleteModal('{{ route('admin.rooms.destroy', $room['id']) }}', '{{ $room['name'] }}')" 
                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                Usuń
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
<script>
function showDeleteModal(deleteUrl, roomName) {
    const modal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');
    const modalText = modal.querySelector('p');
    
    // Aktualizuj tekst modalu
    modalText.textContent = `Czy na pewno chcesz usunąć pokój "${roomName}"? Tej operacji nie można cofnąć.`;
    
    // Ustaw URL formularza
    deleteForm.action = deleteUrl;
    
    // Pokaż modal
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    
    // Dodaj obsługę zamykania modalu przez kliknięcie poza nim
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeDeleteModal();
        }
    });
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

// Obsługa klawisza ESC
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeDeleteModal();
    }
});
</script>
@endsection
@endsection