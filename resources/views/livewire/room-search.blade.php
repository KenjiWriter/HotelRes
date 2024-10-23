<div>
    @if($errorMessage)
        <div x-data="{ show: true }" x-show.transition.opacity.out.duration.1500ms.delay.500ms="show" x-init="setTimeout(() => show = false, 5000)" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
            {{ $errorMessage }}
            <span @click="show = false" class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer">×</span>
        </div>
    @endif  
    <form class="bg-white dark:bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="check_in">
                {{ __('messages.check_in') }}
            </label>
            <input wire:model="checkIn" type="date" id="check_in" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="check_out">
                {{ __('messages.check_out') }}
            </label>
            <input wire:model="checkOut" type="date" id="check_out" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="guests">
                {{ __('messages.guests') }}
            </label>
            <input wire:model="guests" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="guests" type="number" name="guests" min="1" required>
        </div>
        <div class="mb-4 flex space-x-4">
            <div class="w-1/2">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="price_min">
                    {{ __('messages.price_min') }}
                </label>
                <input wire:model="priceMin" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="price_min" type="number" name="price_min" min="0" step="0.01">
            </div>
            <div class="w-1/2">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="price_max">
                    {{ __('messages.price_max') }}
                </label>
                <input wire:model="priceMax" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="price_max" type="number" name="price_max" min="0" step="0.01">
            </div>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2" for="amenities">
                {{ __('amenities.Amenities') }}
            </label>
            <div class="relative">
                <button type="button" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 dark:text-gray-300 dark:bg-gray-700 leading-tight focus:outline-none focus:shadow-outline" onclick="toggleDropdown()">
                    {{ __('amenities.Select') }} {{ __('amenities.Amenities') }}
                </button>
                <div id="dropdown" class="absolute mt-1 w-full bg-white dark:bg-gray-900 shadow-md rounded hidden z-50 transition-all duration-300 ease-in-out transform opacity-0 scale-y-0 origin-top" wire:ignore>
                    @foreach(App\Models\Amenity::all() as $amenity)
                        <label class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-800">
                            <input type="checkbox" value="{{ $amenity->id }}" class="mr-2" onchange="updateAmenities()">
                            {{ __('amenities.' . $amenity->name) }}
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" wire:click="search">
                {{ __('messages.search') }} ({{ $availableRoomsCount }})
            </button>
        </div>
    </form>

    <script>
        function updateAmenities() {
            const checkboxes = document.querySelectorAll('#dropdown input[type="checkbox"]');
            const selectedAmenities = Array.from(checkboxes)
                .filter(checkbox => checkbox.checked)
                .map(checkbox => checkbox.value);

            @this.set('amenities', selectedAmenities);
        }
    </script>
</div>