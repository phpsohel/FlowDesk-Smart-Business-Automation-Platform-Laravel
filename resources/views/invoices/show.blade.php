@extends('layouts.app')

@section('content')
<div class="py-8 px-6 max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">{{ $invoice->invoice_number }}</h1>
            <p class="text-gray-500">Invoice details</p>
        </div>

        <a href="{{ route('invoices.edit', $invoice) }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700">
            Edit Invoice
        </a>
    </div>

    <div class="bg-white rounded-2xl border shadow-sm p-8">
        <div class="grid grid-cols-2 gap-6 mb-8">
            <div>
                <h3 class="font-bold text-gray-900 mb-2">Bill To</h3>
                <p>{{ $invoice->customer->name }}</p>
                <p class="text-gray-500">{{ $invoice->customer->email }}</p>
                <p class="text-gray-500">{{ $invoice->customer->phone }}</p>
            </div>

            <div class="text-right">
                <p><strong>Invoice Date:</strong> {{ $invoice->invoice_date ?? '-' }}</p>
                <p><strong>Due Date:</strong> {{ $invoice->due_date ?? '-' }}</p>
                <p><strong>Status:</strong> {{ ucfirst($invoice->status) }}</p>
            </div>
        </div>

        <table class="w-full text-sm mb-8">
            <thead class="bg-gray-50 text-gray-500">
                <tr>
                    <th class="px-4 py-3 text-left">Item</th>
                    <th class="px-4 py-3 text-left">Qty</th>
                    <th class="px-4 py-3 text-left">Price</th>
                    <th class="px-4 py-3 text-right">Total</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach($invoice->items as $item)
                    <tr>
                        <td class="px-4 py-3">{{ $item->item_name }}</td>
                        <td class="px-4 py-3">{{ $item->quantity }}</td>
                        <td class="px-4 py-3">${{ number_format($item->price, 2) }}</td>
                        <td class="px-4 py-3 text-right">${{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-end">
            <div class="w-80 space-y-2">
                <div class="flex justify-between">
                    <span>Subtotal</span>
                    <span>${{ number_format($invoice->subtotal, 2) }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Tax</span>
                    <span>${{ number_format($invoice->tax, 2) }}</span>
                </div>

                <div class="flex justify-between">
                    <span>Discount</span>
                    <span>${{ number_format($invoice->discount, 2) }}</span>
                </div>

                <div class="flex justify-between border-t pt-3 font-bold text-lg">
                    <span>Total</span>
                    <span>${{ number_format($invoice->total, 2) }}</span>
                </div>
            </div>
        </div>

        @if($invoice->notes)
            <div class="mt-8">
                <h3 class="font-bold mb-2">Notes</h3>
                <p class="text-gray-600">{{ $invoice->notes }}</p>
            </div>
        @endif
    </div>
</div>
@endsection