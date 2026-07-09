@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Edit Payment</h1>
        <p class="text-gray-500 mt-1">Update payment information.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border p-8">
        <form action="{{ route('payments.update', $payment) }}" method="POST">
            @method('PUT')
            @include('payments.partials.form')
        </form>
    </div>
</div>
@endsection