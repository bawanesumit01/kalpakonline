@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Edit Order #{{ $order->order_number }}</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="bg-white p-6 rounded-lg shadow">
                @csrf
                @method('PUT')

                @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 p-4 rounded-lg">
                    <p class="text-red-800 font-semibold mb-2">⚠️ Validation Errors:</p>
                    <ul class="list-disc list-inside text-red-700">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Order Status -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Order Status</label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ $order->status == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Payment Status -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Payment Status</label>
                    <select name="payment_status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @foreach($paymentStatuses as $paymentStatus)
                        <option value="{{ $paymentStatus }}" {{ $order->payment_status == $paymentStatus ? 'selected' : '' }}>
                            {{ ucfirst($paymentStatus) }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Order Notes -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Order Notes</label>
                    <textarea name="order_notes" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ $order->order_notes }}</textarea>
                </div>

                <!-- Submit Button -->
                <div class="flex gap-3">
                    <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        💾 Save Changes
                    </button>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                        ❌ Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Sidebar - Current Details -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">📊 Current Status</h2>
                
                <div class="space-y-3">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Order Status</p>
                        <p class="text-sm font-semibold">
                            <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-800">
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Payment Status</p>
                        <p class="text-sm font-semibold">
                            <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-800">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-bold text-gray-800 mb-4">🛍️ Order Items</h2>
                
                <div class="space-y-2">
                    @foreach($order->items as $item)
                    <div class="border-b pb-2">
                        <p class="text-sm font-semibold text-gray-800">{{ $item->product_name }}</p>
                        <p class="text-xs text-gray-500">Qty: {{ $item->quantity }} × ₹{{ number_format($item->price, 2) }}</p>
                        <p class="text-xs font-semibold text-gray-700">₹{{ number_format($item->subtotal, 2) }}</p>
                    </div>
                    @endforeach
                </div>

                <div class="mt-4 pt-4 border-t">
                    <div class="flex justify-between text-sm mb-2">
                        <span>Subtotal:</span>
                        <span class="font-semibold">₹{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm mb-2">
                        <span>Shipping:</span>
                        <span class="font-semibold">₹{{ number_format($order->shipping, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span>Tax:</span>
                        <span class="font-semibold">₹{{ number_format($order->tax, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold mt-2 pt-2 border-t">
                        <span>Total:</span>
                        <span>₹{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
