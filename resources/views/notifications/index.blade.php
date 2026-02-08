<x-app-layout>
    <main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Notifications</h1>
            @if($unreadCount > 0)
                <form method="POST" action="{{ route('notifications.read-all') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-primary hover:underline">Mark all as read</button>
                </form>
            @endif
        </div>
        <div class="space-y-2 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-sm">
            @forelse($notifications as $notification)
                <a href="{{ $notification->data['url'] ?? '#' }}" class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition {{ $notification->read_at ? 'opacity-75' : 'bg-indigo-50/50 dark:bg-gray-700/30' }}">
                    <p class="font-medium text-gray-900 dark:text-white">{{ $notification->title }}</p>
                    @if($notification->message)
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">{{ $notification->message }}</p>
                    @endif
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                </a>
            @empty
                <p class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">No notifications yet.</p>
            @endforelse
        </div>
    </main>
</x-app-layout>
