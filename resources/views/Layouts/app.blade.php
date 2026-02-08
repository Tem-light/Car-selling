<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth" id="html-theme">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CarPlatform') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        primary: '#4F46E5', // Indigo 600
                        secondary: '#10B981', // Emerald 500
                        dark: '#111827', // Gray 900
                    },
                    animation: {
                        blob: "blob 7s infinite",
                    },
                    keyframes: {
                        blob: {
                            "0%": {
                                transform: "translate(0px, 0px) scale(1)",
                            },
                            "33%": {
                                transform: "translate(30px, -50px) scale(1.1)",
                            },
                            "66%": {
                                transform: "translate(-20px, 20px) scale(0.9)",
                            },
                            "100%": {
                                transform: "translate(0px, 0px) scale(1)",
                            },
                        },
                    },
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 antialiased flex flex-col min-h-screen relative transition-colors duration-300">
    
    <!-- Animated Background Blobs -->
    <div class="fixed inset-0 -z-10 overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-200/50 dark:bg-indigo-900/20 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-0 right-1/4 w-96 h-96 bg-emerald-200/50 dark:bg-emerald-900/20 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000" style="animation-delay: 2s"></div>
        <div class="absolute -bottom-8 left-1/3 w-96 h-96 bg-purple-200/50 dark:bg-purple-900/20 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000" style="animation-delay: 4s"></div>
    </div>

    <!-- Navigation -->
    <nav class="bg-white/70 dark:bg-gray-800/80 backdrop-blur-lg sticky top-0 z-50 border-b border-gray-100 dark:border-gray-700 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex">
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                            <div class="bg-gradient-to-tr from-primary to-secondary p-2 rounded-lg text-white group-hover:shadow-lg transition duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                                  <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9.586a1 1 0 01-.293.707l-2.828 2.829a1 1 0 001.414 1.414l5-5"/></svg>
                            </div>
                            <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary to-secondary">
                                CarPlatform
                            </span>
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <!-- Desktop Nav - Role-based -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex mr-8">
                        <a href="{{ route('cars.search') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-primary transition duration-150 ease-in-out relative group">
                            Browse Cars
                            <span class="absolute bottom-0 left-0 w-full h-0.5 bg-primary transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                        </a>
                        @auth
                            @if(Auth::user()->hasRole('admin'))
                                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-red-600 hover:text-red-700 transition relative group" title="Admin Dashboard">
                                    Admin
                                </a>
                                <a href="{{ route('admin.cars.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-primary transition relative group" title="Manage all listings">
                                    All Listings
                                </a>
                            @endif
                            @if(Auth::user()->hasRole('seller'))
                                <a href="{{ route('cars.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-primary transition relative group" title="My car listings">
                                    My Listings
                                </a>
                                <a href="{{ route('cars.create') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-primary transition relative group" title="Create a new listing">
                                    Create Listing
                                </a>
                            @endif
                            @if(Auth::user()->hasRole('buyer'))
                                <a href="{{ route('cars.search') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-primary transition relative group" title="Browse available cars">
                                    Browse Cars
                                </a>
                                <a href="{{ route('cars.watchlist') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-primary transition relative group" title="Saved cars">
                                    Watchlist
                                </a>
                            @endif
                        @endauth
                    </div>

                    <!-- Right Side Nav -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <!-- Dark mode toggle -->
                        <button type="button" id="theme-toggle" class="p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition mr-1" aria-label="Toggle dark mode">
                            <svg id="theme-icon-dark" class="w-5 h-5 hidden" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                            <svg id="theme-icon-light" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path></svg>
                        </button>
                        @guest
                            <div class="space-x-4 flex items-center">
                                <a href="{{ route('login') }}" class="text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white font-medium transition hover:scale-105 transform">Log in</a>
                                <a href="{{ route('signup') }}" class="bg-gray-900 dark:bg-gray-100 hover:bg-gray-800 dark:hover:bg-gray-200 text-white dark:text-gray-900 px-5 py-2.5 rounded-full font-medium transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">Sign up</a>
                            </div>
                        @endguest

                        @auth
                            <!-- Notification bell -->
                            <div class="relative mr-2">
                                <button type="button" id="notification-bell" class="relative p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 transition focus:outline-none" aria-label="Notifications">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                    @if(isset($notificationUnreadCount) && $notificationUnreadCount > 0)
                                        <span class="absolute top-0.5 right-0.5 flex h-4 w-4 items-center justify-center rounded-full bg-red-500 text-[10px] font-bold text-white" id="notification-badge">{{ $notificationUnreadCount > 9 ? '9+' : $notificationUnreadCount }}</span>
                                    @endif
                                </button>
                                <div id="notification-dropdown" class="hidden absolute right-0 mt-2 w-80 sm:w-96 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 z-50 max-h-[min(24rem,80vh)] overflow-hidden flex flex-col">
                                    <div class="flex items-center justify-between px-4 py-3 border-b border-gray-100 dark:border-gray-700">
                                        <h3 class="font-semibold text-gray-900 dark:text-white">Notifications</h3>
                                        <button type="button" id="notifications-mark-all" class="text-sm text-primary hover:underline">Mark all read</button>
                                    </div>
                                    <div id="notification-list" class="overflow-y-auto flex-1 p-2">
                                        <p class="text-sm text-gray-500 dark:text-gray-400 py-4 text-center">Loading…</p>
                                    </div>
                                    <a href="{{ route('notifications.index') }}" class="block text-center py-2 text-sm text-primary hover:underline border-t border-gray-100 dark:border-gray-700">View all</a>
                                </div>
                            </div>
                            <div class="ml-3 relative relative-group">
                                <div class="flex items-center space-x-4">
                                    @if(Auth::user()->hasRole('admin'))
                                        <a href="{{ route('admin.dashboard') }}" class="text-xs font-bold uppercase tracking-widest text-red-600 hover:text-red-700 bg-red-50 dark:bg-red-900/30 dark:border-red-800 px-3 py-1 rounded-full border border-red-100">
                                            Admin
                                        </a>
                                    @endif
                                    @if(Auth::user()->canManageListings())
                                        <a href="{{ route('cars.create') }}" class="hidden md:inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-full text-white bg-gradient-to-r from-primary to-secondary hover:from-indigo-600 hover:to-emerald-600 shadow-md transform hover:-translate-y-0.5 transition-all" title="As a seller, create new listings here">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            Sell Car
                                        </a>
                                    @endif
                                    
                                    <div class="relative group">
                                        <button class="flex items-center space-x-2 text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-primary focus:outline-none transition duration-150 ease-in-out">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/50 dark:to-purple-900/50 text-primary flex items-center justify-center font-bold border border-indigo-50 dark:border-indigo-800">
                                                {{ substr(Auth::user()->first_name, 0, 1) }}
                                            </div>
                                            <svg class="h-4 w-4 text-gray-400 dark:text-gray-500 group-hover:text-primary transition" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <!-- Dropdown for user menu -->
                                        <div class="absolute right-0 w-56 mt-2 origin-top-right bg-white/90 dark:bg-gray-800/95 backdrop-blur-xl border border-gray-100 dark:border-gray-700 rounded-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50 transform group-hover:translate-y-1">
                                            <div class="p-2">
                                                <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700 mb-1">
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">Signed in as</p>
                                                    <p class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ Auth::user()->email }}</p>
                                                </div>
                                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-gray-700 hover:text-primary rounded-lg transition">Dashboard</a>
                                                @if(Auth::user()->canManageListings())
                                                    <a href="{{ route('cars.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-gray-700 hover:text-primary rounded-lg transition">My Listings</a>
                                                @endif
                                                <a href="{{ route('cars.watchlist') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-indigo-50 dark:hover:bg-gray-700 hover:text-primary rounded-lg transition">Watchlist</a>
                                                <div class="border-t border-gray-100 dark:border-gray-700 my-1"></div>
                                                <form method="POST" action="{{ route('logout') }}">
                                                    @csrf
                                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 hover:text-red-700 rounded-lg transition flex items-center">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                                        Log Out
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Page Content -->
    <main class="flex-grow z-0">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white relative overflow-hidden">
        <div class="absolute inset-0 z-0 opacity-20">
             <div class="absolute -top-24 -left-24 w-96 h-96 bg-primary rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>
             <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-secondary rounded-full mix-blend-multiply filter blur-3xl opacity-30"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="col-span-1 md:col-span-2">
                    <a href="/" class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary to-secondary mb-4 inline-block">CarPlatform</a>
                    <p class="text-gray-400 mt-4 max-w-sm">The most trusted platform to buy and sell cars. We connect thousands of sellers with buyers every day. Experience the premium way of trading.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-6 text-white">Quick Links</h4>
                    <ul class="space-y-4 text-gray-400">
                        <li><a href="{{ route('cars.search') }}" class="hover:text-white hover:pl-1 transition-all">Browse Cars</a></li>
                        @auth
                            @if(Auth::user()->canManageListings())
                                <li><a href="{{ route('cars.create') }}" class="hover:text-white hover:pl-1 transition-all">Sell Your Car</a></li>
                            @endif
                        @else
                            <li><a href="{{ route('signup') }}" class="hover:text-white hover:pl-1 transition-all">Sell Your Car</a></li>
                        @endauth
                        <li><a href="{{ route('signup') }}" class="hover:text-white hover:pl-1 transition-all">Join Us</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-6 text-white">Support</h4>
                    <ul class="space-y-4 text-gray-400">
                        <li><a href="#" class="hover:text-white hover:pl-1 transition-all">Help Center</a></li>
                        <li><a href="#" class="hover:text-white hover:pl-1 transition-all">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-white hover:pl-1 transition-all">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-16 pt-8 flex flex-col md:flex-row justify-between items-center text-gray-500 dark:text-gray-400 text-sm">
                <p>&copy; {{ date('Y') }} CarPlatform. All rights reserved.</p>
                <div class="flex space-x-6 mt-4 md:mt-0">
                    <a href="#" class="hover:text-white transition"><i class="fab fa-facebook"></i> Facebook</a>
                    <a href="#" class="hover:text-white transition"><i class="fab fa-twitter"></i> Twitter</a>
                    <a href="#" class="hover:text-white transition"><i class="fab fa-instagram"></i> Instagram</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        (function () {
            var theme = localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
            var el = document.getElementById('html-theme');
            var iconDark = document.getElementById('theme-icon-dark');
            var iconLight = document.getElementById('theme-icon-light');
            if (theme === 'dark') {
                el.classList.add('dark');
                if (iconDark) iconDark.classList.remove('hidden');
                if (iconLight) iconLight.classList.add('hidden');
            } else {
                el.classList.remove('dark');
                if (iconDark) iconDark.classList.add('hidden');
                if (iconLight) iconLight.classList.remove('hidden');
            }
            document.getElementById('theme-toggle')?.addEventListener('click', function () {
                var isDark = el.classList.toggle('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                if (iconDark) iconDark.classList.toggle('hidden', !isDark);
                if (iconLight) iconLight.classList.toggle('hidden', isDark);
            });
        })();

        (function () {
            var bell = document.getElementById('notification-bell');
            var dropdown = document.getElementById('notification-dropdown');
            var listEl = document.getElementById('notification-list');
            var markAllBtn = document.getElementById('notifications-mark-all');
            var badge = document.getElementById('notification-badge');
            if (!bell || !dropdown) return;
            var csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            function closeDropdown() { dropdown.classList.add('hidden'); }
            function openDropdown() {
                dropdown.classList.remove('hidden');
                if (listEl && listEl.textContent.trim() === 'Loading…') fetchNotifications();
            }
            bell.addEventListener('click', function (e) {
                e.stopPropagation();
                dropdown.classList.contains('hidden') ? openDropdown() : closeDropdown();
            });
            document.addEventListener('click', function () { closeDropdown(); });
            dropdown.addEventListener('click', function (e) { e.stopPropagation(); });

            function fetchNotifications() {
                fetch('{{ route("notifications.index") }}?unread_only=0', { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } })
                    .then(function (r) { return r.json(); })
                    .then(function (data) {
                        if (!listEl) return;
                        if (!data.notifications || data.notifications.length === 0) {
                            listEl.innerHTML = '<p class="text-sm text-gray-500 dark:text-gray-400 py-4 text-center">No notifications yet.</p>';
                            return;
                        }
                        listEl.innerHTML = data.notifications.map(function (n) {
                            var link = (n.data && n.data.url) ? n.data.url : '#';
                            var readClass = n.read_at ? 'opacity-75' : 'bg-indigo-50/50 dark:bg-gray-700/50';
                            return '<a href="' + link + '" class="notification-item block px-3 py-2 rounded-lg text-sm ' + readClass + ' hover:bg-gray-50 dark:hover:bg-gray-700 transition ' + (n.data && n.data.url ? '' : 'pointer-events-none') + '" data-id="' + n.id + '">' +
                                '<span class="font-medium text-gray-900 dark:text-white">' + (n.title || 'Notification') + '</span>' +
                                (n.message ? '<p class="text-gray-500 dark:text-gray-400 mt-0.5">' + n.message + '</p>' : '') +
                                '</a>';
                        }).join('');
                    })
                    .catch(function () { if (listEl) listEl.innerHTML = '<p class="text-sm text-red-500 py-4 text-center">Failed to load.</p>'; });
            }

            markAllBtn?.addEventListener('click', function (e) {
                e.preventDefault();
                fetch('{{ route("notifications.read-all") }}', { method: 'POST', headers: { 'X-CSRF-TOKEN': csrf || '', 'Accept': 'application/json', 'Content-Type': 'application/json' } })
                    .then(function (r) { return r.json(); })
                    .then(function () {
                        if (badge) badge.remove();
                        fetchNotifications();
                    });
            });
        })();
    </script>
</body>
</html>