@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Products</h1>
            <p class="text-gray-500 mt-1">Manage all products in one place.</p>
        </div>

        <a href="{{ route('products.create') }}"
            class="inline-flex items-center px-5 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition">
            + Add Product
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Total Products</p>
            <h2 class="text-3xl font-bold mt-2">{{ $products->total() }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Active Products</p>
            <h2 class="text-3xl font-bold mt-2">{{ \App\Models\Product::where('status', 'Active')->count() }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Low Stock</p>
            <h2 class="text-3xl font-bold mt-2">{{ \App\Models\Product::where('stock', '<=', 5)->count() }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Categories</p>
            <!-- <h2 class="text-3xl font-bold mt-2">{{ \App\Models\Category::count() }}</h2> -->
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-xl font-bold text-gray-900">Product List</h2>

            <form action="{{ route('products.index') }}" method="GET">
                <input type="search" name="search" value="{{ request('search') }}"
                    placeholder="Search products..."
                    class="border rounded-xl px-4 py-2 w-72">
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b text-gray-500 text-sm">
                        <th class="py-3">Product</th>
                        <th class="py-3">Category</th>
                        <th class="py-3">SKU</th>
                        <th class="py-3">Price</th>
                        <th class="py-3">Stock</th>
                        <th class="py-3">Status</th>
                        <th class="py-3 text-right">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($products as $product)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-4">
                                <h3 class="font-semibold text-gray-900">{{ $product->name }}</h3>
                                <p class="text-sm text-gray-500">{{ Str::limit($product->description, 45) }}</p>
                            </td>

                            <td class="py-4">{{ $product->category->name ?? 'No Category' }}</td>
                            <td class="py-4">{{ $product->sku ?? '-' }}</td>
                            <td class="py-4">${{ number_format($product->price, 2) }}</td>

                            <td class="py-4">
                                @if($product->stock <= 5)
                                    <span class="text-red-600 font-semibold">{{ $product->stock }}</span>
                                @else
                                    {{ $product->stock }}
                                @endif
                            </td>

                            <td class="py-4">
                                @if($product->status == 'Active')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">Active</span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">Inactive</span>
                                @endif
                            </td>

                            <td class="py-4 text-right">
                                <a href="{{ route('products.show', $product) }}" class="text-indigo-600 hover:underline">View</a>
                                <a href="{{ route('products.edit', $product) }}" class="text-gray-500 hover:text-indigo-600 hover:underline ml-3">Edit</a>

                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete product?')" class="ml-3 text-red-600 hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-6">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection