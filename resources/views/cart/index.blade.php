<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ByteX - Best Tech Deals</title>
    <link rel="icon" href="{{ asset(path: 'images/logo.png') }}" type="image/png">

    <title>ByteX - Cart</title>
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
                                    <div class="flex items-center">
                                        <!-- Display user avatar -->
                                        @if(auth()->user()->avatar)
                                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-8 h-8 rounded-full object-cover mr-2" alt="User Avatar">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center mr-4">
                                            <span class="text-gray-500 text-2xl">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                        </div>
                                    @endif                                            <div>{{ auth()->user()->name }}</div>
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
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <div class="flex space-x-4 mb-8">
            <a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition duration-150">Home</a>
            <span class="text-gray-600">/</span>
            <a href="#" class="text-white font-medium">Cart</a>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div class="bg-green-500/20 border border-green-500/50 text-green-100 px-4 py-3 rounded mb-6 flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button class="text-green-100" onclick="this.parentElement.style.display='none'">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-500/20 border border-red-500/50 text-red-100 px-4 py-3 rounded mb-6 flex items-center justify-between">
                <span>{{ session('error') }}</span>
                <button class="text-red-100" onclick="this.parentElement.style.display='none'">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Cart Content -->
        <div class="space-y-6">
            @if(count($cartItems) > 0)
                <!-- Header -->
                <div class="grid grid-cols-12 gap-4 px-6 py-3 rounded-xl bg-white/5 backdrop-blur border border-white/10">
                    <div class="col-span-6 md:col-span-6 font-medium">Product</div>
                    <div class="col-span-2 md:col-span-2 font-medium">Price</div>
                    <div class="col-span-2 md:col-span-2 font-medium">Quantity</div>
                    <div class="col-span-2 md:col-span-2 font-medium text-right">Subtotal</div>
                </div>

                <!-- Cart Items -->
                <div class="space-y-4">
                    @foreach($cartItems as $item)
                        <div class="grid grid-cols-12 gap-4 items-center px-6 py-4 rounded-xl bg-white/5 hover:bg-white/10 backdrop-blur border border-white/10 transition duration-300">
                            <div class="col-span-6 md:col-span-6 flex items-center space-x-4">
                                <div class="flex-shrink-0 w-16 h-16 bg-byte-dark-900/80 rounded-lg flex items-center justify-center border border-byte-purple-500/30 shadow-glow-sm">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="max-w-full h-auto max-h-16 object-contain">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-byte-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path d="M6 12H18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            <path d="M12 6L12 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                            <rect x="2" y="4" width="20" height="16" rx="4" stroke="currentColor" stroke-width="2"/>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <h3 class="font-medium">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-400">{{ Str::limit($item->product->description, 50) }}</p>
                                </div> 
                                <form method="POST" action="{{ route('cart.destroy', $item) }}" class="ml-auto">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-300 transition" title="Remove item">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            <div class="col-span-2 md:col-span-2 font-medium">
                                <div class="text-byte-purple-300">${{ number_format($item->product->price, 2) }}</div>
                            </div>
                            <div class="col-span-2 md:col-span-2">
                                <form method="POST" action="{{ route('cart.update', $item) }}" class="update-quantity-form">
                                    @csrf
                                    @method('PATCH')
                                    <div class="flex items-center space-x-1 bg-byte-dark-900/80 rounded-lg border border-white/10 p-1 max-w-[120px]">
                                        <button type="button" class="decrement-btn w-8 h-8 flex items-center justify-center rounded-md hover:bg-byte-purple-700/50 transition duration-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                            </svg>
                                        </button>
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="quantity-input w-full bg-transparent text-center focus:outline-none font-medium">
                                        <button type="button" class="increment-btn w-8 h-8 flex items-center justify-center rounded-md hover:bg-byte-purple-700/50 transition duration-150">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6" />
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-span-2 md:col-span-2 text-right font-medium">
                                ${{ number_format($item->product->price * $item->quantity, 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-between space-y-4 sm:space-y-0 sm:space-x-4 pt-4">
                    <a href="{{ route('home') }}" class="px-6 py-3 rounded-lg border border-white/20 bg-white/5 hover:bg-white/10 backdrop-blur transition duration-300 focus:outline-none focus:ring-2 focus:ring-byte-purple-500 focus:ring-opacity-50">
                        <span class="flex items-center justify-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            <span>Return To Shop</span>
                        </span>
                    </a>
                    
                    <div class="flex gap-4">
                        <button id="update-cart-btn" class="px-6 py-3 rounded-lg border border-white/20 bg-white/5 hover:bg-white/10 backdrop-blur transition duration-300 focus:outline-none focus:ring-2 focus:ring-byte-purple-500 focus:ring-opacity-50">
                            <span class="flex items-center justify-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                <span>Update Cart</span>
                            </span>
                        </button>
                        
                        <form method="POST" action="{{ route('cart.clear') }}">
                            @csrf
                            <button type="submit" class="px-6 py-3 rounded-lg border border-red-400/20 bg-red-500/10 hover:bg-red-500/20 backdrop-blur transition duration-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                                <span class="flex items-center justify-center space-x-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    <span>Clear Cart</span>
                                </span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Cart Summary -->
                <div class="flex justify-end mt-8">
                    <div class="w-full md:w-96 rounded-xl bg-white/5 hover:bg-white/8 backdrop-blur border border-white/10 p-6 shadow-lg animated-gradient transition duration-500" style="background-image: linear-gradient(45deg, rgba(30, 30, 63, 0.8) 0%, rgba(59, 61, 135, 0.8) 100%);">
                        <h2 class="text-xl font-semibold mb-6 pb-2 border-b border-white/10">Cart Total</h2>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-gray-300">Subtotal:</span>
                                <span class="font-medium">${{ number_format($total, 2) }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-300">Shipping:</span>
                                <span class="text-byte-purple-300 font-medium">Free</span>
                            </div>
                            
                            <div class="h-px bg-gradient-to-r from-transparent via-white/20 to-transparent my-4"></div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-300">Total:</span>
                                <span class="font-semibold text-xl">${{ number_format($total, 2) }}</span>
                            </div>
                            
                            <button class="w-full mt-6 px-6 py-3 rounded-lg bg-gradient-to-r from-byte-purple-600 to-blue-600 hover:from-byte-purple-500 hover:to-blue-500 shadow-glow transition duration-300 focus:outline-none focus:ring-2 focus:ring-byte-purple-500 focus:ring-opacity-50 transform hover:-translate-y-0.5">
                                <a href="{{ route('checkout.index') }}" >Proceed to checkout</a>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Cart State -->
                <div class="text-center py-16 px-4 bg-white/5 rounded-2xl backdrop-blur border border-white/10">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-byte-dark-900/80 border border-byte-purple-500/30 shadow-glow mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-byte-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold mb-2">Your cart is empty</h2>
                    <p class="text-gray-400 mb-8">Looks like you haven't added any products to your cart yet.</p>
                    <a href="{{ route('home') }}" class="px-6 py-3 rounded-lg bg-gradient-to-r from-byte-purple-600 to-blue-600 hover:from-byte-purple-500 hover:to-blue-500 shadow-glow transition duration-300 focus:outline-none focus:ring-2 focus:ring-byte-purple-500 focus:ring-opacity-50">
                        Continue Shopping
                    </a>
                </div>
            @endif
        </div>
    </main>

    <!-- JavaScript for quantity control -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const updateQuantityForms = document.querySelectorAll('.update-quantity-form');
            
            updateQuantityForms.forEach(form => {
                const quantityInput = form.querySelector('.quantity-input');
                const decrementBtn = form.querySelector('.decrement-btn');
                const incrementBtn = form.querySelector('.increment-btn');
                
                decrementBtn.addEventListener('click', () => {
                    const currentValue = parseInt(quantityInput.value);
                    if (currentValue > 1) {
                        quantityInput.value = currentValue - 1;
                    }
                });
                
                incrementBtn.addEventListener('click', () => {
                    const currentValue = parseInt(quantityInput.value);
                    quantityInput.value = currentValue + 1;
                });
            });
            
            // Update Cart button functionality
            document.getElementById('update-cart-btn').addEventListener('click', function() {
                const updateForms = document.querySelectorAll('.update-quantity-form');
                
                // Create a promise for each form submission
                const updatePromises = Array.from(updateForms).map(form => {
                    return new Promise((resolve, reject) => {
                        // Create a FormData object from the form
                        const formData = new FormData(form);
                        
                        // Send the form data using fetch
                        fetch(form.action, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                resolve();
                            } else {
                                reject(new Error('Failed to update item'));
                            }
                        })
                        .catch(error => reject(error));
                    });
                });
                
                // Wait for all forms to be submitted
                Promise.all(updatePromises)
                    .then(() => {
                        // Reload the page after all updates are done
                        window.location.reload();
                    })
                    .catch(error => {
                        console.error('Error updating cart:', error);
                        alert('There was an error updating your cart. Please try again.');
                    });
            });
        });
    </script>
</body>
</html>