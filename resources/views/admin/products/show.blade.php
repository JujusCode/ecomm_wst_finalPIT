<x-app-layout>
    <x-slot name="headerTitle">Product Details</x-slot>
    <x-slot name="addRoute">{{ route('admin.products.index') }}</x-slot>
    <x-slot name="addLabel">Back to Products</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col md:flex-row gap-8">
                        <div class="md:w-1/3">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-auto rounded-lg shadow-md">
                            @else
                                <div class="w-full h-48 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-500">No image available</span>
                                </div>
                            @endif
                        </div>
                        
                        <div class="md:w-2/3">
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $product->name }}</h2>
                            <p class="text-gray-600 mb-4">{{ $product->description }}</p>
                            
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Price</p>
                                    <p class="mt-1 text-lg font-semibold text-gray-800">${{ number_format($product->price, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Stock Quantity</p>
                                    <p class="mt-1 text-lg font-semibold text-gray-800">{{ $product->stock_quantity }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Category</p>
                                    <p class="mt-1 text-lg font-semibold text-gray-800">{{ $product->category->name ?? 'Uncategorized' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Created At</p>
                                    <p class="mt-1 text-lg font-semibold text-gray-800">{{ $product->created_at->format('F d, Y H:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-between">
                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                                Delete Product
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>