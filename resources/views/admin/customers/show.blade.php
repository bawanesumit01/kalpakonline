@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold text-gray-800">👤 {{ $customer->name }}</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.customers.edit', $customer->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                ✏️ Edit
            </a>
            <a href="{{ route('admin.customers.addresses', $customer->id) }}" class="px-4 py-2 bg-purple-500 text-white rounded-lg hover:bg-purple-600">
                📍 Addresses
            </a>
            <a href="{{ route('admin.customers.orders', $customer->id) }}" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                📦 Orders
            </a>
            <a href="{{ route('admin.customers.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                ⬅️ Back
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Customer Info -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold text-gray-800 mb-4">ℹ️ Customer Information</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Name</p>
                        <p class="font-semibold text-gray-900">{{ $customer->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-semibold text-gray-900">{{ $customer->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Mobile</p>
                        <p class="font-semibold text-gray-900">{{ $customer->mobile }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Joined Date</p>
                        <p class="font-semibold text-gray-900">{{ $customer->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold text-gray-800 mb-4">📦 Recent Orders (Last 5)</h2>
                <div class="space-y-3">
                    @forelse($recentOrders as $order)
                    <div class="border rounded-lg p-4 hover:bg-gray-50">
                        <div class="flex justify-between items-start mb-2">
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="font-semibold text-blue-600 hover:underline">
                                {{ $order->order_number }}
                            </a>
                            <span class="text-sm font-semibold px-2 py-1 rounded
                                {{ $order->status == 'delivered' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">{{ $order->created_at->format('M d, Y') }}</span>
                            <span class="font-semibold">₹{{ number_format($order->total, 2) }}</span>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500">No orders yet</p>
                    @endforelse
                </div>
            </div>

            <!-- Saved Addresses -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold text-gray-800 mb-4">📍 Saved Addresses</h2>
                <div class="space-y-3">
                    @forelse($savedAddresses as $address)
                    <div class="border rounded-lg p-4 bg-gray-50">
                        @if($address->is_default)
                        <span class="text-xs font-semibold px-2 py-1 bg-blue-100 text-blue-800 rounded mb-2 inline-block">
                            Default
                        </span>
                        @endif
                        <p class="font-semibold text-gray-900">{{ $address->name }}</p>
                        <p class="text-sm text-gray-700">{{ $address->address }}</p>
                        @if($address->address_line2)
                        <p class="text-sm text-gray-700">{{ $address->address_line2 }}</p>
                        @endif
                        <p class="text-sm text-gray-700">{{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}</p>
                        <p class="text-xs text-gray-500 mt-2">{{ $address->phone }}</p>
                    </div>
                    @empty
                    <p class="text-gray-500">No saved addresses</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <!-- Stats Card -->
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">📊 Statistics</h2>
                
                <div class="space-y-4">
                    <div class="text-center">
                        <p class="text-3xl font-bold text-blue-600">{{ $totalOrders }}</p>
                        <p class="text-sm text-gray-600">Total Orders</p>
                    </div>
                    <div class="text-center">
                        <p class="text-3xl font-bold text-green-600">₹{{ number_format($totalSpent, 2) }}</p>
                        <p class="text-sm text-gray-600">Total Spent</p>
                    </div>
                    @if($totalOrders > 0)
                    <div class="text-center">
                        <p class="text-2xl font-bold text-purple-600">₹{{ number_format($totalSpent / $totalOrders, 2) }}</p>
                        <p class="text-sm text-gray-600">Avg Order Value</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-lg font-bold text-gray-800 mb-4">⚡ Actions</h2>
                
                <div class="space-y-2">
                    <a href="{{ route('admin.customers.orders', $customer->id) }}" class="block w-full px-4 py-2 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 text-center text-sm">
                        View All Orders
                    </a>
                    <a href="{{ route('admin.customers.addresses', $customer->id) }}" class="block w-full px-4 py-2 bg-purple-100 text-purple-700 rounded hover:bg-purple-200 text-center text-sm">
                        Manage Addresses
                    </a>
                    <a href="{{ route('admin.customers.edit', $customer->id) }}" class="block w-full px-4 py-2 bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200 text-center text-sm">
                        Edit Information
                    </a>
                </div>

                <!-- Delete Button -->
                <form action="{{ route('admin.customers.destroy', $customer->id) }}" method="POST" class="mt-4" onsubmit="return confirm('Are you sure? This will delete all customer data.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 bg-red-100 text-red-700 rounded hover:bg-red-200 text-sm">
                        🗑️ Delete Customer
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
