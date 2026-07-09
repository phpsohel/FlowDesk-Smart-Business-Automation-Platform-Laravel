@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Reports</h1>
            <p class="text-gray-500 mt-1">Business performance and financial overview.</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl border border-gray-200 shadow-sm p-8 mb-8">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-900">
                Report Filters
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Filter reports by date range to analyze your business performance.
            </p>
        </div>
    </div>

    <form action="{{ route('reports.index') }}" method="GET">

        <div class="grid grid-cols-1 md:grid-cols-5 gap-5">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Filter
                </label>

                <select name="filter"
                    class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">

                    <option value="today" @selected($filter=='today')>Today</option>
                    <option value="this_week" @selected($filter=='this_week')>This Week</option>
                    <option value="this_month" @selected($filter=='this_month')>This Month</option>
                    <option value="this_year" @selected($filter=='this_year')>This Year</option>
                    <option value="custom" @selected($filter=='custom')>Custom Range</option>

                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Start Date
                </label>

                <input
                    type="date"
                    name="start_date"
                    value="{{ request('start_date') }}"
                    class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    End Date
                </label>

                <input
                    type="date"
                    name="end_date"
                    value="{{ request('end_date') }}"
                    class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div class="flex items-end">
                <button
                    class="w-full h-12 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold transition">

                    Apply Filter

                </button>
            </div>

            <div class="flex items-end">

                <a href="{{ route('reports.index') }}"
                    class="w-full h-12 rounded-xl border border-gray-300 bg-gray-50 hover:bg-gray-100 flex items-center justify-center font-medium text-gray-700 transition">

                    Reset

                </a>

            </div>

        </div>

    </form>

</div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Total Revenue</p>
            <h2 class="text-3xl font-bold mt-2">${{ number_format($totalRevenue, 2) }}</h2>
            <p class="text-green-600 text-sm mt-2">Completed payments only</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Total Invoices</p>
            <h2 class="text-3xl font-bold mt-2">{{ $totalInvoices }}</h2>
            <p class="text-gray-500 text-sm mt-2">${{ number_format($invoiceTotal, 2) }} invoice value</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Outstanding</p>
            <h2 class="text-3xl font-bold mt-2">${{ number_format($outstanding, 2) }}</h2>
            <p class="text-orange-500 text-sm mt-2">Unpaid balance</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Payments</p>
            <h2 class="text-3xl font-bold mt-2">{{ $totalPayments }}</h2>
            <p class="text-gray-500 text-sm mt-2">Pending: {{ $pendingPayments }} | Failed: {{ $failedPayments }}</p>
        </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Monthly Revenue</h2>
            <canvas id="revenueChart" height="120"></canvas>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Payment Status</h2>
            <canvas id="paymentStatusChart" height="120"></canvas>
        </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-5">Recent Payments</h2>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b text-gray-500 text-sm">
                            <th class="py-3">Customer</th>
                            <th class="py-3">Invoice</th>
                            <th class="py-3">Amount</th>
                            <th class="py-3">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($recentPayments as $payment)
                            <tr class="border-b">
                                <td class="py-3">{{ $payment->customer->name ?? '-' }}</td>
                                <td class="py-3">{{ $payment->invoice->invoice_number ?? '-' }}</td>
                                <td class="py-3 font-semibold">${{ number_format($payment->amount, 2) }}</td>
                                <td class="py-3">
                                    @if($payment->status == 'Completed')
                                        <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">Completed</span>
                                    @elseif($payment->status == 'Pending')
                                        <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm">Pending</span>
                                    @else
                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">Failed</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-5">Recent Invoices</h2>

            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b text-gray-500 text-sm">
                            <th class="py-3">Invoice</th>
                            <th class="py-3">Customer</th>
                            <th class="py-3">Total</th>
                            <th class="py-3">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($recentInvoices as $invoice)
                            <tr class="border-b">
                                <td class="py-3">{{ $invoice->invoice_number }}</td>
                                <td class="py-3">{{ $invoice->customer->name ?? '-' }}</td>
                                <td class="py-3 font-semibold">${{ number_format($invoice->total, 2) }}</td>
                                <td class="py-3">
                                    <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const revenueLabels = @json($revenueChartLabels);
    const revenueData = @json($revenueChartData);

    new Chart(document.getElementById('revenueChart'), {
        type: 'line',
        data: {
            labels: revenueLabels,
            datasets: [{
                label: 'Revenue',
                data: revenueData,
                borderWidth: 2,
                tension: 0.4
            }]
        }
    });

    const paymentStatusData = @json($paymentStatusData);

    new Chart(document.getElementById('paymentStatusChart'), {
        type: 'doughnut',
        data: {
            labels: ['Completed', 'Pending', 'Failed'],
            datasets: [{
                data: paymentStatusData
            }]
        }
    });
</script>
@endsection