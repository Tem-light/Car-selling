<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Buyer Dashboard</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 text-red-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-500 text-sm font-medium">Saved Cars (Watchlist)</p>
                            <p class="text-2xl font-bold text-gray-900">{{ auth()->user()->favoriteCars()->count() }}</p>
                        </div>
                    </div>
                    <a href="{{ route('cars.watchlist') }}" class="mt-3 block text-sm text-primary hover:underline">View watchlist &rarr;</a>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-100 text-primary">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-500 text-sm font-medium">Browse Cars</p>
                            <p class="text-sm text-gray-600">Find your perfect car</p>
                        </div>
                    </div>
                    <a href="{{ route('cars.search') }}" class="mt-3 block text-sm text-primary hover:underline">Start browsing &rarr;</a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800">Get Started</h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-500 mb-4">Welcome, {{ auth()->user()->first_name }}! As a buyer, you can browse available cars, save favorites to your watchlist, and contact sellers directly when you find a car you like.</p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('cars.search') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white font-medium rounded-lg hover:bg-indigo-700 transition shadow-md">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            Browse Cars
                        </a>
                        <a href="{{ route('cars.watchlist') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            View Watchlist
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
