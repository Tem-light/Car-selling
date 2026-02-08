<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-8">Admin Dashboard</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Stat Card 1 -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 bg-blue-100 text-blue-600 rounded-lg">
                        <i class="fas fa-car fa-lg"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Cars</p>
                        <p class="text-2xl font-bold">{{ $totalCars }}</p>
                    </div>
                </div>
                <!-- Stat Card 2 -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 bg-green-100 text-green-600 rounded-lg">
                        <i class="fas fa-users fa-lg"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-gray-500 text-sm">Total Users</p>
                        <p class="text-2xl font-bold">{{ $totalUsers }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Cars -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-50 flex justify-between items-center">
                        <h3 class="font-semibold text-gray-800">Recent Listings</h3>
                        <a href="{{ route('admin.cars.index') }}" class="text-primary text-sm hover:underline">View All</a>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @foreach($cars as $car)
                            <div class="px-6 py-4 flex justify-between items-center">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $car->year }} {{ $car->maker->name ?? '' }} {{ $car->carModel->name ?? 'Model' }}</p>
                                    <p class="text-sm text-gray-500">${{ number_format($car->price) }}</p>
                                </div>
                                <span class="text-xs text-gray-400">{{ $car->created_at->diffForHumans() }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Recent Users -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-50">
                        <h3 class="font-semibold text-gray-800">Recent Users</h3>
                    </div>
                    <div class="divide-y divide-gray-50">
                        @foreach($users as $user)
                            <div class="px-6 py-4 flex items-center">
                                <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-xs">
                                    {{ substr($user->first_name, 0, 1) }}{{ substr($user->last_name, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <p class="font-medium text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</p>
                                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
