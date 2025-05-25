<x-app-layout>
    <x-slot name="headerTitle">Order Details</x-slot>
    <x-slot name="addRoute">{{ route('admin.orders.index') }}</x-slot>
    <x-slot name="addLabel">Back to Orders</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-200 text-green-700 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Order Details -->
                <div class="md:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold mb-4 text-gray-500">Order Information</h3>
                            
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-gray-800"><span class="font-semibold text-gray-800">Order ID:</span> #{{ $order->id }}</p>
                                    <p class="text-gray-800"><span class="font-semibold text-gray-800">Date:</span> {{ $order->created_at->format('M d, Y h:i A') }}</p>
                                    <p class="text-gray-800"><span class="font-semibold text-gray-800">Total:</span> ${{ number_format($order->total, 2) }}</p>
                                    <p class="text-gray-800"><span class="font-semibold text-gray-800">Payment Method:</span> {{ $order->payment_method }}</p>
                                </div>
                                
                                <div>
                                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="flex items-center">
                                        @csrf
                                        @method('PATCH')
                                        <label for="status" class="mr-2 text-sm font-medium text-gray-800">Status:</label>
                                        <select name="status" id="status" class="rounded-md border-gray-300 shadow-sm text-gray-800 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 mr-2">
                                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-bold py-1 px-3 rounded">
                                            Update
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg text-gray-800 ">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Order Items</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($order->items as $item)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        @if($item->product && $item->product->image)
                                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product ? $item->product->name : 'Product' }}" class="h-10 w-10 rounded-full object-cover mr-3">
                                                        @else
                                                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center mr-3">
                                                                <span class="text-xs text-gray-500">No img</span>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="text-sm font-medium text-gray-900">
                                                                {{ $item->product ? $item->product->name : 'Product Unavailable' }}
                                                            </div>
                                                            <div class="text-sm text-gray-500">
                                                                ID: {{ $item->product_id }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($item->price, 2) }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->quantity }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-gray-50">
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-900">Order Total:</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${{ number_format($order->total, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="md:col-span-1 text-gray-800">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Customer Information</h3>
                            
                            <div class="space-y-3">
                                <p><span class="font-semibold">Name:</span> {{ $order->first_name }}</p>
                                <p><span class="font-semibold">Email:</span> {{ $order->email }}</p>
                                <p><span class="font-semibold">Phone:</span> {{ $order->phone }}</p>
                                <p><span class="font-semibold">User ID:</span> {{ $order->user_id }}</p>
                                @if($order->user)
                                    <p><span class="font-semibold">User:</span> 
                                        <a href="{{ route('admin.users.show', $order->user_id) }}" class="text-blue-600 hover:underline">
                                            {{ $order->user->name }}
                                        </a>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Shipping Address</h3>
                            
                            <div class="space-y-2">
                                <p>{{ $order->first_name }}</p>
                                @if($order->company_name)
                                    <p>{{ $order->company_name }}</p>
                                @endif
                                <p>{{ $order->street_address }}</p>
                                @if($order->apartment)
                                    <p>{{ $order->apartment }}</p>
                                @endif
                                <p>{{ $order->town_city }}</p>
                            </div>
                        </div>
                    </div>

                    @if($order->notes)
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Order Notes</h3>
                            <p class="text-gray-700">{{ $order->notes }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>