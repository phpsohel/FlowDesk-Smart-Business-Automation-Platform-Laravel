<x-app-layout>
    <div class="p-8 bg-gray-50 min-h-screen">

        <h1 class="text-3xl font-bold text-gray-900">
            Good morning, {{ auth()->user()->name ?? 'admin' }}!
        </h1>

        <p class="text-gray-500 mt-1">
            Here’s what’s happening with your business today.
        </p>

        <br>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">

            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <div class="text-sm text-gray-500">Total Revenue</div>
                <h2 class="text-2xl font-bold mt-2">
                    ${{ number_format($totalRevenue, 2) }}
                </h2>
                <p class="text-green-600 text-sm mt-2">
                    Completed payments only
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <div class="text-sm text-gray-500">Total Invoices</div>
                <h2 class="text-2xl font-bold mt-2">
                    {{ $totalInvoices }}
                </h2>
                <p class="text-green-600 text-sm mt-2">
                    All invoices
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <div class="text-sm text-gray-500">Pending Invoices</div>
                <h2 class="text-2xl font-bold mt-2">
                    {{ $pendingInvoices }}
                </h2>
                <p class="text-orange-500 text-sm mt-2">
                    Draft, unpaid, partial or overdue
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <div class="text-sm text-gray-500">Total Customers</div>
                <h2 class="text-2xl font-bold mt-2">
                    {{ $totalCustomers }}
                </h2>
                <p class="text-green-600 text-sm mt-2">
                    Active customer database
                </p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <div class="text-sm text-gray-500">Total Products</div>
                <h2 class="text-2xl font-bold mt-2">
                    {{ $totalProducts }}
                </h2>
                <p class="text-green-600 text-sm mt-2">
                    Products and services
                </p>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900">
                        Revenue Overview
                    </h3>

                    <span class="text-sm text-gray-500">
                        This Month
                    </span>
                </div>

                <div class="h-72 flex items-end gap-3 border-b border-l px-4">
                    @php
                        $maxRevenue = max($chartData) > 0 ? max($chartData) : 1;
                    @endphp

                    @foreach($chartData as $amount)
                        @php
                            $height = ($amount / $maxRevenue) * 100;
                        @endphp

                        <div
                            class="flex-1 bg-indigo-500/70 rounded-t-lg"
                            title="${{ number_format($amount, 2) }}"
                            style="height: {{ max($height, 5) }}%">
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <h3 class="text-lg font-bold text-gray-900 mb-6">
                    Recent Activities
                </h3>

                <div class="space-y-5">
                    @forelse($recentPayments as $payment)
                        <div>
                            <p class="font-medium text-gray-800">
                                Payment of ${{ number_format($payment->amount, 2) }} received
                            </p>

                            <p class="text-sm text-gray-500">
                                {{ $payment->created_at->diffForHumans() }}
                            </p>
                        </div>
                    @empty
                        <p class="text-gray-500">
                            No recent activities.
                        </p>
                    @endforelse
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <h3 class="text-lg font-bold mb-5">
                    Recent Invoices
                </h3>

                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-gray-500 border-b">
                            <th class="pb-3">Invoice</th>
                            <th class="pb-3">Customer</th>
                            <th class="pb-3">Amount</th>
                            <th class="pb-3">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">
                        @forelse($recentInvoices as $invoice)
                            <tr>
                                <td class="py-3 text-indigo-600">
                                    {{ $invoice->invoice_number }}
                                </td>

                                <td>
                                    {{ $invoice->customer->name ?? '-' }}
                                </td>

                                <td>
                                    ${{ number_format($invoice->total, 2) }}
                                </td>

                                <td>
                                    @if($invoice->status == 'paid')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">
                                            Paid
                                        </span>
                                    @elseif($invoice->status == 'overdue')
                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">
                                            Overdue
                                        </span>
                                    @elseif($invoice->status == 'partial')
                                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full">
                                            Partial
                                        </span>
                                    @else
                                        <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full">
                                            {{ ucfirst($invoice->status) }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-gray-500">
                                    No invoices found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <h3 class="text-lg font-bold mb-5">
                    Upcoming Reminders
                </h3>

                <div class="space-y-4">
                    @forelse($upcomingInvoices as $invoice)
                        <div class="flex justify-between border-b pb-3">
                            <span>
                                Invoice {{ $invoice->invoice_number }} due
                            </span>

                            <span class="text-gray-500">
                                {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d') }}
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-500">
                            No upcoming reminders.
                        </p>
                    @endforelse
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div class="bg-indigo-50 p-6 rounded-2xl border">
                <p class="text-gray-500 text-sm">Automation Runs</p>
                <h2 class="text-3xl font-bold mt-2">
                    {{ $automationRuns }}
                </h2>
                <p class="text-gray-500 text-sm mt-2">
                    Total automation executed this month
                </p>
            </div>

            <div class="bg-green-50 p-6 rounded-2xl border">
                <p class="text-gray-500 text-sm">Emails Sent</p>
                <h2 class="text-3xl font-bold mt-2">
                    {{ $emailsSent }}
                </h2>
                <p class="text-gray-500 text-sm mt-2">
                    Total emails sent this month
                </p>
            </div>

            <div class="bg-orange-50 p-6 rounded-2xl border">
                <p class="text-gray-500 text-sm">Tasks Completed</p>
                <h2 class="text-3xl font-bold mt-2">
                    {{ $tasksCompleted }}%
                </h2>
                <p class="text-gray-500 text-sm mt-2">
                    Workflow and task completion rate
                </p>
            </div>

        </div>

    </div>
</x-app-layout>