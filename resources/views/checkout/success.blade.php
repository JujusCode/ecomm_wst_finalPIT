<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset(path: 'images/logo.png') }}" type="image/png">
    <title>ByteX - Order Success</title>
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
        
        .quantity-input::-webkit-inner-spin-button,
        .quantity-input::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
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
    <!-- Navbar -->
    <!-- Main Navigation -->
    <header class="bg-gray-900 w-full py-3">
        <nav class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center">
                <div class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-500 to-purple-600">ByteX</div>
                
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
                                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs w-5 h-5 flex items-center justify-center rounded-full">{{ $cartCount }}</span>
                                @endif
                            </a>
            
                            <!-- User Dropdown for logged-in users -->
                            <div x-data="{ open: false }" @click.away="open = false" class="relative">
                                <button @click="open = !open" class="inline-flex items-center space-x-2 text-white hover:text-gray-300 transition">
                                    <span>{{ Auth::user()->name }}</span>
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
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <div class="flex space-x-4 mb-8">
            <a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition duration-150">Home</a>
            <span class="text-gray-600">/</span>
            <a href="{{ route('checkout.index') }}" class="text-gray-400 hover:text-white transition duration-150">Checkout</a>
            <span class="text-gray-600">/</span>
            <a href="#" class="text-white font-medium">Success</a>
        </div>
    
        <!-- Success Content -->
        <div class="text-center py-16 px-4 bg-white/5 rounded-2xl backdrop-blur border border-white/10">
            <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-byte-dark-900/80 border border-green-500/30 shadow-glow mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <h2 class="text-3xl font-bold mb-2">Thank You For Your Order!</h2>
            <p class="text-gray-400 mb-6">Your order #{{ $order->id }} has been placed successfully.</p>
            
            <div class="max-w-2xl mx-auto mb-10 text-left p-6 rounded-xl bg-white/5 backdrop-blur border border-white/10">
                <h3 class="text-xl font-semibold mb-4">Order Summary</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Order Number:</span>
                        <span class="font-medium">{{ $order->id }}</span>
                    </div>
                    
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Date:</span>
                        <span class="font-medium">{{ $order->created_at->format('F d, Y') }}</span>
                    </div>
                    
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Total:</span>
                        <span class="font-medium">${{ number_format($order->total, 2) }}</span>
                    </div>
                    
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Payment Method:</span>
                        <span class="font-medium">{{ ucfirst($order->payment_method) }}</span>
                    </div>
                </div>
                
                <div class="border-t border-white/10 my-4"></div>
                
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
                
                <div class="border-t border-white/10 my-4"></div>
                
                <h3 class="text-lg font-semibold mb-3">Shipping Address</h3>
                
                <div class="text-sm space-y-1">
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
            
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ route('home') }}" class="px-6 py-3 rounded-lg bg-gradient-to-r from-byte-purple-600 to-blue-600 hover:from-byte-purple-500 hover:to-blue-500 shadow-glow transition duration-300 focus:outline-none focus:ring-2 focus:ring-byte-purple-500 focus:ring-opacity-50">
                    Continue Shopping
                </a>
                <a href="{{ route('checkout.download-pdf', ['order' => $order->id]) }}" class="px-6 py-3 rounded-lg border border-white/20 bg-white/5 hover:bg-white/10 backdrop-blur transition duration-300 focus:outline-none focus:ring-2 focus:ring-byte-purple-500 focus:ring-opacity-50">
                    <span class="flex items-center justify-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        <span>Download Receipt</span>
                    </span>
                </a>
            </div>
        </div>
    </main>
</body>
</html>