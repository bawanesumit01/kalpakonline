@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">Order #{{ $order->order_number }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.orders.edit', $order->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                ✏️ Edit Order
            </a>
            <a href="{{ route('admin.orders.invoice', $order->id) }}" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                📄 Invoice
            </a>
            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                ⬅️ Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Status -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold text-gray-800 mb-4">📊 Order Status</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Order Status</p>
                        <p class="text-lg font-semibold">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ $order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $order->status == 'delivered' ? 'bg-green-100 text-green-800' : '' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Payment Status</p>
                        <p class="text-lg font-semibold">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ $order->payment_status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $order->payment_status == 'paid' ? 'bg-green-100 text-green-800' : '' }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold text-gray-800 mb-4">👤 Customer Information</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Name</p>
                        <p class="font-semibold text-gray-900">{{ $order->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Phone</p>
                        <p class="font-semibold text-gray-900">{{ $order->phone }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-semibold text-gray-900">{{ $order->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Customer Type</p>
                        <p class="font-semibold text-gray-900">
                            @if($order->user_id)
                                Registered Customer
                            @else
                                Guest Customer
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Shipping Address -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold text-gray-800 mb-4">📍 Shipping Address</h2>
                <div class="text-gray-700">
                    <p>{{ $order->address }}</p>
                    @if($order->address_line2)
                    <p>{{ $order->address_line2 }}</p>
                    @endif
                    <p>{{ $order->city }}, {{ $order->state }} - {{ $order->pincode }}</p>
                    <p>{{ $order->country ?? 'India' }}</p>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold text-gray-800 mb-4">📦 Order Items</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold">Product</th>
                                <th class="px-4 py-2 text-center text-sm font-semibold">Qty</th>
                                <th class="px-4 py-2 text-right text-sm font-semibold">Price</th>
                                <th class="px-4 py-2 text-right text-sm font-semibold">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr class="border-b">
                                <td class="px-4 py-2">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $item->product_name }}</p>
                                        <p class="text-xs text-gray-500">ID: {{ $item->product_id }}</p>
                                    </div>
                                </td>
                                <td class="px-4 py-2 text-center">{{ $item->quantity }}</td>
                                <td class="px-4 py-2 text-right">₹{{ number_format($item->price, 2) }}</td>
                                <td class="px-4 py-2 text-right font-semibold">₹{{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Order Notes -->
            @if($order->order_notes)
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold text-gray-800 mb-4">📝 Order Notes</h2>
                <p class="text-gray-700">{{ $order->order_notes }}</p>
            </div>
            @endif
        </div>

        <!-- Sidebar - Price Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-lg shadow sticky top-20">
                <h2 class="text-xl font-bold text-gray-800 mb-4">💰 Price Summary</h2>
                
                <div class="space-y-3 mb-4 pb-4 border-b">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-semibold">₹{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-semibold">₹{{ number_format($order->shipping, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Tax (5%)</span>
                        <span class="font-semibold">₹{{ number_format($order->tax, 2) }}</span>
                    </div>
                    @if($order->discount > 0)
                    <div class="flex justify-between text-green-600">
                        <span>Discount</span>
                        <span class="font-semibold">-₹{{ number_format($order->discount, 2) }}</span>
                    </div>
                    @endif
                </div>

                <div class="flex justify-between text-lg font-bold text-gray-900 mb-6">
                    <span>Total</span>
                    <span>₹{{ number_format($order->total, 2) }}</span>
                </div>

                <!-- Payment Method -->
                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                    <p class="text-sm text-gray-600 mb-1">Payment Method</p>
                    <p class="font-semibold text-gray-900">
                        @if($order->payment_method == 'cod')
                            Cash on Delivery
                        @elseif($order->payment_method == 'online')
                            Online Payment
                        @elseif($order->payment_method == 'wallet')
                            Digital Wallet
                        @else
                            {{ ucfirst($order->payment_method) }}
                        @endif
                    </p>
                </div>

                <!-- Order Timeline -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="text-sm text-gray-600 font-semibold mb-3">📅 Order Timeline</p>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Created</span>
                            <span class="text-gray-900">{{ $order->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        @if($order->confirmed_at)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Confirmed</span>
                            <span class="text-gray-900">{{ $order->confirmed_at->format('M d, Y H:i') }}</span>
                        </div>
                        @endif
                        @if($order->shipped_at)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Shipped</span>
                            <span class="text-gray-900">{{ $order->shipped_at->format('M d, Y H:i') }}</span>
                        </div>
                        @endif
                        @if($order->delivered_at)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Delivered</span>
                            <span class="text-gray-900">{{ $order->delivered_at->format('M d, Y H:i') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
