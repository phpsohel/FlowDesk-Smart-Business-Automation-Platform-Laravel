@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Add Product</h1>
        <p class="text-gray-500 mt-1">Create a new product.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border p-8">
        <form action="{{ route('products.store') }}" method="POST">
            @include('products.partials.form')
        </form>
    </div>
</div>
@endsection