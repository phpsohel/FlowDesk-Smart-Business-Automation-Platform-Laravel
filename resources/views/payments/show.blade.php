@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    <div class="bg-white rounded-2xl shadow-sm border p-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Payment Details</h1>
                <p class="text-gray-500 mt-1">{{ $payment->invoice->invoice_number ?? '-' }}</p>
            </div>

            <a href="{{ route('payments.edit', $payment) }}"
                class="px-5 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700">
                Edit Payment
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-gray-500">Customer</p>
                <p class="font-semibold">{{ $payment->customer->name ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500">Invoice</p>
                <p class="font-semibold">{{ $payment->invoice->invoice_number ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-500">Amount</p>
                <p class="font-semibold">${{ number_format($payment->amount, 2) }}</p>
            </div>

            <div>
                <p class="text-gray-500">Method</p>
                <p class="font-semibold">{{ $payment->payment_method }}</p>
            </div>

            <div>
                <p class="text-gray-500">Payment Date</p>
                <p class="font-semibold">{{ $payment->payment_date }}</p>
            </div>

            <div>
                <p class="text-gray-500">Status</p>
                <p class="font-semibold">{{ $payment->status }}</p>
            </div>

            <div>
                <p class="text-gray-500">Reference</p>
                <p class="font-semibold">{{ $payment->reference ?? '-' }}</p>
            </div>
        </div>

        <div class="mt-8">
            <p class="text-gray-500 mb-2">Notes</p>
            <p class="text-gray-800">{{ $payment->notes ?? 'No notes available.' }}</p>
        </div>
    </div>
</div>
@endsection