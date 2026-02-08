<x-app-layout>
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 rounded-lg text-emerald-800 text-sm">{{ session('success') }}</div>
            @endif

            <!-- Header -->
            <div class="mb-8 flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                <div>
                    <h1 class="text-4xl font-extrabold text-gray-900 mb-2">
                        {{ $car->year }} {{ $car->maker->name ?? '' }} {{ $car->carModel->name ?? '' }}
                    </h1>
                    <div class="flex items-center text-gray-500 text-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $car->city->name ?? 'Unknown' }}
                        <span class="mx-2">•</span>
                        {{ $car->published_at ? \Carbon\Carbon::parse($car->published_at)->diffForHumans() : 'Draft' }}
                    </div>
                </div>
                {{-- Edit/Delete: only visible to car owner (seller) or admin --}}
                @can('update', $car)
                    <div class="flex items-center gap-3">
                        <a href="{{ route('cars.edit', $car) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Edit
                        </a>
                        <form action="{{ route('cars.destroy', $car) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this listing?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Delete
                            </button>
                        </form>
                    </div>
                @endcan
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Images & Desc -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Gallery -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="relative aspect-w-16 aspect-h-9 bg-gray-200">
                             <img
                                src="{{ $car->primaryImage->image_path ?? asset('images/default-car.jpg') }}"
                                class="object-cover w-full h-full"
                                id="activeImage"
                            />
                            <button id="prevButton" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 p-2 rounded-full shadow-md transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </button>
                            <button id="nextButton" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 p-2 rounded-full shadow-md transition">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>
                        <div class="p-4 flex gap-4 overflow-x-auto">
                            @foreach ($car->images as $image)
                                <img
                                    src="{{ $image->image_path }}"
                                    class="w-24 h-24 object-cover rounded-lg cursor-pointer hover:opacity-75 transition ring-2 ring-transparent hover:ring-indigo-500 car-thumbnail"
                                    onclick="changeImage('{{ $image->image_path }}')"
                                />
                            @endforeach
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Description</h2>
                        <div class="prose max-w-none text-gray-600">
                            {!! nl2br(e($car->description)) !!}
                        </div>
                    </div>

                    <!-- Specs -->
                     <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-6">Features</h2>
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-car-specifications :value="$car->features?->bluetooth_connectivity">Bluetooth Connectivity</x-car-specifications>
                            <x-car-specifications :value="$car->features?->cruise_control">Cruise Control</x-car-specifications>
                            <x-car-specifications :value="$car->features?->air_conditioning">Air Conditioning</x-car-specifications>
                            <x-car-specifications :value="$car->features?->power_windows">Power Windows</x-car-specifications>
                            <x-car-specifications :value="$car->features?->power_door_locks">Power Door Locks</x-car-specifications>
                            <x-car-specifications :value="$car->features?->abs">ABS</x-car-specifications>
                            <x-car-specifications :value="$car->features?->remote_start">Remote Start</x-car-specifications>
                            <x-car-specifications :value="$car->features?->gps_navigation_system">GPS Navigation System</x-car-specifications>
                            <x-car-specifications :value="$car->features?->heated_seats">Heated Seats</x-car-specifications>
                            <x-car-specifications :value="$car->features?->climate_control">Climate Control</x-car-specifications>
                            <x-car-specifications :value="$car->features?->rear_parking_sensors">Rear Parking Sensors</x-car-specifications>
                            <x-car-specifications :value="$car->features?->leather_seats">Leather Seats</x-car-specifications>
                        </ul>
                    </div>
                </div>

                <!-- Right Column: Details Card -->
                <div class="lg:col-span-1 space-y-8">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sticky top-24">
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-3xl font-extrabold text-primary">${{ number_format($car->price) }}</span>
                            @auth
                                <form action="{{ route('cars.watchlist.toggle', $car) }}" method="POST" class="inline">
                                    @csrf
                                    @php $inWatchlist = auth()->user()->favoriteCars()->where('car_id', $car->id)->exists(); @endphp
                                    <button type="submit" class="p-2 rounded-full {{ $inWatchlist ? 'text-red-500' : 'text-gray-400 hover:text-red-500' }} transition" title="{{ $inWatchlist ? 'Remove from watchlist' : 'Add to watchlist' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="{{ $inWatchlist ? 'currentColor' : 'none' }}" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                    </button>
                                </form>
                            @endauth
                        </div>
                        
                        <div class="space-y-4 border-t border-gray-100 pt-6">
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Mileage</span>
                                <span class="font-medium text-gray-900">{{ number_format($car->mileage) }} mi</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Body Type</span>
                                <span class="font-medium text-gray-900">{{ $car->carType->name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Fuel Type</span>
                                <span class="font-medium text-gray-900">{{ $car->fuelType->name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">VIN</span>
                                <span class="font-medium text-gray-900">{{ $car->vin }}</span>
                            </div>
                             <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Address</span>
                                <span class="font-medium text-gray-900 text-right">{{ $car->address }}</span>
                            </div>
                        </div>

                        <div class="mt-8">
                             <h3 class="font-semibold text-gray-900 mb-4">Seller Contact</h3>
                             <div class="flex items-center gap-4 mb-6">
                                 <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-lg">
                                     {{ substr($car->user->first_name ?? 'U', 0, 1) }}
                                 </div>
                                 <div>
                                     <p class="font-bold text-gray-900">{{ $car->user->first_name ?? 'User' }} {{ $car->user->last_name ?? '' }}</p>
                                     <p class="text-sm text-gray-500">Owner</p>
                                 </div>
                             </div>
                             <a href="tel:{{ $car->phone }}" class="w-full block text-center bg-secondary hover:bg-emerald-600 text-white font-bold py-3 px-4 rounded-lg shadow-lg transition transform hover:scale-105">
                                 Call Seller
                             </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function changeImage(src) {
            document.getElementById('activeImage').src = src;
        }
        
        // Simple Carousel Logic (Optional enhancement)
        const images = @json($car->images->pluck('image_path'));
        let currentIndex = 0;
        
        // If images is empty, we handle it
        if (images.length > 0) {
            document.getElementById('prevButton').addEventListener('click', () => {
                currentIndex = (currentIndex > 0) ? currentIndex - 1 : images.length - 1;
                changeImage(images[currentIndex]);
            });
            
            document.getElementById('nextButton').addEventListener('click', () => {
                currentIndex = (currentIndex < images.length - 1) ? currentIndex + 1 : 0;
                changeImage(images[currentIndex]);
            });
        }
    </script>
</x-app-layout>
