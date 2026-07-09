<x-app-layout>
    <div class="p-8 bg-gray-50 min-h-screen">
        <h1 class="text-3xl font-bold text-gray-900">Good morning, admin! </h1>
        <p class="text-gray-500 mt-1">Here’s what’s happening with your business today.</p>
        <br>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <div class="text-sm text-gray-500">Total Revenue</div>
                <h2 class="text-2xl font-bold mt-2">$24,860</h2>
                <p class="text-green-600 text-sm mt-2">↗ 12.5% from last month</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <div class="text-sm text-gray-500">Total Invoices</div>
                <h2 class="text-2xl font-bold mt-2">146</h2>
                <p class="text-green-600 text-sm mt-2">↗ 8.3% from last month</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <div class="text-sm text-gray-500">Pending Invoices</div>
                <h2 class="text-2xl font-bold mt-2">32</h2>
                <p class="text-orange-500 text-sm mt-2">↗ 4.2% from last month</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <div class="text-sm text-gray-500">Total Customers</div>
                <h2 class="text-2xl font-bold mt-2">256</h2>
                <p class="text-green-600 text-sm mt-2">↗ 15.7% from last month</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <div class="text-sm text-gray-500">Pending Tasks</div>
                <h2 class="text-2xl font-bold mt-2">18</h2>
                <p class="text-orange-500 text-sm mt-2">↗ 2.1% from yesterday</p>
            </div>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

            <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-900">Revenue Overview</h3>
                    <span class="text-sm text-gray-500">This Month</span>
                </div>

                <div class="h-72 flex items-end gap-3 border-b border-l px-4">
                    @foreach([30, 55, 40, 48, 25, 30, 45, 70, 50, 35, 48, 62, 90, 58, 45, 38, 52, 60, 50, 72, 85] as $height)
                        <div class="flex-1 bg-indigo-500/70 rounded-t-lg" style="height: {{ $height }}%"></div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <h3 class="text-lg font-bold text-gray-900 mb-6">Recent Activities</h3>

                <div class="space-y-5">
                    <div>
                        <p class="font-medium text-gray-800">Invoice #INV-2025-146 created</p>
                        <p class="text-sm text-gray-500">2 minutes ago</p>
                    </div>

                    <div>
                        <p class="font-medium text-gray-800">Payment of $1,250 received</p>
                        <p class="text-sm text-gray-500">15 minutes ago</p>
                    </div>

                    <div>
                        <p class="font-medium text-gray-800">New customer John Doe added</p>
                        <p class="text-sm text-gray-500">1 hour ago</p>
                    </div>

                    <div>
                        <p class="font-medium text-gray-800">Workflow Invoice Reminder executed</p>
                        <p class="text-sm text-gray-500">3 hours ago</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tables -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <h3 class="text-lg font-bold mb-5">Recent Invoices</h3>

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
                        <tr>
                            <td class="py-3 text-indigo-600">INV-2025-146</td>
                            <td>Acme Corp</td>
                            <td>$1,250</td>
                            <td><span class="bg-green-100 text-green-700 px-3 py-1 rounded-full">Paid</span></td>
                        </tr>
                        <tr>
                            <td class="py-3 text-indigo-600">INV-2025-145</td>
                            <td>Globex Solutions</td>
                            <td>$980</td>
                            <td><span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full">Pending</span></td>
                        </tr>
                        <tr>
                            <td class="py-3 text-indigo-600">INV-2025-144</td>
                            <td>Innotech Ltd.</td>
                            <td>$1,750</td>
                            <td><span class="bg-red-100 text-red-700 px-3 py-1 rounded-full">Overdue</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <h3 class="text-lg font-bold mb-5">Upcoming Reminders</h3>

                <div class="space-y-4">
                    <div class="flex justify-between border-b pb-3">
                        <span>Invoice #INV-2025-145 due</span>
                        <span class="text-gray-500">Jun 20</span>
                    </div>
                    <div class="flex justify-between border-b pb-3">
                        <span>Subscription for Acme Corp</span>
                        <span class="text-gray-500">Jun 22</span>
                    </div>
                    <div class="flex justify-between border-b pb-3">
                        <span>Payment reminder for Globex</span>
                        <span class="text-gray-500">Jun 25</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Tax report generation</span>
                        <span class="text-gray-500">Jun 30</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Automation Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-indigo-50 p-6 rounded-2xl border">
                <p class="text-gray-500 text-sm">Automation Runs</p>
                <h2 class="text-3xl font-bold mt-2">128</h2>
                <p class="text-gray-500 text-sm mt-2">Total automation executed this month</p>
            </div>

            <div class="bg-green-50 p-6 rounded-2xl border">
                <p class="text-gray-500 text-sm">Emails Sent</p>
                <h2 class="text-3xl font-bold mt-2">542</h2>
                <p class="text-gray-500 text-sm mt-2">Total emails sent this month</p>
            </div>

            <div class="bg-orange-50 p-6 rounded-2xl border">
                <p class="text-gray-500 text-sm">Tasks Completed</p>
                <h2 class="text-3xl font-bold mt-2">64%</h2>
                <p class="text-gray-500 text-sm mt-2">vs last month 52%</p>
            </div>
        </div>
    </div>
</x-app-layout>
