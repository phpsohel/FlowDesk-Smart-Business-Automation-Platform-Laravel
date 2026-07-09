<x-app-layout>
    <div class="py-8 px-6 max-w-4xl mx-auto">

        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $customer->name }}</h1>
                <p class="text-gray-500">Customer details</p>
            </div>

            <a href="{{ route('customers.edit', $customer) }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-indigo-700">
                Edit Customer
            </a>
        </div>

        <div class="bg-white rounded-2xl border shadow-sm p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Company</p>
                    <p class="font-medium">{{ $customer->company ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-medium">{{ $customer->email }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Phone</p>
                    <p class="font-medium">{{ $customer->phone ?? '-' }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500">Status</p>
                    <p class="font-medium">{{ ucfirst($customer->status) }}</p>
                </div>

                <div class="md:col-span-2">
                    <p class="text-sm text-gray-500">Address</p>
                    <p class="font-medium">{{ $customer->address ?? '-' }}</p>
                </div>

                <div class="md:col-span-2">
                    <p class="text-sm text-gray-500">Notes</p>
                    <p class="font-medium">{{ $customer->notes ?? '-' }}</p>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>