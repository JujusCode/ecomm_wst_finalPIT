<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset(path: 'images/logo.png') }}" type="image/png">

    <title>ByteX - {{ Auth::user()->role === 'admin' ? 'Admin Dashboard' : 'Profile' }}</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'byte-purple': {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            300: '#c4b5fd',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                        },
                        'byte-dark': {
                            700: '#252758',
                            800: '#1e1e3f',
                            900: '#171633',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter var', 'sans-serif'],
                    },
                    boxShadow: {
                        'glow': '0 0 15px rgba(123, 97, 255, 0.3)',
                        'glow-sm': '0 0 10px rgba(123, 97, 255, 0.2)',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1e1e3f 0%, #3b3d87 100%);
            color: white;
        }
        
        .backdrop-blur {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        .gradient-btn {
            background: linear-gradient(to right, #8b5cf6, #6366f1);
            transition: all 0.3s ease;
        }
        
        .gradient-btn:hover {
            background: linear-gradient(to right, #7c3aed, #4f46e5);
            box-shadow: 0 0 15px rgba(123, 97, 255, 0.3);
        }
        
        /* Table styling to match your index pages */
        .table-container {
            background-color: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-radius: 0.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .table-header {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .table-row {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .table-row:hover {
            background-color: rgba(255, 255, 255, 0.03);
        }
        
        .action-btn {
            transition: all 0.2s ease;
        }
        
        .action-btn:hover {
            transform: translateY(-1px);
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">
    <!-- Navbar -->
    <header class="bg-gray-900 w-full py-3 border-b border-gray-800">
        <nav class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center">
                <div class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-500 to-purple-600">
                    {{ Auth::user()->role === 'admin' ? 'ByteX Admin' : 'ByteX' }}
                </div>
                
                <div class="flex items-center gap-6">
                    @auth
                        <!-- User Dropdown -->
                        <div x-data="{ open: false }" @click.away="open = false" class="relative">
                            <button @click="open = !open" class="inline-flex items-center space-x-2 text-white hover:text-gray-300 transition">
                                <div class="flex items-center">
                                    <!-- Display user avatar -->
                                    <img src="{{ auth()->user()->avatarUrl }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-full object-cover mr-2">
                                    <div>{{ auth()->user()->name }}</div>
                                </div>
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        
                            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-48 bg-gray-800 rounded-md shadow-lg py-1 z-50 border border-gray-700">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-700 hover:text-white">
                                    {{ __('Profile') }}
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-200 hover:bg-gray-700 hover:text-white">
                                        {{ __('Log Out') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <div class="flex">
        <!-- Sidebar - Only show for admins -->
        @if(Auth::user()->role === 'admin')
        <aside class="w-64 min-h-screen bg-gray-900/80 border-r border-gray-800">
            <div class="p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center p-2 text-gray-300 hover:text-white rounded-lg hover:bg-gray-800/50 transition {{ request()->routeIs('dashboard') ? 'bg-gray-800/50 text-white' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span class="ml-3">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.categories.index') }}" class="flex items-center p-2 text-gray-300 hover:text-white rounded-lg hover:bg-gray-800/50 transition {{ request()->routeIs('admin.categories.*') ? 'bg-gray-800/50 text-white' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <span class="ml-3">Categories</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.products.index') }}" class="flex items-center p-2 text-gray-300 hover:text-white rounded-lg hover:bg-gray-800/50 transition {{ request()->routeIs('admin.products.*') ? 'bg-gray-800/50 text-white' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                            <span class="ml-3">Products</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="flex items-center p-2 text-gray-300 hover:text-white rounded-lg hover:bg-gray-800/50 transition {{ request()->routeIs('admin.users.*') ? 'bg-gray-800/50 text-white' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <span class="ml-3">Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.orders.index') }}" class="flex items-center p-2 text-gray-300 hover:text-white rounded-lg hover:bg-gray-800/50 transition {{ request()->routeIs('admin.orders.*') ? 'bg-gray-800/50 text-white' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <span class="ml-3">Orders</span>
                        </a>
                    </li>
                </ul>
            </div>
        </aside>
        @endif

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <!-- Page Heading -->
            <div class="mb-8">
                <div class="flex justify-between items-center">
                    <!-- Dynamic Header Title -->
                    <h1 class="text-2xl font-bold text-white">
                        
                    </h1>
                    
                    <!-- For regular users, show back button instead of add button -->
                    @if(Auth::user()->role === 'user')
                        <button onclick="window.history.back()" class="gradient-btn text-white font-bold py-2 px-4 rounded flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back
                        </button>
                    @else
                        <!-- Add Button (only shows if $addRoute is provided and user is admin) -->
                        @isset($addRoute)
                            <a href="{{ $addRoute }}" class="gradient-btn text-white font-bold py-2 px-4 rounded">
                                {{ $addLabel ?? str_replace('Admin ', '', $header ?? 'Item') }}
                            </a>
                        @endisset
                    @endif
                </div>
                
                <!-- Breadcrumb -->
                <div class="flex space-x-4 text-sm text-gray-400 mt-2">
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('dashboard') }}" class="hover:text-white transition">Dashboard</a>
                        <span>/</span>
                    @else
                        <a href="javascript:history.back()" class="hover:text-white transition">Back</a>
                        <span>/</span>
                    @endif
                    <span class="text-white">
                        @isset($headerTitle)
                            {{ $headerTitle }}
                        @else
                            {{ $header ?? 'Current Page' }}
                        @endisset
                    </span>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-900/50 border border-green-700 text-green-100 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-900/50 border border-red-700 text-red-100 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Page Content -->
            <div class="bg-white/5 rounded-2xl backdrop-blur border border-white/10 p-6">
                {{ $slot }}
            </div>
        </main>
    </div>
    
    @stack('scripts')
</body>
</html>