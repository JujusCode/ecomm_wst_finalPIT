<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <div class="flex space-x-4 mb-8">
            <a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition duration-150">Home</a>
            <span class="text-gray-600">/</span>
            <a href="{{ route('cart.index') }}" class="text-gray-400 hover:text-white transition duration-150">Cart</a>
            <span class="text-gray-600">/</span>
            <a href="#" class="text-white font-medium">Checkout</a>
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
    
        <!-- Checkout Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Checkout Form -->
            <div class="lg:col-span-2 space-y-6">
                <div class="p-6 rounded-xl bg-white/5 backdrop-blur border border-white/10">
                    <h2 class="text-xl font-semibold mb-6 pb-2 border-b border-white/10">Billing Information</h2>
                    
                    <form id="checkout-form" method="POST" action="{{ route('checkout.process') }}" class="space-y-4">
                        @csrf
                        
                        <!-- Personal Information -->
                        <div class="space-y-4">
                            <div>
                                <label for="first_name" class="block text-sm font-medium text-gray-300 mb-1">First Name</label>
                                <input 
                                    type="text" 
                                    id="first_name" 
                                    name="first_name" 
                                    value="{{ old('first_name') }}" 
                                    class="w-full px-4 py-3 rounded-lg bg-byte-dark-900/80 border border-white/10 focus:outline-none focus:ring-2 focus:ring-byte-purple-500 focus:border-transparent"
                                    required
                                >
                                @error('first_name')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="company_name" class="block text-sm font-medium text-gray-300 mb-1">Company Name (Optional)</label>
                                <input 
                                    type="text" 
                                    id="company_name" 
                                    name="company_name" 
                                    value="{{ old('company_name') }}" 
                                    class="w-full px-4 py-3 rounded-lg bg-byte-dark-900/80 border border-white/10 focus:outline-none focus:ring-2 focus:ring-byte-purple-500 focus:border-transparent"
                                >
                                @error('company_name')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="street_address" class="block text-sm font-medium text-gray-300 mb-1">Street Address</label>
                                <input 
                                    type="text" 
                                    id="street_address" 
                                    name="street_address" 
                                    value="{{ old('street_address') }}" 
                                    class="w-full px-4 py-3 rounded-lg bg-byte-dark-900/80 border border-white/10 focus:outline-none focus:ring-2 focus:ring-byte-purple-500 focus:border-transparent"
                                    required
                                >
                                @error('street_address')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="apartment" class="block text-sm font-medium text-gray-300 mb-1">Apartment, floor, etc. (Optional)</label>
                                <input 
                                    type="text" 
                                    id="apartment" 
                                    name="apartment" 
                                    value="{{ old('apartment') }}" 
                                    class="w-full px-4 py-3 rounded-lg bg-byte-dark-900/80 border border-white/10 focus:outline-none focus:ring-2 focus:ring-byte-purple-500 focus:border-transparent"
                                >
                                @error('apartment')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="town_city" class="block text-sm font-medium text-gray-300 mb-1">Town/City</label>
                                <input 
                                    type="text" 
                                    id="town_city" 
                                    name="town_city" 
                                    value="{{ old('town_city') }}" 
                                    class="w-full px-4 py-3 rounded-lg bg-byte-dark-900/80 border border-white/10 focus:outline-none focus:ring-2 focus:ring-byte-purple-500 focus:border-transparent"
                                    required
                                >
                                @error('town_city')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-300 mb-1">Phone Number</label>
                                <input 
                                    type="tel" 
                                    id="phone" 
                                    name="phone" 
                                    value="{{ old('phone') }}" 
                                    class="w-full px-4 py-3 rounded-lg bg-byte-dark-900/80 border border-white/10 focus:outline-none focus:ring-2 focus:ring-byte-purple-500 focus:border-transparent"
                                    required
                                >
                                @error('phone')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email Address</label>
                                <input 
                                    type="email" 
                                    id="email" 
                                    name="email" 
                                    value="{{ old('email', auth()->user()->email ?? '') }}" 
                                    class="w-full px-4 py-3 rounded-lg bg-byte-dark-900/80 border border-white/10 focus:outline-none focus:ring-2 focus:ring-byte-purple-500 focus:border-transparent"
                                    required
                                >
                                @error('email')
                                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="flex items-center mt-4">
                                <input 
                                    type="checkbox" 
                                    id="save_info" 
                                    name="save_info" 
                                    class="h-4 w-4 rounded border-white/10 text-byte-purple-600 focus:ring-byte-purple-500"
                                    {{ old('save_info') ? 'checked' : '' }}
                                >
                                <label for="save_info" class="ml-2 block text-sm text-gray-300">
                                    Save this information for faster check-out next time
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div>
                <div class="rounded-xl bg-white/5 hover:bg-white/8 backdrop-blur border border-white/10 p-6 shadow-lg animated-gradient" style="background-image: linear-gradient(45deg, rgba(30, 30, 63, 0.8) 0%, rgba(59, 61, 135, 0.8) 100%);">
                    <h2 class="text-xl font-semibold mb-6 pb-2 border-b border-white/10">Order Summary</h2>
                    
                    <div class="space-y-4">
                        <!-- Products List -->
                        <div class="space-y-3">
                            @forelse($cartItems as $item)
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
                                            <p class="text-sm text-gray-400">Qty: {{ $item->quantity }}</p>
                                        </div>
                                    </div>
                                    <div class="font-medium">${{ number_format($item->product->price * $item->quantity, 2) }}</div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <p class="text-gray-400">No items in cart</p>
                                    <a href="{{ route('home') }}" class="text-byte-purple-400 hover:text-byte-purple-300 mt-2 inline-block">Go to shop</a>
                                </div>
                            @endforelse
                        </div>
                        
                        <div class="h-px bg-gradient-to-r from-transparent via-white/20 to-transparent my-4"></div>
                        
                        <!-- Totals -->
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-300">Subtotal:</span>
                                <span class="font-medium">${{ number_format($total, 2) }}</span>
                            </div>
                            
                            <div class="flex justify-between">
                                <span class="text-gray-300">Shipping:</span>
                                <span class="text-byte-purple-300 font-medium">Free</span>
                            </div>
                        </div>
                        
                        <div class="h-px bg-gradient-to-r from-transparent via-white/20 to-transparent my-4"></div>
                        
                        <!-- Total -->
                        <div class="flex justify-between">
                            <span class="text-gray-300">Total:</span>
                            <span class="font-semibold text-xl">${{ number_format($total, 2) }}</span>
                        </div>
                        
                        <!-- Payment Methods -->
                        <div class="pt-4 space-y-3">
                            <div class="flex items-center justify-between bg-byte-dark-900/80 rounded-lg px-4 py-3 border border-white/10">
                                <div class="flex items-center">
                                    <input 
                                        type="radio" 
                                        id="payment_bank" 
                                        name="payment_method" 
                                        value="bank" 
                                        class="h-4 w-4 text-byte-purple-600 focus:ring-byte-purple-500"
                                        form="checkout-form"
                                        checked
                                    >
                                    <label for="payment_bank" class="ml-2 block text-sm font-medium text-white">Bank</label>
                                </div>
                                <div class="flex space-x-2">
                                    <div class="w-8 h-5 bg-red-500 rounded"></div>
                                    <div class="w-8 h-5 bg-yellow-500 rounded"></div>
                                    <div class="w-8 h-5 bg-orange-500 rounded"></div>
                                </div>
                            </div>
                            
                            <div class="flex items-center bg-byte-dark-900/80 rounded-lg px-4 py-3 border border-white/10">
                                <input 
                                    type="radio" 
                                    id="payment_cash" 
                                    name="payment_method" 
                                    value="cash" 
                                    class="h-4 w-4 text-byte-purple-600 focus:ring-byte-purple-500"
                                    form="checkout-form"
                                >
                                <label for="payment_cash" class="ml-2 block text-sm font-medium text-white">Cash on delivery</label>
                            </div>
                        </div>
                        
                        <!-- Coupon Code -->
                        <div class="flex space-x-2 mt-4">
                            <input 
                                type="text" 
                                name="coupon_code" 
                                id="coupon_code" 
                                placeholder="Coupon Code" 
                                class="flex-1 px-4 py-3 rounded-lg bg-byte-dark-900/80 border border-white/10 focus:outline-none focus:ring-2 focus:ring-byte-purple-500 focus:border-transparent"
                                form="checkout-form"
                            >
                            <button 
                                type="button" 
                                id="apply-coupon" 
                                class="px-4 py-3 rounded-lg bg-gradient-to-r from-byte-purple-600 to-blue-600 hover:from-byte-purple-500 hover:to-blue-500 shadow-glow transition duration-300 focus:outline-none focus:ring-2 focus:ring-byte-purple-500 focus:ring-opacity-50"
                            >
                                Apply Coupon
                            </button>
                        </div>
                        
                        <!-- Checkout Button - Fixed to use the form submit instead of direct link -->
                        <button 
                            type="submit" 
                            form="checkout-form" 
                            class="w-full mt-6 px-6 py-3 rounded-lg bg-gradient-to-r from-byte-purple-600 to-blue-600 hover:from-byte-purple-500 hover:to-blue-500 shadow-glow transition duration-300 focus:outline-none focus:ring-2 focus:ring-byte-purple-500 focus:ring-opacity-50 transform hover:-translate-y-0.5"
                        >
                            Place Order
                        </button>
                    </div>
                </div>
            </div>
    </main>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Apply coupon button functionality
            const applyCouponBtn = document.getElementById('apply-coupon');
            if (applyCouponBtn) {
                applyCouponBtn.addEventListener('click', function() {
                    const couponCode = document.getElementById('coupon_code').value;
                    if (!couponCode) {
                        alert('Please enter a coupon code.');
                        return;
                    }
                    
                    // Send AJAX request to apply coupon
                    fetch('{{ route('checkout.apply-coupon') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ coupon_code: couponCode })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Refresh the page to update totals
                            window.location.reload();
                        } else {
                            alert(data.message || 'Invalid coupon code.');
                        }
                    })
                    .catch(error => {
                        console.error('Error applying coupon:', error);
                        alert('An error occurred while applying the coupon.');
                    });
                });
            }
            
            // Payment method radio buttons
            const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
            paymentMethods.forEach(method => {
                method.addEventListener('change', function() {
                    // You can add specific behavior when payment method changes
                    console.log('Payment method changed to:', this.value);
                });
            });
        });
    </script>
</body>
</html>