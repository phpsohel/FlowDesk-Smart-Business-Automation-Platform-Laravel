@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Add Payment</h1>
        <p class="text-gray-500 mt-1">Record a new customer payment.</p>
    </div>
@error('amount')
    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
@enderror
    <div class="bg-white rounded-2xl shadow-sm border p-8">
        <form action="{{ route('payments.store') }}" method="POST">
            @include('payments.partials.form')
        </form>
    </div>
</div>
@endsection