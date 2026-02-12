@props(['car', 'isWatchList' => false])

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 border border-gray-100 dark:border-gray-700 group">
    
    <a href="{{ route('cars.show', $car->id) }}" class="block relative aspect-w-16 aspect-h-10 group">
    <img src="{{ $car->primaryImage ? asset('storage/' . $car->primaryImage->image_path) : asset('images/default-car.jpg') }}" 
     alt="{{ $car->carModel->name ?? 'Car' }}" 
     class="object-cover w-full h-48 group-hover:scale-105 transition-transform duration-500"/>
    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
</a>


    <div class="p-5">
        <div class="flex items-center justify-between mb-2">
            <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                {{ $car->city->name ?? 'N/A' }}
            </span>

            <!-- Watchlist toggle button -->
            <form action="{{ route('cars.toggleWatchlist', $car->id) }}" method="POST">
                @csrf
                <button type="submit" class="focus:outline-none text-gray-400 hover:text-red-500 transition-colors">
                    @if($isWatchList)
                        <!-- Filled Heart -->
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-red-500">
                            <path d="M11.645 20.91-.007-.003-.022-.012a15.247 15.247 0 0 1-.383-.218 25.18 25.18 0 0 1-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0 1 12 5.052 5.5 5.5 0 0 1 16.313 3c2.973 0 5.437 2.322 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 0 1-4.244 3.17 15.247 15.247 0 0 1-.383.219l-.022.012-.007.004-.003.001a.752.752 0 0 1-.704 0l-.003-.001Z"/>
                        </svg>
                    @else
                        <!-- Outline Heart -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                        </svg>
                    @endif
                </button>
            </form>
        </div>

        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1 truncate">
            <a href="{{ route('cars.show', $car->id) }}">
                {{ $car->year }} {{ $car->maker->name ?? '' }} {{ $car->carModel->name ?? 'Model' }}
            </a>
        </h3>

        <div class="text-xl font-bold text-primary mb-3">
            ${{ number_format($car->price) }}
        </div>

        <div class="border-t border-gray-100 dark:border-gray-700 pt-3 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
            <span class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">{{ $car->carType->name ?? 'Type' }}</span>
            <span class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">{{ $car->fuelType->name ?? 'Fuel' }}</span>
            <span class="bg-gray-100 dark:bg-gray-700 px-2 py-1 rounded">{{ number_format($car->mileage ?? 0) }} mi</span>
        </div>
    </div>
</div>
