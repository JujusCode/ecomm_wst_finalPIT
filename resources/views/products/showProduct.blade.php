<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset(path: 'images/logo.png') }}" type="image/png">

    <title>ByteX - Best Tech Deals</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
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
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gradient-to-b from-gray-900 via-indigo-900 to-indigo-800 min-h-screen">
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

    <div class="container mx-auto px-4">
        <!-- Navigation Breadcrumb -->
        <nav class="text-sm mb-4 mt-4">
            <ul class="flex space-x-2 text-gray-300">
                <li><a href="{{ route('home') }}" class="hover:text-white">Home</a></li>
                <li><span class="mx-2">/</span></li>
                <li class="text-gray-400">{{ $product->name }}</li>
            </ul>
        </nav>
        
        <!-- Product Section -->
        <div class="flex flex-col lg:flex-row gap-8 mt-6">
            <!-- Product Image -->
            <div class="lg:w-1/2 bg-gray-800 rounded-lg p-8 flex items-center justify-center">
                @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="max-w-full h-auto max-h-80">
            @else
                <img src="/api/placeholder/400/320" alt="{{ $product->name }}" class="max-w-full h-auto max-h-80">
            @endif
            </div>
            
            <!-- Product Details -->
            <div class="lg:w-1/2">
                <h1 class="text-3xl font-bold text-white mb-2">{{ $product->name }}</h1>
                <div class="mb-4">
                    <span class="bg-{{ $product->stock > 0 ? 'blue' : 'red' }}-500 bg-opacity-20 text-{{ $product->stock > 0 ? 'blue' : 'red' }}-400 text-xs px-3 py-1 rounded-full">
                        {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                    </span>
                </div>
                <div class="mb-6">
                    <p class="text-2xl font-bold text-white">${{ number_format($product->price, 2) }}</p>
                </div>
                
                <div class="mb-8">
                    <p class="text-gray-300 text-sm">
                        {{ $product->description }}
                    </p>
                </div>
                
                @if($product->stock > 0)
                <form action="{{ route('cart.add') }}" method="POST" class="mb-8">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <!-- Quantity & Add to Cart -->
                    <div class="flex flex-wrap items-center space-x-2 mb-8">
                        <div class="flex items-center space-x-2">
                            <button type="button" onclick="decrementQuantity()" class="w-10 h-10 bg-gray-700 text-white flex items-center justify-center rounded-md hover:bg-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->stock }}" class="w-12 h-10 bg-gray-700 text-white text-center rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="validateQuantity(this, {{ $product->stock }})">
                            
                            <button type="button" onclick="incrementQuantity({{ $product->stock }})" class="w-10 h-10 bg-gray-700 text-white flex items-center justify-center rounded-md hover:bg-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        
                        <div class="flex mt-4 sm:mt-0">
                            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition">
                                Add to Cart
                            </button>
                            
                            <button type="button" onclick="buyNow()" class="ml-2 px-6 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                                Buy Now
                            </button>
                        </div>
                    </div>
                </form>

                <script>
                    function incrementQuantity(maxStock) {
                        let quantityInput = document.getElementById('quantity');
                        let currentValue = parseInt(quantityInput.value);
                        if (currentValue < maxStock) {
                            quantityInput.value = currentValue + 1;
                        }
                    }
                    
                    function decrementQuantity() {
                        let quantityInput = document.getElementById('quantity');
                        let currentValue = parseInt(quantityInput.value);
                        if (currentValue > 1) {
                            quantityInput.value = currentValue - 1;
                        }
                    }
                    
                    function validateQuantity(input, maxStock) {
                        let value = parseInt(input.value);
                        if (isNaN(value) || value < 1) {
                            input.value = 1;
                        } else if (value > maxStock) {
                            input.value = maxStock;
                        }
                    }
                    
                    function buyNow() {
                        // Create a hidden input field to indicate checkout redirect
                        const redirectInput = document.createElement('input');
                        redirectInput.type = 'hidden';
                        redirectInput.name = 'checkout_redirect';
                        redirectInput.value = '1';
                        
                        // Find the form and append the input
                        const form = document.querySelector('form[action="{{ route('cart.add') }}"]');
                        form.appendChild(redirectInput);
                        
                        // Submit the form
                        form.submit();
                    }
                </script>
            @endif
                
                <!-- Delivery Information -->
                <div class="space-y-4">
                    <div class="border border-gray-700 rounded-md p-4 flex items-center space-x-4">
                        <div class="text-blue-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-medium">Free Delivery</h3>
                            <p class="text-gray-400 text-sm">Enter your postal code for Delivery Availability</p>
                        </div>
                    </div>
                    
                    <div class="border border-gray-700 rounded-md p-4 flex items-center space-x-4">
                        <div class="text-blue-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-white font-medium">Return Delivery</h3>
                            <p class="text-gray-400 text-sm">Free 30 Days Delivery Returns. <a href="#" class="text-blue-400 hover:underline">Details</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                        <div class="flex flex-col gap-2">
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
</html>