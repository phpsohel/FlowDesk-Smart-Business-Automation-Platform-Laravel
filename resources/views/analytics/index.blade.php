@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Analytics</h1>
        <p class="text-gray-500 mt-1">Track business insights and performance.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Total Revenue</p>
            <h2 class="text-3xl font-bold mt-2">${{ number_format($totalRevenue, 2) }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Invoice Value</p>
            <h2 class="text-3xl font-bold mt-2">${{ number_format($invoiceValue, 2) }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Outstanding</p>
            <h2 class="text-3xl font-bold mt-2">${{ number_format($outstanding, 2) }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Invoice Status</p>
            <h2 class="text-lg font-bold mt-2">
                Paid: {{ $paidInvoices }} | Partial: {{ $partialInvoices }} | Unpaid: {{ $unpaidInvoices }}
            </h2>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <h2 class="text-xl font-bold mb-5">Revenue Analytics</h2>
            <canvas id="analyticsChart" height="130"></canvas>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <h2 class="text-xl font-bold mb-5">Top Customers</h2>

            @foreach($topCustomers as $customer)
                <div class="flex justify-between border-b py-3">
                    <span>{{ $customer->name }}</span>
                    <strong>${{ number_format($customer->paid_amount ?? 0, 2) }}</strong>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border p-6">
        <h2 class="text-xl font-bold mb-5">Low Stock Products</h2>

        <table class="w-full text-left">
            <thead>
                <tr class="border-b text-gray-500 text-sm">
                    <th class="py-3">Product</th>
                    <th class="py-3">SKU</th>
                    <th class="py-3">Stock</th>
                    <th class="py-3">Price</th>
                </tr>
            </thead>

            <tbody>
                @foreach($lowStockProducts as $product)
                    <tr class="border-b">
                        <td class="py-3">{{ $product->name }}</td>
                        <td class="py-3">{{ $product->sku }}</td>
                        <td class="py-3 text-red-600 font-semibold">{{ $product->stock }}</td>
                        <td class="py-3">${{ number_format($product->price, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    new Chart(document.getElementById('analyticsChart'), {
        type: 'bar',
        data: {
            labels: @json($labels),
            datasets: [{
                label: 'Revenue',
                data: @json($data),
                borderWidth: 1
            }]
        }
    });
</script>
@endsection