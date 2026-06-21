@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Edit Customer - {{ $customer->name }}</h1>
    </div>

    <div class="max-w-2xl bg-white p-6 rounded-lg shadow">
        <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
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

            <!-- Name -->
            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                <input type="text" id="name" name="name" value="{{ $customer->name }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
                @error('name')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                <input type="email" id="email" name="email" value="{{ $customer->email }}" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required>
                @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Mobile -->
            <div class="mb-6">
                <label for="mobile" class="block text-sm font-medium text-gray-700 mb-2">Mobile Number (10 digits)</label>
                <input type="text" id="mobile" name="mobile" value="{{ $customer->mobile }}" 
                       placeholder="9876543210"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       required maxlength="10">
                @error('mobile')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Read-only Information -->
            <div class="grid grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
                <div>
                    <p class="text-sm text-gray-500">Joined Date</p>
                    <p class="font-semibold text-gray-900">{{ $customer->created_at->format('M d, Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Orders</p>
                    <p class="font-semibold text-gray-900">{{ $customer->orders()->count() }}</p>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                    💾 Save Changes
                </button>
                <a href="{{ route('admin.customers.show', $customer->id) }}" class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                    ❌ Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
