<x-app-layout>
    <x-slot name="headerTitle">Create Order</x-slot>
    <x-slot name="addRoute">{{ route('admin.orders.index') }}</x-slot>
    <x-slot name="addLabel">Back to Orders</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-200 text-red-700 rounded-md">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.orders.store') }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Order Information</h3>
                            <div class="flex flex-wrap -mx-2">
                                <div class="px-2 w-full md:w-1/2 lg:w-1/3 mb-4">
                                    <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
                                    <select id="user_id" name="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <option value="">Select Customer</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="px-2 w-full md:w-1/2 lg:w-1/3 mb-4">
                                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Order Status</label>
                                    <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ old('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </div>
                                <div class="px-2 w-full md:w-1/2 lg:w-1/3 mb-4">
                                    <label for="payment_method" class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                                    <select id="payment_method" name="payment_method" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                        <option value="paypal" {{ old('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                                        <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="cash_on_delivery" {{ old('payment_method') == 'cash_on_delivery' ? 'selected' : '' }}>Cash on Delivery</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Customer Information</h3>
                            <div class="flex flex-wrap -mx-2">
                                <div class="px-2 w-full md:w-1/2 mb-4">
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="px-2 w-full md:w-1/2 mb-4">
                                    <label for="company_name" class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                                    <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="px-2 w-full md:w-1/2 mb-4">
                                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" name="email" id="email" value="{{ old('email') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="px-2 w-full md:w-1/2 mb-4">
                                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Shipping Information</h3>
                            <div class="flex flex-wrap -mx-2">
                                <div class="px-2 w-full mb-4">
                                    <label for="street_address" class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
                                    <input type="text" name="street_address" id="street_address" value="{{ old('street_address') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="px-2 w-full mb-4">
                                    <label for="apartment" class="block text-sm font-medium text-gray-700 mb-1">Apartment/Suite/Unit</label>
                                    <input type="text" name="apartment" id="apartment" value="{{ old('apartment') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="px-2 w-full mb-4">
                                    <label for="town_city" class="block text-sm font-medium text-gray-700 mb-1">Town/City</label>
                                    <input type="text" name="town_city" id="town_city" value="{{ old('town_city') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Order Items</h3>
                            <div class="overflow-x-auto mb-4 border rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200" id="orderItemsTable">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200" id="orderItemsBody">
                                        <tr id="emptyRow">
                                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">No items added yet. Add products using the form below.</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="border p-4 rounded-lg bg-gray-50">
                                <div class="flex flex-wrap -mx-2">
                                    <div class="px-2 w-full md:w-1/3 mb-4">
                                        <label for="product_id" class="block text-sm font-medium text-gray-700 mb-1">Product</label>
                                        <select id="product_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                            <option value="">Select Product</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                                    {{ $product->name }} (${{ number_format($product->price, 2) }}) - Stock: {{ $product->stock }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="px-2 w-full md:w-1/3 mb-4">
                                        <label for="item_price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                                        <input type="number" id="item_price" step="0.01" min="0" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <div class="px-2 w-full md:w-1/3 mb-4">
                                        <label for="item_quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                                        <input type="number" id="item_quantity" value="1" min="1" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                                <div class="flex justify-end">
                                    <button type="button" id="addItemBtn" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Add Item
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Order Notes</h3>
                            <div class="flex flex-wrap -mx-2">
                                <div class="px-2 w-full mb-4">
                                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                                    <textarea name="notes" id="notes" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Create Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let itemCount = 0;
            const productSelect = document.getElementById('product_id');
            const priceInput = document.getElementById('item_price');
            const quantityInput = document.getElementById('item_quantity');
            const addButton = document.getElementById('addItemBtn');
            const orderItemsBody = document.getElementById('orderItemsBody');
            const emptyRow = document.getElementById('emptyRow');
            
            // Update price when product is selected
            productSelect.addEventListener('change', function() {
                const selectedOption = productSelect.options[productSelect.selectedIndex];
                if (selectedOption.value) {
                    priceInput.value = selectedOption.dataset.price;
                } else {
                    priceInput.value = '';
                }
            });
            
            // Add item to order
            addButton.addEventListener('click', function() {
                const productId = productSelect.value;
                const productText = productSelect.options[productSelect.selectedIndex].text;
                const price = priceInput.value;
                const quantity = quantityInput.value;
                
                if (!productId || !price || !quantity || price <= 0 || quantity <= 0) {
                    alert('Please select a product, set a valid price and quantity.');
                    return;
                }
                
                // Hide empty row message if it's visible
                if (emptyRow.style.display !== 'none') {
                    emptyRow.style.display = 'none';
                }
                
                // Create new row
                const newRow = document.createElement('tr');
                newRow.innerHTML = `
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${productText}</div>
                        <input type="hidden" name="items[${itemCount}][product_id]" value="${productId}">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        $${parseFloat(price).toFixed(2)}
                        <input type="hidden" name="items[${itemCount}][price]" value="${price}">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${quantity}
                        <input type="hidden" name="items[${itemCount}][quantity]" value="${quantity}">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <button type="button" class="text-red-600 hover:text-red-900 delete-item">Remove</button>
                    </td>
                `;
                
                // Add row to table
                orderItemsBody.appendChild(newRow);
                
                // Add event listener to delete button
                newRow.querySelector('.delete-item').addEventListener('click', function() {
                    newRow.remove();
                    
                    // Show empty row message if no items left
                    if (orderItemsBody.children.length === 1) {
                        emptyRow.style.display = '';
                    }
                });
                
                // Reset form
                productSelect.value = '';
                priceInput.value = '';
                quantityInput.value = '1';
                
                // Increment counter
                itemCount++;
            });
            
            // Initialize user selection to auto-fill customer data
            const userSelect = document.getElementById('user_id');
            if (userSelect) {
                userSelect.addEventListener('change', function() {
                    // In a real implementation, you might want to fetch user details via AJAX
                    // and auto-fill the customer information fields
                });
            }
        });
    </script>
</x-app-layout>