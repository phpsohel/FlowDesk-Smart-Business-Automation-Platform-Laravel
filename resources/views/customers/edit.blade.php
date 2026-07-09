<x-app-layout>
    <div class="py-8 px-6 max-w-4xl mx-auto">

        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Edit Customer</h1>
            <p class="text-gray-500">Update customer information.</p>
        </div>

        <div class="bg-white rounded-2xl border shadow-sm p-6">
            <form method="POST" action="{{ route('customers.update', $customer) }}">
                @csrf
                @method('PUT')

                @include('customers.partials.form')

                <div class="flex justify-end gap-3 mt-6">
                    <a href="{{ route('customers.index') }}"
                       class="px-4 py-2 border rounded-lg text-sm">
                        Cancel
                    </a>

                    <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm hover:bg-indigo-700">
                        Update Customer
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>