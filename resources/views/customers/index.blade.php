@extends('layouts.app')

@section('content')
    <div class="p-8 bg-gray-50 min-h-screen">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Customers</h1>
                <p class="text-gray-500 mt-1">Manage all your customers in one place.</p>
            </div>

            <a href="{{ route('customers.create') }}"
                class="inline-flex items-center px-5 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition">
                + Add Customer
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <p class="text-gray-500">Total Customers</p>
                <h2 class="text-3xl font-bold mt-2">256</h2>
                <p class="text-green-600 text-sm mt-2">↗ 15.7% from last month</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <p class="text-gray-500">Active Customers</p>
                <h2 class="text-3xl font-bold mt-2">218</h2>
                <p class="text-green-600 text-sm mt-2">↗ 9.4% from last month</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <p class="text-gray-500">Pending Customers</p>
                <h2 class="text-3xl font-bold mt-2">24</h2>
                <p class="text-orange-500 text-sm mt-2">↗ 3.2% this week</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <p class="text-gray-500">New This Month</p>
                <h2 class="text-3xl font-bold mt-2">14</h2>
                <p class="text-green-600 text-sm mt-2">↗ 6.8% increase</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-xl font-bold text-gray-900">Customer List</h2>

                <form action="{{ route('customers.index') }}" method="GET">
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Search customers..."
                        onkeydown="if(event.key==='Enter'){this.form.submit();}" class="border rounded-xl px-4 py-2 w-72">
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b text-gray-500 text-sm">
                            <th class="py-3">Customer</th>
                            <th class="py-3">Company</th>
                            <th class="py-3">Phone</th>
                            <th class="py-3">Invoices</th>
                            <th class="py-3">Status</th>
                            <th class="py-3 text-right">Action</th>
                        </tr>
                    </thead>

                    <tbody>
    @foreach($customers as $customer)
        <tr class="border-b hover:bg-gray-50">
            <td class="py-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-bold">
                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">{{ $customer->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $customer->email }}</p>
                    </div>
                </div>
            </td>

            <td class="py-4">{{ $customer->company }}</td>
            <td class="py-4">{{ $customer->phone }}</td>

            <td class="py-4">
                <div class="font-medium">
                    {{ $customer->invoices_count ?? 0 }} Invoices
                </div>
                <div class="text-sm text-gray-500">
                    ${{ number_format($customer->invoices_sum_total ?? 0, 2) }}
                </div>
            </td>

            <td class="py-4">
                @if($customer->status == 'Active')
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">Active</span>
                @else
                    <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm">Pending</span>
                @endif
            </td>

            <td class="py-4 text-right">
                <a href="{{ route('customers.show', $customer->id) }}" class="text-indigo-600 hover:underline">
                    View
                </a>
                <a href="{{ route('customers.edit', $customer->id) }}" class="text-gray-500 hover:text-indigo-600 hover:underline ml-3">
                    Edit
                </a>
            </td>
        </tr>
    @endforeach
</tbody>
                </table>
                <div class="mt-6">
    {{ $customers->appends(request()->query())->links() }}
</div>
            </div>
        </div>

    </div>
@endsection