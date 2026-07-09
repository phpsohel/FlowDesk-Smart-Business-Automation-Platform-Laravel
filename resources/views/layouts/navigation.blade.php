<div class="fixed inset-y-0 left-0 w-64 bg-white border-r border-gray-200 hidden lg:flex flex-col">

    <!-- Logo -->
    <div class="h-16 flex items-center px-6 border-b">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <x-application-logo class="h-9 w-auto text-indigo-600" />

            <div>
                <h1 class="font-bold text-lg text-gray-900">FlowDesk</h1>
                <p class="text-xs text-gray-500">Smart Automation</p>
            </div>
        </a>
    </div>

    <!-- Menu -->
    <div class="flex-1 px-4 py-6 space-y-6">

        <!-- Main -->
        <div>
            <p class="px-3 text-xs font-semibold text-gray-400 uppercase mb-3">
                Main
            </p>

            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
                {{ request()->routeIs('dashboard')
                ? 'bg-indigo-100 text-indigo-600'
                : 'text-gray-600 hover:bg-gray-100' }}">

                <i data-lucide="layout-dashboard" class="w-5 h-5"></i>

                Dashboard
            </a>

           <a href="{{ route('customers.index') }}"
   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium
   {{ request()->routeIs('customers.*') ? 'bg-indigo-100 text-indigo-600' : 'text-gray-600 hover:bg-gray-100' }}">
    <i data-lucide="users" class="w-5 h-5"></i>
    Customers
</a>

            <a href="{{ route('invoices.index') }}" class=" flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100{{ request()->routeIs('customers.*') ? 'bg-indigo-100 text-indigo-600' : 'text-gray-600 hover:bg-gray-100' }}">
                <i data-lucide="file-text" class="w-5 h-5"></i>
                Invoices
            </a>

            <a href="{{ route('payments.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100{{ request()->routeIs('payments.*') ? 'bg-indigo-100 text-indigo-600' : 'text-gray-600 hover:bg-gray-100' }}">
                <i data-lucide="wallet" class="w-5 h-5"></i>
                Payments
            </a>

            <a href="{{ route('products.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100">
                <i data-lucide="package" class="w-5 h-5"></i>
                Products
            </a>

            <a href="{{ route('tasks.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100">
                <i data-lucide="check-square" class="w-5 h-5"></i>
                Tasks
            </a>

        </div>

        <!-- Automation -->

        <div>

            <p class="px-3 text-xs font-semibold text-gray-400 uppercase mb-3">
                Automation
            </p>

            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100">
                <i data-lucide="workflow" class="w-5 h-5"></i>
                Workflows
            </a>

            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100">
                <i data-lucide="clock-3" class="w-5 h-5"></i>
                Scheduled Jobs
            </a>

            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100">
                <i data-lucide="mail" class="w-5 h-5"></i>
                Email Center
            </a>

            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100">
                <i data-lucide="bell" class="w-5 h-5"></i>
                Notifications
            </a>

        </div>

        <!-- Reports -->

        <div>

            <p class="px-3 text-xs font-semibold text-gray-400 uppercase mb-3">
                Reports
            </p>

            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100">
                <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                Reports
            </a>

            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-gray-600 hover:bg-gray-100">
                <i data-lucide="chart-column" class="w-5 h-5"></i>
                Analytics
            </a>

        </div>

    </div>

    <!-- Bottom -->

    <div class="p-4 border-t">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm font-semibold text-gray-800">
                    {{ Auth::user()->name }}
                </p>

                <p class="text-xs text-gray-500">
                    Administrator
                </p>

            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button class="text-red-500 hover:text-red-700">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                </button>

            </form>

        </div>

    </div>

</div>