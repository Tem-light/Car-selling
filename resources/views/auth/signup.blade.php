<x-app-layout>
    <div class="min-h-[calc(100vh-64px)] flex flex-col items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8 bg-white p-8 rounded-2xl shadow-xl border border-gray-100">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Create your account
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Join the best car selling platform today
                </p>
            </div>
            
            @if ($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-lg text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form class="mt-8 space-y-6" action="{{ route('signup.post') }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                        <input id="first_name" name="first_name" type="text" required class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm shadow-sm" placeholder="John" value="{{ old('first_name') }}">
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                        <input id="last_name" name="last_name" type="text" required class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm shadow-sm" placeholder="Doe" value="{{ old('last_name') }}">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
                    <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm shadow-sm" placeholder="you@example.com" value="{{ old('email') }}">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input id="phone" name="phone" type="tel" class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm shadow-sm" placeholder="+1 (555) 000-0000" value="{{ old('phone') }}">
                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-1">I want to</label>
                    <div class="grid grid-cols-2 gap-4 mt-2">
                        <label class="relative flex cursor-pointer rounded-lg border p-4 shadow-sm focus:outline-none hover:border-indigo-500 peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-500 {{ old('role') === 'buyer' || !old('role') ? 'border-indigo-500 ring-2 ring-indigo-500' : 'border-gray-300' }}">
                            <input type="radio" name="role" value="buyer" class="sr-only peer" {{ old('role', 'buyer') === 'buyer' ? 'checked' : '' }}>
                            <span class="flex flex-col">
                                <span class="block text-sm font-medium text-gray-900">Browse & Buy</span>
                                <span class="block text-xs text-gray-500 mt-1">Find and purchase cars</span>
                            </span>
                        </label>
                        <label class="relative flex cursor-pointer rounded-lg border p-4 shadow-sm focus:outline-none hover:border-indigo-500 peer-checked:border-indigo-500 peer-checked:ring-2 peer-checked:ring-indigo-500 {{ old('role') === 'seller' ? 'border-indigo-500 ring-2 ring-indigo-500' : 'border-gray-300' }}">
                            <input type="radio" name="role" value="seller" class="sr-only peer" {{ old('role') === 'seller' ? 'checked' : '' }}>
                            <span class="flex flex-col">
                                <span class="block text-sm font-medium text-gray-900">Sell Cars</span>
                                <span class="block text-xs text-gray-500 mt-1">Create and manage listings</span>
                            </span>
                        </label>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="password" name="password" type="password" required class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm shadow-sm" placeholder="••••••••">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required class="appearance-none relative block w-full px-3 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm shadow-sm" placeholder="••••••••">
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-secondary hover:bg-emerald-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 shadow-lg shadow-emerald-500/30 transition-transform transform hover:scale-105">
                        Create Account
                    </button>
                </div>
            </form>
            
            <div class="text-center mt-4">
                <p class="text-sm text-gray-600">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Sign in
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-app-layout>
