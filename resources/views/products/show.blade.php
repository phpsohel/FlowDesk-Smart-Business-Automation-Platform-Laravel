@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    <div class="bg-white rounded-2xl shadow-sm border p-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                <p class="text-gray-500 mt-1">{{ $product->category->name ?? 'No Category' }}</p>
            </div>

            <a href="{{ route('products.edit', $product) }}"
                class="px-5 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700">
                Edit Product
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-gray-500">SKU</p>
                <p class="font-semibold">{{ $product->sku ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500">Price</p>
                <p class="font-semibold">${{ number_format($product->price, 2) }}</p>
            </div>

            <div>
                <p class="text-gray-500">Stock</p>
                <p class="font-semibold">{{ $product->stock }}</p>
            </div>

            <div>
                <p class="text-gray-500">Status</p>
                <p class="font-semibold">{{ $product->status }}</p>
            </div>
        </div>

        <div class="mt-8">
            <p class="text-gray-500 mb-2">Description</p>
            <p class="text-gray-800">{{ $product->description ?? 'No description available.' }}</p>
        </div>
    </div>
</div>
@endsection