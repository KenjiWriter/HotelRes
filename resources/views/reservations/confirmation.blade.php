<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Potwierdzenie rezerwacji</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Potwierdzenie rezerwacji</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Sukces!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-4">Szczegóły rezerwacji</h2>
                <p><strong>Pokój:</strong> {{ $reservation->room->name }}</p>
                <p><strong>Gość:</strong> {{ $reservation->guest_name }}</p>
                <p><strong>E-mail:</strong> {{ $reservation->guest_email }}</p>
                <p><strong>Data zameldowania:</strong> {{ $reservation->check_in->format('d.m.Y') }}</p>
                <p><strong>Data wymeldowania:</strong> {{ $reservation->check_out->format('d.m.Y') }}</p>
                <p><strong>Liczba gości:</strong> {{ $reservation->guests_number }}</p>
                <p><strong>Cena za osobę za noc:</strong> {{ number_format($reservation->room->price_per_person, 2) }} PLN</p>
                <p><strong>Całkowita cena:</strong> {{ number_format($reservation->total_price, 2) }} PLN</p>
            </div>
        </div>

        <a href="{{ route('home') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Powrót do strony głównej
        </a>
    </div>
</body>
</html>