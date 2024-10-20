<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wyniki wyszukiwania</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Wyniki wyszukiwania</h1>
        <p class="mb-4">Okres pobytu: {{ $checkIn->format('d.m.Y') }} - {{ $checkOut->format('d.m.Y') }}</p>
        @if($rooms->isEmpty())
            <p class="text-lg">Nie znaleziono pokoi spełniających kryteria.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($rooms as $room)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-xl font-bold mb-2">{{ $room->name }}</h2>
                            <p class="text-gray-600 mb-4">{{ Str::limit($room->description, 100) }}</p>
                            <p class="text-lg font-semibold">Cena: {{ number_format($room->price, 2) }} PLN / noc</p>
                            <p class="text-gray-600">Maksymalna liczba gości: {{ $room->capacity }}</p>
                            {{-- href="{{ route('room.show', ['id' => $room->id, 'check_in' => $checkIn->format('Y-m-d'), 'check_out' => $checkOut->format('Y-m-d')]) }}" --}}
                            <a  class="mt-4 inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Szczegóły i rezerwacja
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>