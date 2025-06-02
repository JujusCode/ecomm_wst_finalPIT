<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset(path: 'images/logo.png') }}" type="image/png">

    <title>ByteX - My Orders</title>
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
        }
        
        .backdrop-blur {
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        
        .animated-gradient {
            background-size: 200% 200%;
            animation: gradientAnimation 8s ease infinite;
        }
        
        @keyframes gradientAnimation {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
    </style>
</head>
<body class="min-h-screen text-white">
    <nav class="bg-black/30 backdrop-blur-lg px-6 py-4 rounded-xl relative z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-500 to-purple-600">ByteX</a>
            
            <div class="hidden md:block w-1/3">
                <form action="{{ route('products.search') }}" method="GET">
                    <input type="text" name="query" class="w-full bg-gray-800/70 text-white px-4 py-2 rounded-lg" placeholder="Search..." required>
                </form>
            </div>
            
            <div class="flex items-center gap-6">
            @if (Route::has('login'))
                @auth
                    <!-- Shopping Cart for logged-in users -->
                    @php
                        $cartCount = Auth::user()->cartItems()->sum('quantity');
                    @endphp
                    
                    <a href="{{ route('cart.index') }}" class="relative gradient-btn text-white p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        @if($cartCount > 0)
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full cart-count">{{ $cartCount }}</span>
                        @else
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full cart-count hidden">0</span>
                        @endif
                    </a>

                    <!-- User Dropdown for logged-in users -->
                    <div x-data="{ open: false }" @click.away="open = false" class="relative">
                        <button @click="open = !open" class="inline-flex items-center space-x-2 text-white hover:text-gray-300 transition">
                            <div class="flex items-center">
                                <!-- Display user avatar -->
                                @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-8 h-8 rounded-full object-cover mr-2" alt="User Avatar">
                            @else
                                <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mr-4">
                                    <span class="text-gray-500 text-2xl">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                            @endif                                    <div>{{ auth()->user()->name }}</div>
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
                            <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-700 hover:text-white">
                                {{ __('My Orders') }}
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-200 hover:bg-gray-700 hover:text-white">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Guest links -->
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-white transition">Login</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="text-gray-300 hover:text-white transition">Sign up</a>
                    @endif
                    
                    <a href="{{ route('login') }}" class="relative gradient-btn text-white p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                    </a>
                @endauth
            @endif
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <div class="flex space-x-4 mb-8">
            <a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition duration-150">Home</a>
            <span class="text-gray-600">/</span>
            <a href="#" class="text-white font-medium">My Orders</a>
        </div>
    
        <!-- Orders Content -->
        <div class="py-8 px-4 bg-white/5 rounded-2xl backdrop-blur border border-white/10">
            <h2 class="text-3xl font-bold mb-8 text-center">My Orders</h2>
            
            @if($orders->isEmpty())
                <div class="text-center py-12">
                    <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-byte-dark-900/80 border border-byte-purple-500/30 shadow-glow mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-byte-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">No Orders Yet</h3>
                    <p class="text-gray-400 mb-6">You haven't placed any orders yet.</p>
                    <a href="{{ route('products.index') }}" class="px-6 py-3 rounded-lg bg-gradient-to-r from-byte-purple-600 to-blue-600 hover:from-byte-purple-500 hover:to-blue-500 shadow-glow transition duration-300 focus:outline-none focus:ring-2 focus:ring-byte-purple-500 focus:ring-opacity-50">
                        Start Shopping
                    </a>
                </div>
            @else
                <div class="space-y-6">
                    @foreach($orders as $order)
                        <div x-data="{ open: false }" class="bg-white/5 rounded-xl border border-white/10 overflow-hidden">
                            <!-- Order Header -->
                            <div @click="open = !open" class="flex flex-col md:flex-row md:items-center justify-between p-4 md:p-6 cursor-pointer hover:bg-white/5 transition">
                                <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-8">
                                    <div>
                                        <span class="text-gray-400 text-sm">Order #</span>
                                        <span class="font-medium ml-1">{{ $order->id }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-400 text-sm">Date:</span>
                                        <span class="font-medium ml-1">{{ $order->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-400 text-sm">Total:</span>
                                        <span class="font-medium ml-1">${{ number_format($order->total, 2) }}</span>
                                    </div>
                                    <div class="mt-2 md:mt-0">
                                        <span class="px-3 py-1 text-xs rounded-full 
                                            @if($order->status == 'processing') bg-blue-500/20 text-blue-300
                                            @elseif($order->status == 'shipped') bg-yellow-500/20 text-yellow-300
                                            @elseif($order->status == 'delivered') bg-green-500/20 text-green-300
                                            @elseif($order->status == 'cancelled') bg-red-500/20 text-red-300
                                            @else bg-gray-500/20 text-gray-300
                                            @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center mt-4 md:mt-0">
                                    <button class="text-byte-purple-400 hover:text-byte-purple-300 flex items-center gap-1 text-sm">
                                        <span>View Details</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Order Details -->
                            <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 transform -translate-y-4"
                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 transform translate-y-0"
                                x-transition:leave-end="opacity-0 transform -translate-y-4"
                                class="border-t border-white/10 p-4 md:p-6">
                                
                                <!-- Items -->
                                <div class="mb-6">
                                    <h3 class="text-lg font-semibold mb-3">Order Items</h3>
                                    <div class="space-y-3">
                                        @foreach($order->items as $item)
                                            <div class="flex justify-between items-center">
                                                <div class="flex items-center space-x-3">
                                                    <div class="flex-shrink-0 w-12 h-12 bg-byte-dark-900/80 rounded-lg flex items-center justify-center border border-byte-purple-500/30 shadow-glow-sm">
                                                        @if($item->product->image)
                                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="max-w-full h-auto max-h-12 object-contain">
                                                        @else
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-byte-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path d="M6 12H18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                                <path d="M12 6L12 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                                                <rect x="2" y="4" width="20" height="16" rx="4" stroke="currentColor" stroke-width="2"/>
                                                            </svg>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <h3 class="font-medium">{{ $item->product->name }}</h3>
                                                        <p class="text-sm text-gray-400">Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                                                    </div>
                                                </div>
                                                <div class="font-medium">${{ number_format($item->price * $item->quantity, 2) }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                
                                <!-- Shipping & Payment Info -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h3 class="text-lg font-semibold mb-3">Shipping Address</h3>
                                        <div class="text-sm space-y-1 text-gray-300">
                                            <p>{{ $order->first_name }}</p>
                                            @if($order->company_name)
                                                <p>{{ $order->company_name }}</p>
                                            @endif
                                            <p>{{ $order->street_address }}</p>
                                            @if($order->apartment)
                                                <p>{{ $order->apartment }}</p>
                                            @endif
                                            <p>{{ $order->town_city }}</p>
                                            <p>{{ $order->phone }}</p>
                                            <p>{{ $order->email }}</p>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <h3 class="text-lg font-semibold mb-3">Order Information</h3>
                                        <div class="space-y-2">
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-400">Payment Method:</span>
                                                <span class="font-medium">{{ ucfirst($order->payment_method) }}</span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-400">Subtotal:</span>
                                                <span class="font-medium">${{ number_format($order->items->sum(function($item) { return $item->price * $item->quantity; }), 2) }}</span>
                                            </div>
                                            <div class="flex justify-between text-sm">
                                                <span class="text-gray-400">Total:</span>
                                                <span class="font-medium">${{ number_format($order->total, 2) }}</span>
                                            </div>
                                            @if($order->notes)
                                                <div class="mt-2 pt-2 border-t border-white/10">
                                                    <span class="text-gray-400 text-sm">Order Notes:</span>
                                                    <p class="text-sm mt-1">{{ $order->notes }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex justify-end mt-6 pt-4 border-t border-white/10">
                                    <a href="{{ route('orders.download-pdf', ['order' => $order->id]) }}" class="flex items-center justify-center space-x-2 px-4 py-2 rounded-lg border border-white/20 bg-white/5 hover:bg-white/10 transition duration-300 focus:outline-none focus:ring-2 focus:ring-byte-purple-500 focus:ring-opacity-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                        </svg>
                                        <span class="text-sm">Download Receipt</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-8">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </main>
</body>
</html>