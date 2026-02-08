<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Dashboard</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Stat Card 1 -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-100 text-primary">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-500 text-sm font-medium">My Cars</p>
                            <p class="text-2xl font-bold text-gray-900">{{ auth()->user()->cars()->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 text-red-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-500 text-sm font-medium">Watchlist</p>
                            <p class="text-2xl font-bold text-gray-900">{{ auth()->user()->favoriteCars()->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6 bg-white border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Activity</h3>
                    <a href="{{ route('cars.create') }}" class="text-secondary hover:text-emerald-600 text-sm font-medium">Publish New Car &rarr;</a>
                </div>
                <div class="p-6">
                    <p class="text-gray-500">Welcome back, {{ auth()->user()->first_name }}! Use the navigation menu to manage your listings or browse cars.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
