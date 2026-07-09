@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Payments</h1>
            <p class="text-gray-500 mt-1">Manage all customer payments.</p>
        </div>

        <a href="{{ route('payments.create') }}"
            class="inline-flex items-center px-5 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition">
            + Add Payment
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Total Payments</p>
            <h2 class="text-3xl font-bold mt-2">{{ $payments->total() }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Total Revenue</p>
            <h2 class="text-3xl font-bold mt-2">${{ number_format(\App\Models\Payment::where('status', 'Completed')->sum('amount'), 2) }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Pending</p>
            <h2 class="text-3xl font-bold mt-2">{{ \App\Models\Payment::where('status', 'Pending')->count() }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Today Paid</p>
            <h2 class="text-3xl font-bold mt-2">${{ number_format($todayPayment, 2) }}</h2>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-xl font-bold text-gray-900">Payment List</h2>

            <form action="{{ route('payments.index') }}" method="GET">
                <input type="search" name="search" value="{{ request('search') }}"
                    placeholder="Search payments..."
                    class="border rounded-xl px-4 py-2 w-72">
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b text-gray-500 text-sm">
                        <th class="py-3">Invoice</th>
                        <th class="py-3">Customer</th>
                        <th class="py-3">Amount</th>
                        <th class="py-3">Method</th>
                        <th class="py-3">Date</th>
                        <th class="py-3">Status</th>
                        <th class="py-3 text-right">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($payments as $payment)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-4">
                                {{ $payment->invoice->invoice_number ?? '-' }}
                            </td>

                            <td class="py-4">
                                {{ $payment->customer->name ?? '-' }}
                            </td>

                            <td class="py-4 font-semibold">
                                ${{ number_format($payment->amount, 2) }}
                            </td>

                            <td class="py-4">
                                {{ $payment->payment_method }}
                            </td>

                            <td class="py-4">
                                {{ $payment->payment_date }}
                            </td>

                            <td class="py-4">
                                @if($payment->status == 'Completed')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">Completed</span>
                                @elseif($payment->status == 'Pending')
                                    <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm">Pending</span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">Failed</span>
                                @endif
                            </td>

                            <td class="py-4 text-right">
                                <a href="{{ route('payments.show', $payment) }}" class="text-indigo-600 hover:underline">View</a>
                                <a href="{{ route('payments.edit', $payment) }}" class="text-gray-500 hover:text-indigo-600 hover:underline ml-3">Edit</a>

                                <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete payment?')" class="ml-3 text-red-600 hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-6">
                {{ $payments->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection