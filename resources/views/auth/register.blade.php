<x-guest-layout>
    <div class="flex flex-col md:flex-row">
        <!-- Left side (form) -->
        <div class="w-full md:w-1/2 bg-white p-8 flex flex-col justify-center">
            <div class="mx-auto w-full max-w-md">
                <div class="flex justify-start mb-8">
                    <img src="{{ asset('images/logo.png') }}" class="w-8 h-8" alt="Logo">
                </div>
                
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-normal text-gray-700 mb-1">Name</label>
                        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-400">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-normal text-gray-700 mb-1">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-400">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-normal text-gray-700 mb-1">Password</label>
                        <input id="password" type="password" name="password" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-400">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    
                    <div class="mb-5">
                        <label for="password_confirmation" class="block text-sm font-normal text-gray-700 mb-1">Confirm Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-400">
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>
                    
                    <div class="flex items-center justify-between mb-8">
                        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-800">Already registered?</a>
                        <button type="submit" class="bg-gray-700 hover:bg-gray-800 text-white py-2 px-6 rounded-md font-medium">
                            Register
                        </button>
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