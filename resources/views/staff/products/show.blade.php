<x-app-layout>
    <x-slot name="headerTitle">Product Details</x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">{{ $product->name }}</h2>
                        <div class="flex space-x-2">
                            <a href="{{ route('staff.products.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                Back to Inventory
                            </a>
                            <a href="{{ route('staff.products.edit', $product->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Update Inventory
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Product Image -->
                        <div class="space-y-4">
                            @if($product->image)
                                <div class="aspect-w-1 aspect-h-1">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover rounded-lg border border-gray-200">
                                </div>
                            @else
                                <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center border border-gray-200">
                                    <span class="text-gray-500">No Image Available</span>
                                </div>
                            @endif
                        </div>

                        <!-- Product Information -->
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 gap-4">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Product ID</h3>
                                    <p class="mt-1 text-lg text-gray-900">#{{ $product->id }}</p>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Price</h3>
                                    <p class="mt-1 text-2xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</p>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Current Stock</h3>
                                    <p class="mt-1 text-2xl font-bold {{ $product->stock <= 5 ? 'text-red-600' : 'text-gray-900' }}">
                                        {{ $product->stock }}
                                        @if($product->stock <= 5)
                                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                Low Stock Alert
                                            </span>
                                        @endif
                                    </p>
                                </div>

                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Category</h3>
                                    <p class="mt-1 text-lg text-gray-900">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Description -->
                    @if($product->description)
                        <div class="mt-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Description</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Product Timestamps -->
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Created At</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->created_at->format('M d, Y g:i A') }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Last Updated</h3>
                            <p class="mt-1 text-sm text-gray-900">{{ $product->updated_at->format('M d, Y g:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>