<x-guest-layout>
    <div class="flex flex-col md:flex-row">
        <!-- Left side (form) -->
        <div class="w-full md:w-1/2 bg-white p-8 flex flex-col justify-center">
            <div class="mx-auto w-full max-w-md">
                <div class="flex justify-start mb-8">
                    <img src="{{ asset('images/logo.png') }}" class="w-8 h-8" alt="Logo">
                </div>
                
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-normal text-gray-700 mb-1">Email address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-400">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    
                    <div class="mb-5">
                        <label for="password" class="block text-sm font-normal text-gray-700 mb-1">Password</label>
                        <input id="password" type="password" name="password" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-400">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    
                    <div class="mb-6">
                        <div class="flex items-center">
                            <input type="checkbox" id="remember_me" name="remember" class="h-4 w-4 text-gray-600 focus:ring-gray-500 border-gray-300 rounded">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-700">Remember me</label>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between mb-8">
                        <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:text-gray-800">Forgot your password?</a>
                        <button type="submit" class="bg-gray-700 hover:bg-gray-800 text-white py-2 px-6 rounded-md font-medium">
                            Log in
                        </button>
                    </div>
                    
                    <div class="text-center text-sm">
                        No account yet? <a href="{{ route('register') }}" class="text-gray-800 hover:underline">Sign-up here.</a>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Right side (branding) -->
        <div class="hidden md:flex md:w-1/2 bg-gradient-to-b from-gray-800 to-indigo-700 text-white p-8 flex-col justify-center items-center">
            <div class="max-w-md mx-auto text-center">
                <h1 class="text-6xl font-bold mb-3">ByteX</h1>
                <p class="text-xl mb-12">Elevate your setup today.</p>
                
                <!-- Spiral graphic -->
                <div class="w-64 h-64 mx-auto">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo">
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>