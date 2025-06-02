<x-app-layout>
    <x-slot name="headerTitle">Update Product Inventory</x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Update Inventory: {{ $product->name }}</h2>
                        <a href="{{ route('staff.products.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            Back to Inventory
                        </a>
                    </div>

                    <!-- Product Overview -->
                    <div class="mb-8 p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-4">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="h-16 w-16 rounded-lg object-cover">
                            @else
                                <div class="h-16 w-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                    <span class="text-xs text-gray-500">No image</span>
                                </div>
                            @endif
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500">Product ID: #{{ $product->id }}</p>
                                <p class="text-sm text-gray-500">Price: ${{ number_format($product->price, 2) }}</p>
                                <p class="text-sm text-gray-500">Category: {{ $product->category->name ?? 'Uncategorized' }}</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('staff.products.update', $product->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Current Stock Display -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h3 class="text-sm font-medium text-blue-800 mb-2">Current Inventory Status</h3>
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <p class="text-sm text-blue-600">Current Stock</p>
                                    <p class="text-2xl font-bold {{ $product->stock <= 5 ? 'text-red-600' : 'text-blue-800' }}">
                                        {{ $product->stock }}
                                        @if($product->stock <= 5)
                                            <span class="ml-2 text-xs bg-red-100 text-red-800 px-2 py-1 rounded">Low Stock</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Stock Input -->
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">
                                Update Stock Quantity
                            </label>
                            <input type="number" 
                                   id="stock" 
                                   name="stock" 
                                   value="{{ old('stock', $product->stock) }}" 
                                   min="0" 
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('stock') border-red-300 @enderror">
                            @error('stock')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Enter the new stock quantity for this product.</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('staff.products.show', $product->id) }}" class="text-sm text-blue-600 hover:text-blue-500">
                                View Product Details
                            </a>
                            <div class="flex space-x-3">
                                <a href="{{ route('staff.products.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Cancel
                                </a>
                                <button type="submit" class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Update Inventory
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>