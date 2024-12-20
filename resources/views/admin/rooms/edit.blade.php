@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg p-6">
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Edytuj pokój</h2>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Obecne zdjęcia</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($room->images as $image)
                    <div class="relative group">
                        <img src="{{ asset('storage/' . $image->image_path) }}"
                             alt="Room image"
                             class="w-full h-32 object-cover rounded-lg">
                        <!-- Zmieniono opacity-0 na opacity-100 lub usunięto całkowicie -->
                        <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 rounded-lg transition-opacity opacity-100 group-hover:opacity-100">
                            <form action="{{ route('admin.rooms.delete-image', $image->id) }}"
                                  method="POST"
                                  class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-sm">
                                    Usuń
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nazwa pokoju</label>
                    <input type="text" name="name" id="name" required value="{{ $room->name }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Opis</label>
                    <textarea name="description" id="description" rows="4" required
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ $room->description }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="capacity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pojemność</label>
                        <input type="number" name="capacity" id="capacity" required value="{{ $room->capacity }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>

                    <div>
                        <label for="price_per_person" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cena za osobę</label>
                        <input type="number" step="0.01" name="price_per_person" id="price_per_person" required value="{{ $room->price_per_person }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                </div>

                <!-- Dodawanie nowych zdjęć -->
                <div>
                    <label for="new_images" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dodaj nowe zdjęcia</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="new_images" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Wybierz pliki</span>
                                    <input id="new_images" name="new_images[]" type="file" class="sr-only" multiple>
                                </label>
                                <p class="pl-1 dark:text-gray-300">lub przeciągnij i upuść</p>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                PNG, JPG, GIF do 2MB
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.rooms.index') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                        Anuluj
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                        Zapisz zmiany
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
