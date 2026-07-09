@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div>
        <label class="block text-sm font-medium mb-2">Customer</label>
        <select name="customer_id" class="w-full border rounded-xl px-4 py-3" required>
            <option value="">Select Customer</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}"
                    @selected(old('customer_id', $payment->customer_id ?? '') == $customer->id)>
                    {{ $customer->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">Invoice</label>
        <select name="invoice_id" class="w-full border rounded-xl px-4 py-3" required>
            <option value="">Select Invoice</option>
            @foreach($invoices as $invoice)
                <option value="{{ $invoice->id }}"
                    @selected(old('invoice_id', $payment->invoice_id ?? '') == $invoice->id)>
                    {{ $invoice->invoice_number }} - {{ $invoice->customer->name ?? '' }} - ${{ number_format($invoice->total, 2) }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">Amount</label>
        <input type="number" step="0.01" name="amount"
            value="{{ old('amount', $payment->amount ?? '') }}"
            class="w-full border rounded-xl px-4 py-3" required>
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">Payment Date</label>
        <input type="date" name="payment_date"
            value="{{ old('payment_date', isset($payment) ? $payment->payment_date : date('Y-m-d')) }}"
            class="w-full border rounded-xl px-4 py-3" required>
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">Payment Method</label>
        <select name="payment_method" class="w-full border rounded-xl px-4 py-3" required>
            @foreach(['Cash', 'Bank', 'Card', 'Stripe', 'PayPal'] as $method)
                <option value="{{ $method }}"
                    @selected(old('payment_method', $payment->payment_method ?? '') == $method)>
                    {{ $method }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">Status</label>
        <select name="status" class="w-full border rounded-xl px-4 py-3" required>
            @foreach(['Completed', 'Pending', 'Failed'] as $status)
                <option value="{{ $status }}"
                    @selected(old('status', $payment->status ?? '') == $status)>
                    {{ $status }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-2">Reference</label>
        <input type="text" name="reference"
            value="{{ old('reference', $payment->reference ?? '') }}"
            class="w-full border rounded-xl px-4 py-3">
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-2">Notes</label>
        <textarea name="notes" rows="5"
            class="w-full border rounded-xl px-4 py-3">{{ old('notes', $payment->notes ?? '') }}</textarea>
    </div>

</div>

<div class="mt-8">
    <button class="px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700">
        Save Payment
    </button>
</div>