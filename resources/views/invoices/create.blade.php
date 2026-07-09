@extends('layouts.app')

@section('content')
<div class="py-8 px-6 max-w-6xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Create Invoice</h1>
        <p class="text-gray-500">Create a new customer invoice.</p>
    </div>

    <div class="bg-white rounded-2xl border shadow-sm p-6">
        <form method="POST" action="{{ route('invoices.store') }}">
            @csrf

            @include('invoices.partials.form')

            <div class="flex justify-end gap-3 mt-6">
                <a href="{{ route('invoices.index') }}" class="px-4 py-2 border rounded-lg text-sm">Cancel</a>
                <button class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700">
                    Save Invoice
                </button>
            </div>
        </form>
    </div>
</div>
@endsection