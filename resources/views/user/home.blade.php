{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ByteX - Your Tech Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{
            margin: 0;
            padding:0;
        }
        body {
            font-family: 'Space Grotesk', sans-serif;
            background-color: #080b14;
            color: #f3f4f6;
        }
        
        .gradient-btn {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            transition: all 0.3s ease;
        }
        
        .gradient-btn:hover {
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.3);
        }
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
        }
        
        .glow {
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.5);
        }
        
        .banner-gradient {
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        }
        
        .small-banner-gradient-1 {
            background: linear-gradient(135deg, #9333ea, #4f46e5);
        }
        
        .small-banner-gradient-2 {
            background: linear-gradient(135deg, #0891b2, #0284c7);
        }
        
        .small-banner-gradient-3 {
            background: linear-gradient(135deg, #f59e0b, #d97706);
        }
        
        .benefit-gradient {
            background: linear-gradient(135deg, #1e3a8a, #3b82f6);
        }
    </style>
</head>
<body>
    <nav class="bg-black/30 backdrop-blur-lg px-6 py-4 rounded-xl">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-500 to-purple-600">ByteX</div>
            
            <div class="hidden md:block w-1/3">
                <input type="text" class="w-full bg-gray-800/70 text-white px-4 py-2 rounded-lg" placeholder="Search...">
            </div>
            
            <div class="flex items-center gap-6">
            @if (Route::has('login'))
                @auth
                    <!-- Shopping Cart -->
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
    
                                        <!-- User Dropdown - Dark Theme Version -->
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

    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-6 py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            <div class="banner-gradient flex-1 rounded-2xl p-8 relative overflow-hidden glow">
                <div class="max-w-md">
                    <p class="text-blue-200 mb-2">Over 2,000 Products</p>
                    <h2 class="text-4xl font-bold mb-6">Best Deals on ByteX</h2>
                    <button class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-6 py-2 rounded-lg transition">Explore Now</button>
                </div>
                <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-blue-600/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-8 right-8">
                    <img src="/api/placeholder/300/300" alt="Featured Product" class="max-h-40 object-contain">
                </div>
            </div>
            
            <div class="flex-1 flex flex-col gap-4">
                <div class="small-banner-gradient-1 rounded-2xl p-6 relative overflow-hidden h-1/3">
                    <h3 class="text-xl font-medium mb-2">RGB Liquid CPU Cooler</h3>
                    <button class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-4 py-1 rounded-lg text-sm transition">View</button>
                    <img src="/api/placeholder/120/120" alt="CPU Cooler" class="absolute bottom-2 right-4 max-h-16 object-contain">
                </div>
                
                <div class="small-banner-gradient-2 rounded-2xl p-6 relative overflow-hidden h-1/3">
                    <h3 class="text-xl font-medium mb-2">Gaming Accessories</h3>
                    <button class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-4 py-1 rounded-lg text-sm transition">View</button>
                    <img src="/api/placeholder/120/120" alt="Gaming Accessories" class="absolute bottom-2 right-4 max-h-16 object-contain">
                </div>
                
                <div class="small-banner-gradient-3 rounded-2xl p-6 relative overflow-hidden h-1/3">
                    <h3 class="text-xl font-medium mb-2">ASUS FHD Gaming Laptop</h3>
                    <p class="text-sm text-amber-100 mb-2">Powerful, sleek, immersive.</p>
                    <button class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white px-4 py-1 rounded-lg text-sm transition">Shop Now</button>
                    <img src="/api/placeholder/120/120" alt="Gaming Laptop" class="absolute bottom-2 right-4 max-h-16 object-contain">
                </div>
            </div>
        </div>
    </div>

        <!-- Products Section -->
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold">Our Products</h2>
            <div class="flex gap-2">
                <button class="bg-gray-800 hover:bg-gray-700 p-2 rounded-full transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button class="bg-gray-800 hover:bg-gray-700 p-2 rounded-full transition">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Product 1 -->
            <div class="bg-gray-800/50 rounded-lg overflow-hidden border border-gray-700/50 backdrop-blur-sm flex flex-col">
                <div class="relative">
                    <div class="bg-gray-700 p-4 aspect-square flex items-center justify-center">
                        <img src="/api/placeholder/180/180" alt="Breed Dry Dog Food" class="w-full h-full object-contain">
                    </div>
                    <button class="absolute top-2 right-2 bg-black/50 hover:bg-black/70 p-2 rounded-full transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <h3 class="text-md font-medium mb-1 truncate">Breed Dry Dog Food</h3>
                    <p class="text-lg font-bold mb-1">$100</p>
                    <div class="flex items-center mb-2">
                        <div class="flex text-amber-400">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span class="text-gray-400">★</span>
                        </div>
                        <span class="text-gray-400 text-xs ml-2">(35)</span>
                    </div>
                    <div class="flex gap-2 mt-auto">
                        <div class="w-4 h-4 rounded-full bg-red-500"></div>
                        <div class="w-4 h-4 rounded-full bg-blue-500"></div>
                    </div>
                </div>
            </div>
            
            <!-- Product 2 -->
            <div class="bg-gray-800/50 rounded-lg overflow-hidden border border-gray-700/50 backdrop-blur-sm flex flex-col">
                <div class="relative">
                    <div class="bg-gray-700 p-4 aspect-square flex items-center justify-center">
                        <img src="/api/placeholder/180/180" alt="CANON EOS DSLR Camera" class="w-full h-full object-contain">
                    </div>
                    <button class="absolute top-2 right-2 bg-black/50 hover:bg-black/70 p-2 rounded-full transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                    <button class="absolute bottom-0 w-full bg-black/60 hover:bg-black/80 text-white text-sm py-2 transition text-center">
                        Add To Cart
                    </button>
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <h3 class="text-md font-medium mb-1 truncate">CANON EOS DSLR Camera</h3>
                    <p class="text-lg font-bold mb-1">$360</p>
                    <div class="flex items-center mb-2">
                        <div class="flex text-amber-400">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span class="text-gray-400">★</span>
                        </div>
                        <span class="text-gray-400 text-xs ml-2">(95)</span>
                    </div>
                    <div class="flex gap-2 mt-auto"></div>
                </div>
            </div>
            
            <!-- Product 3 -->
            <div class="bg-gray-800/50 rounded-lg overflow-hidden border border-gray-700/50 backdrop-blur-sm flex flex-col">
                <div class="relative">
                    <div class="bg-gray-700 p-4 aspect-square flex items-center justify-center">
                        <img src="/api/placeholder/180/180" alt="ASUS FHD Gaming Laptop" class="w-full h-full object-contain">
                    </div>
                    <button class="absolute top-2 right-2 bg-black/50 hover:bg-black/70 p-2 rounded-full transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <h3 class="text-md font-medium mb-1 truncate">ASUS FHD Gaming Laptop</h3>
                    <p class="text-lg font-bold mb-1">$750</p>
                    <div class="flex items-center mb-2">
                        <div class="flex text-amber-400">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                        </div>
                        <span class="text-gray-400 text-xs ml-2">(325)</span>
                    </div>
                    <div class="flex gap-2 mt-auto"></div>
                </div>
            </div>
            
            <!-- Product 4 -->
            <div class="bg-gray-800/50 rounded-lg overflow-hidden border border-gray-700/50 backdrop-blur-sm flex flex-col">
                <div class="relative">
                    <div class="bg-gray-700 p-4 aspect-square flex items-center justify-center">
                        <img src="/api/placeholder/180/180" alt="Curology Product Set" class="w-full h-full object-contain">
                    </div>
                    <button class="absolute top-2 right-2 bg-black/50 hover:bg-black/70 p-2 rounded-full transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <h3 class="text-md font-medium mb-1 truncate">Curology Product Set</h3>
                    <p class="text-lg font-bold mb-1">$500</p>
                    <div class="flex items-center mb-2">
                        <div class="flex text-amber-400">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                        </div>
                        <span class="text-gray-400 text-xs ml-2">(145)</span>
                    </div>
                    <div class="flex gap-2 mt-auto"></div>
                </div>
            </div>
            
            <!-- Product 5 -->
            <div class="bg-gray-800/50 rounded-lg overflow-hidden border border-gray-700/50 backdrop-blur-sm flex flex-col">
                <div class="relative">
                    <div class="bg-gray-700 p-4 aspect-square flex items-center justify-center">
                        <img src="/api/placeholder/180/180" alt="Kids Electric Car" class="w-full h-full object-contain">
                    </div>
                    <span class="absolute top-2 left-2 bg-black text-white text-xs px-2 py-1 rounded font-medium">NEW</span>
                    <button class="absolute top-2 right-2 bg-black/50 hover:bg-black/70 p-2 rounded-full transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <h3 class="text-md font-medium mb-1 truncate">Kids Electric Car</h3>
                    <p class="text-lg font-bold mb-1">$960</p>
                    <div class="flex items-center mb-2">
                        <div class="flex text-amber-400">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                        </div>
                        <span class="text-gray-400 text-xs ml-2">(65)</span>
                    </div>
                    <div class="flex gap-2 mt-auto">
                        <div class="w-4 h-4 rounded-full bg-red-500"></div>
                        <div class="w-4 h-4 rounded-full bg-blue-500"></div>
                    </div>
                </div>
            </div>
            
            <!-- Product 6 -->
            <div class="bg-gray-800/50 rounded-lg overflow-hidden border border-gray-700/50 backdrop-blur-sm flex flex-col">
                <div class="relative">
                    <div class="bg-gray-700 p-4 aspect-square flex items-center justify-center">
                        <img src="/api/placeholder/180/180" alt="Jr. Zoom Soccer Cleats" class="w-full h-full object-contain">
                    </div>
                    <span class="absolute top-2 left-2 bg-black text-white text-xs px-2 py-1 rounded font-medium">NEW</span>
                    <button class="absolute top-2 right-2 bg-black/50 hover:bg-black/70 p-2 rounded-full transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <h3 class="text-md font-medium mb-1 truncate">Jr. Zoom Soccer Cleats</h3>
                    <p class="text-lg font-bold mb-1">$160</p>
                    <div class="flex items-center mb-2">
                        <div class="flex text-amber-400">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                        </div>
                        <span class="text-gray-400 text-xs ml-2">(35)</span>
                    </div>
                    <div class="flex gap-2 mt-auto">
                        <div class="w-4 h-4 rounded-full bg-yellow-400"></div>
                        <div class="w-4 h-4 rounded-full bg-red-500"></div>
                    </div>
                </div>
            </div>
            
            <!-- Product 7 -->
            <div class="bg-gray-800/50 rounded-lg overflow-hidden border border-gray-700/50 backdrop-blur-sm flex flex-col">
                <div class="relative">
                    <div class="bg-gray-700 p-4 aspect-square flex items-center justify-center">
                        <img src="/api/placeholder/180/180" alt="GP11 Shooter USB Gamepad" class="w-full h-full object-contain">
                    </div>
                    <button class="absolute top-2 right-2 bg-black/50 hover:bg-black/70 p-2 rounded-full transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <h3 class="text-md font-medium mb-1 truncate">GP11 Shooter USB Gamepad</h3>
                    <p class="text-lg font-bold mb-1">$660</p>
                    <div class="flex items-center mb-2">
                        <div class="flex text-amber-400">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span class="text-gray-400">★</span>
                        </div>
                        <span class="text-gray-400 text-xs ml-2">(55)</span>
                    </div>
                    <div class="flex gap-2 mt-auto">
                        <div class="w-4 h-4 rounded-full bg-black"></div>
                        <div class="w-4 h-4 rounded-full bg-amber-500"></div>
                    </div>
                </div>
            </div>
            
            <!-- Product 8 -->
            <div class="bg-gray-800/50 rounded-lg overflow-hidden border border-gray-700/50 backdrop-blur-sm flex flex-col">
                <div class="relative">
                    <div class="bg-gray-700 p-4 aspect-square flex items-center justify-center">
                        <img src="/api/placeholder/180/180" alt="Quilted Satin Jacket" class="w-full h-full object-contain">
                    </div>
                    <span class="absolute top-2 left-2 bg-black text-white text-xs px-2 py-1 rounded font-medium">NEW</span>
                    <button class="absolute top-2 right-2 bg-black/50 hover:bg-black/70 p-2 rounded-full transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </div>
                <div class="p-4 flex flex-col flex-grow">
                    <h3 class="text-md font-medium mb-1 truncate">Quilted Satin Jacket</h3>
                    <p class="text-lg font-bold mb-1">$660</p>
                    <div class="flex items-center mb-2">
                        <div class="flex text-amber-400">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span>
                        </div>
                        <span class="text-gray-400 text-xs ml-2">(55)</span>
                    </div>
                    <div class="flex gap-2 mt-auto">
                        <div class="w-4 h-4 rounded-full bg-green-700"></div>
                        <div class="w-4 h-4 rounded-full bg-red-500"></div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="flex justify-center mt-8">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition">View All Products</button>
        </div>
    </div>

    <!-- Benefits Section -->
    <div class="max-w-7xl mx-auto px-6 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="benefit-gradient rounded-xl p-6 text-center">
                <div class="bg-black/30 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold mb-2">FREE AND FAST DELIVERY</h3>
                <p class="text-blue-100">Free delivery for all orders over $140</p>
            </div>
            
            <div class="benefit-gradient rounded-xl p-6 text-center">
                <div class="bg-black/30 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold mb-2">24/7 CUSTOMER SERVICE</h3>
                <p class="text-blue-100">Friendly 24/7 customer support</p>
            </div>
            
            <div class="benefit-gradient rounded-xl p-6 text-center">
                <div class="bg-black/30 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold mb-2">MONEY BACK GUARANTEE</h3>
                <p class="text-blue-100">We return money within 30 days</p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-black/50 backdrop-blur-lg mt-16 py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 mb-12">
                <div>
                    <h4 class="text-lg font-bold mb-4">ByteX</h4>
                    <p class="text-gray-400 mb-2">Subscribe to our newsletter</p>
                    <p class="text-gray-400 mb-4">Get 10% off your first order</p>
                    <div class="flex">
                        <input type="email" placeholder="Email" class="bg-gray-800 text-white px-4 py-2 rounded-l-lg w-full">
                        <button class="gradient-btn px-3 py-2 rounded-r-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-4">Support</h4>
                    <p class="text-gray-400 mb-2">Cagayan de Oro City</p>
                    <p class="text-gray-400 mb-2">support@bytex.com</p>
                    <p class="text-gray-400 mb-2">+1-601-888-9999</p>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-4">Account</h4>
                    <a href="#" class="text-gray-400 block mb-2 hover:text-white transition">My Account</a>
                    <a href="#" class="text-gray-400 block mb-2 hover:text-white transition">Login / Register</a>
                    <a href="#" class="text-gray-400 block mb-2 hover:text-white transition">Cart</a>
                    <a href="#" class="text-gray-400 block mb-2 hover:text-white transition">Wishlist</a>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-4">Quick Links</h4>
                    <a href="#" class="text-gray-400 block mb-2 hover:text-white transition">Privacy Policy</a>
                    <a href="#" class="text-gray-400 block mb-2 hover:text-white transition">Terms of Use</a>
                    <a href="#" class="text-gray-400 block mb-2 hover:text-white transition">FAQ</a>
                    <a href="#" class="text-gray-400 block mb-2 hover:text-white transition">Contact</a>
                </div>
                
                <div>
                    <h4 class="text-lg font-bold mb-4">Download App</h4>
                    <p class="text-gray-400 mb-4">Save $3 with App New User Only</p>
                    <div class="flex gap-2 mb-4">
                        <img src="/api/placeholder/80/80" alt="QR Code" class="w-20 h-20">
                        <div class="flex flex-col gap-2">
                            <img src="/api/placeholder/120/40" alt="Google Play" class="h-8">
                            <img src="/api/placeholder/120/40" alt="App Store" class="h-8">
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M23.998 12c0-6.628-5.372-12-11.999-12C5.372 0 0 5.372 0 12c0 5.988 4.388 10.952 10.124 11.852v-8.384H7.078v-3.469h3.046V9.356c0-3.008 1.792-4.669 4.532-4.669 1.313 0 2.686.234 2.686.234v2.953H15.83c-1.49 0-1.955.925-1.955 1.874V12h3.328l-.532 3.469h-2.796v8.384c5.736-.9 10.124-5.864 10.124-11.853z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-800 pt-6 text-center text-gray-400">
                <p>© 2025 ByteX. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html> --}}