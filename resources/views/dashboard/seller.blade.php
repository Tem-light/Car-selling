<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <h2 class="text-3xl font-bold text-gray-800">Seller Dashboard</h2>
                <a href="{{ route('cars.create') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-primary to-secondary text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all" title="As a Seller, you can create new listings here">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Create Listing
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-indigo-100 text-primary">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-500 text-sm font-medium">My Listings</p>
                            <p class="text-2xl font-bold text-gray-900">{{ auth()->user()->cars()->count() }}</p>
                        </div>
                    </div>
                    <a href="{{ route('cars.index') }}" class="mt-3 block text-sm text-primary hover:underline">View all &rarr;</a>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-emerald-100 text-secondary">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-500 text-sm font-medium">Published</p>
                            <p class="text-2xl font-bold text-gray-900">{{ auth()->user()->cars()->whereNotNull('published_at')->count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6 border border-gray-100">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-amber-100 text-amber-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-gray-500 text-sm font-medium">Drafts</p>
                            <p class="text-2xl font-bold text-gray-900">{{ auth()->user()->cars()->whereNull('published_at')->count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-6 bg-white border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-800">Recent Listings</h3>
                    <a href="{{ route('cars.create') }}" class="text-secondary hover:text-emerald-600 text-sm font-medium">Publish New Car &rarr;</a>
                </div>
                <div class="p-6">
                    @if(auth()->user()->cars()->count() > 0)
                        <p class="text-gray-500 mb-4">Welcome back, {{ auth()->user()->first_name }}! Manage your listings below or create a new one.</p>
                        <a href="{{ route('cars.index') }}" class="inline-flex items-center text-primary font-medium hover:underline">
                            View all my listings
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    @else
                        <p class="text-gray-500 mb-4">Welcome, {{ auth()->user()->first_name }}! You have not listed any cars yet. Create your first listing to start selling.</p>
                        <a href="{{ route('cars.create') }}" class="inline-flex items-center px-4 py-2 bg-primary text-white font-medium rounded-lg hover:bg-indigo-700 transition">
                            Create Your First Listing
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
