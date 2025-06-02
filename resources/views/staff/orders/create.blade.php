<x-app-layout>
    <x-slot name="headerTitle">Create New Order</x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Create New Order</h2>
                        <a href="{{ route('staff.orders.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Back to Orders
                        </a>
                    </div>

                    <form action="{{ route('staff.orders.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <!-- Customer Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Customer Information</h3>
                                
                                <div>
                                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
                                    <select id="user_id" name="user_id" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('user_id') border-red-300 @enderror">
                                        <option value="">Select a customer</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" 
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('first_name') border-red-300 @enderror">
                                    @error('first_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" 
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-300 @enderror">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" 
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('phone') border-red-300 @enderror">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Shipping Information -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-medium text-gray-900">Shipping Information</h3>
                                
                                <div>
                                    <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Company Name (Optional)</label>
                                    <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}" 
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="street_address" class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
                                    <input type="text" id="street_address" name="street_address" value="{{ old('street_address') }}" 
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('street_address') border-red-300 @enderror">
                                    @error('street_address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="apartment" class="block text-sm font-medium text-gray-700 mb-1">Apartment, Suite, etc. (Optional)</label>
                                    <input type="text" id="apartment" name="apartment" value="{{ old('apartment') }}" 
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <div>
                                    <label for="town_city" class="block text-sm font-medium text-gray-700 mb-1">Town / City</label>
                                    <input type="text" id="town_city" name="town_city" value="{{ old('town_city') }}" 
                                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('town_city') border-red-300 @enderror">
                                    @error('town_city')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Order Items</h3>
                            <div id="order-items-container" class="space-y-4">
                                <!-- Dynamic items will be added here -->
                            </div>
                            <button type="button" id="add-item-btn" class="mt-4 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2">
                                Add Product
                            </button>
                        </div>

                        <!-- Order Summary -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <!-- Payment and Status -->
                            <div class="space-y-4">
                                <div>
                                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                                    <select id="payment_method" name="payment_method" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('payment_method') border-red-300 @enderror">
                                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                        <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="other" {{ old('payment_method') == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('payment_method')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Order Status</label>
                                    <select id="status" name="status" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-300 @enderror">
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ old('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Order Notes -->
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Order Notes (Optional)</label>
                                <textarea id="notes" name="notes" rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('notes') }}</textarea>
                            </div>
                        </div>

                        <!-- Order Total -->
                        <div class="bg-gray-50 p-4 rounded-lg mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Order Total</h3>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600">Subtotal:</span>
                                <span id="order-subtotal" class="font-medium">$0.00</span>
                            </div>
                            <div class="flex justify-between items-center mt-2">
                                <span class="text-gray-600">Total:</span>
                                <span id="order-total" class="text-xl font-bold">$0.00</span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Create Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const products = @json($products);
            const orderItemsContainer = document.getElementById('order-items-container');
            const addItemBtn = document.getElementById('add-item-btn');
            let itemCount = 0;

            // Add new item row
            addItemBtn.addEventListener('click', function() {
                addItemRow();
            });

            // Add initial item row
            addItemRow();

            function addItemRow() {
                const itemId = `item-${itemCount}`;
                const row = document.createElement('div');
                row.className = 'order-item bg-gray-50 p-4 rounded-lg';
                row.id = itemId;
                row.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="items[${itemCount}][product_id]" class="block text-sm font-medium text-gray-700 mb-1">Product</label>
                            <select name="items[${itemCount}][product_id]" class="product-select block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" onchange="updatePrice(this)">
                                <option value="">Select a product</option>
                                ${products.map(product => `
                                    <option value="${product.id}" data-price="${product.price}">${product.name} ($${product.price}) - Stock: ${product.stock}</option>
                                `).join('')}
                            </select>
                        </div>
                        <div>
                            <label for="items[${itemCount}][quantity]" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                            <input type="number" name="items[${itemCount}][quantity]" min="1" value="1" class="quantity-input block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" onchange="updateTotal()">
                        </div>
                        <div>
                            <label for="items[${itemCount}][price]" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                            <input type="number" name="items[${itemCount}][price]" step="0.01" min="0" class="price-input block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" onchange="updateTotal()">
                        </div>
                    </div>
                    <div class="mt-2 flex justify-end">
                        <button type="button" class="remove-item-btn text-sm text-red-600 hover:text-red-800" onclick="removeItem('${itemId}')">Remove</button>
                    </div>
                `;
                orderItemsContainer.appendChild(row);
                itemCount++;
            }

            // Make functions available globally
            window.updatePrice = function(select) {
                const selectedOption = select.options[select.selectedIndex];
                const price = selectedOption ? selectedOption.getAttribute('data-price') : 0;
                const priceInput = select.closest('.order-item').querySelector('.price-input');
                if (priceInput) {
                    priceInput.value = price;
                    updateTotal();
                }
            };

            window.updateTotal = function() {
                let subtotal = 0;
                document.querySelectorAll('.order-item').forEach(item => {
                    const quantity = parseFloat(item.querySelector('.quantity-input').value) || 0;
                    const price = parseFloat(item.querySelector('.price-input').value) || 0;
                    subtotal += quantity * price;
                });

                document.getElementById('order-subtotal').textContent = `$${subtotal.toFixed(2)}`;
                document.getElementById('order-total').textContent = `$${subtotal.toFixed(2)}`;
            };

            window.removeItem = function(itemId) {
                const item = document.getElementById(itemId);
                if (item) {
                    item.remove();
                    updateTotal();
                }
            };
        });
    </script>
    @endpush
</x-app-layout>