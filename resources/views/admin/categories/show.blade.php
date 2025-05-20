<x-app-layout>
    <x-slot name="headerTitle">Category Details</x-slot>
    <x-slot name="addRoute">{{ route('admin.categories.index') }}</x-slot>
    <x-slot name="addLabel">Back to Categories</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Category Information</h3>
                        <div class="mt-4 border-t border-gray-200 pt-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Name</p>
                                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $category->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Created At</p>
                                    <p class="mt-1 text-lg font-semibold text-gray-900">{{ $category->created_at->format('F d, Y H:i A') }}</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="text-sm font-medium text-gray-500">Description</p>
                                <p class="mt-1 text-gray-900">{{ $category->description ?? 'No description provided.' }}</p>
                            </div>
                        </div>
                    </div>

                    @if($category->products && $category->products->count() > 0)
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900">Products in this Category</h3>
                        <div class="mt-4 overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-3 px-4 text-left">ID</th>
                                        <th class="py-3 px-4 text-left">Name</th>
                                        <th class="py-3 px-4 text-left">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($category->products as $product)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-3 px-4">{{ $product->id }}</td>
                                        <td class="py-3 px-4">{{ $product->name }}</td>
                                        <td class="py-3 px-4">{{ $product->price }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900">Products in this Category</h3>
                        <p class="mt-2 text-gray-500">No products found in this category.</p>
                    </div>
                    @endif

                    <div class="mt-8 flex justify-between">
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this category?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                                Delete Category
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>