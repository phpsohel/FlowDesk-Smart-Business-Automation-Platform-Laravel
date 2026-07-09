@extends('layouts.app')

@section('content')
    <div class="p-8 bg-gray-50 min-h-screen">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Invoices</h1>
            <p class="text-gray-500">Manage customer invoices and billing.</p>
        </div>

        <a href="{{ route('invoices.create') }}"
           class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700">
            + Create Invoice
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border shadow-sm">
        <div class="p-4 border-b">
            <form method="GET">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search invoice..."
                       class="w-full md:w-80 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-500">
                    <tr>
                        <th class="px-6 py-3 text-left">Invoice</th>
                        <th class="px-6 py-3 text-left">Customer</th>
                        <th class="px-6 py-3 text-left">Due Date</th>
                        <th class="px-6 py-3 text-left">Total</th>
                        <th class="px-6 py-3 text-left">Status</th>
                        <th class="px-6 py-3 text-right">Action</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse($invoices as $invoice)
                        <tr>
                            <td class="px-6 py-4 font-medium text-indigo-600">
                                {{ $invoice->invoice_number }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $invoice->customer->name ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $invoice->due_date ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                ${{ number_format($invoice->total, 2) }}
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs
                                    {{ $invoice->status == 'paid' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $invoice->status == 'draft' ? 'bg-gray-100 text-gray-700' : '' }}
                                    {{ $invoice->status == 'sent' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $invoice->status == 'overdue' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ $invoice->status == 'cancelled' ? 'bg-orange-100 text-orange-700' : '' }}">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('invoices.show', $invoice) }}" class="text-gray-600 hover:text-indigo-600">View</a>
                                <a href="{{ route('invoices.edit', $invoice) }}" class="text-indigo-600 hover:text-indigo-800">Edit</a>

                                <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="inline-block"
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                No invoices found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t">
            {{ $invoices->links() }}
        </div>
    </div>
</div>
@endsection