<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
        <select name="customer_id" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">Select Customer</option>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}"
                    {{ old('customer_id', $invoice->customer_id ?? '') == $customer->id ? 'selected' : '' }}>
                    {{ $customer->name }}
                </option>
            @endforeach
        </select>
        @error('customer_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Invoice Date</label>
        <input type="date" name="invoice_date"
               value="{{ old('invoice_date', $invoice->invoice_date ?? date('Y-m-d')) }}"
               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Due Date</label>
        <input type="date" name="due_date"
               value="{{ old('due_date', $invoice->due_date ?? '') }}"
               class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
    </div>
</div>

<div class="mb-8">
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-lg font-bold text-gray-900">Invoice Items</h3>

        <button type="button" onclick="addItem()"
                class="px-3 py-2 bg-gray-900 text-white rounded-lg text-sm">
            + Add Item
        </button>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500">
                <tr>
                    <th class="px-3 py-3 text-left">Product</th>
                    <th class="px-3 py-3 text-left">Item Name</th>
                    <th class="px-3 py-3 text-left">Qty</th>
                    <th class="px-3 py-3 text-left">Price</th>
                    <th class="px-3 py-3 text-left">Total</th>
                    <th class="px-3 py-3 text-right">Remove</th>
                </tr>
            </thead>

            <tbody id="items-wrapper">
                @php
                    $oldItems = old('items', isset($invoice) ? $invoice->items->toArray() : [
                        ['product_id' => '', 'item_name' => '', 'quantity' => 1, 'price' => 0]
                    ]);
                @endphp

                @foreach($oldItems as $index => $item)
                    <tr class="item-row border-b">
                        <td class="px-3 py-3">
                            <select name="items[{{ $index }}][product_id]"
                                    onchange="selectProduct(this)"
                                    class="product-select w-44 rounded-lg border-gray-300">
                                <option value="">Custom Item</option>

                                @foreach($products as $product)
                                    <option value="{{ $product->id }}"
                                            data-name="{{ $product->name }}"
                                            data-price="{{ $product->price }}"
                                        {{ ($item['product_id'] ?? '') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </td>

                        <td class="px-3 py-3">
                            <input type="text"
                                   name="items[{{ $index }}][item_name]"
                                   value="{{ $item['item_name'] ?? '' }}"
                                   class="item-name w-52 rounded-lg border-gray-300">
                        </td>

                        <td class="px-3 py-3">
                            <input type="number"
                                   name="items[{{ $index }}][quantity]"
                                   value="{{ $item['quantity'] ?? 1 }}"
                                   min="1"
                                   oninput="calculateTotal()"
                                   class="qty w-24 rounded-lg border-gray-300">
                        </td>

                        <td class="px-3 py-3">
                            <input type="number"
                                   step="0.01"
                                   name="items[{{ $index }}][price]"
                                   value="{{ $item['price'] ?? 0 }}"
                                   oninput="calculateTotal()"
                                   class="price w-28 rounded-lg border-gray-300">
                        </td>

                        <td class="px-3 py-3">
                            <span class="row-total font-medium">$0.00</span>
                        </td>

                        <td class="px-3 py-3 text-right">
                            <button type="button" onclick="removeItem(this)"
                                    class="text-red-600 hover:text-red-800">
                                Remove
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
        <textarea name="notes" rows="5"
                  class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ old('notes', $invoice->notes ?? '') }}</textarea>
    </div>

    <div class="bg-gray-50 rounded-xl p-5 space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Tax</label>
            <input type="number" step="0.01" name="tax" id="tax"
                   value="{{ old('tax', $invoice->tax ?? 0) }}"
                   oninput="calculateTotal()"
                   class="w-full rounded-lg border-gray-300">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Discount</label>
            <input type="number" step="0.01" name="discount" id="discount"
                   value="{{ old('discount', $invoice->discount ?? 0) }}"
                   oninput="calculateTotal()"
                   class="w-full rounded-lg border-gray-300">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full rounded-lg border-gray-300">
                @foreach(['draft', 'sent', 'paid', 'overdue', 'cancelled'] as $status)
                    <option value="{{ $status }}"
                        {{ old('status', $invoice->status ?? 'draft') == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="border-t pt-4 space-y-2">
            <div class="flex justify-between">
                <span>Subtotal</span>
                <strong id="subtotalText">$0.00</strong>
            </div>

            <div class="flex justify-between text-lg font-bold">
                <span>Total</span>
                <strong id="totalText">$0.00</strong>
            </div>
        </div>
    </div>
</div>

<script>
    let itemIndex = {{ count($oldItems) }};

    function addItem() {
        const wrapper = document.getElementById('items-wrapper');

        const row = `
            <tr class="item-row border-b">
                <td class="px-3 py-3">
                    <select name="items[${itemIndex}][product_id]" onchange="selectProduct(this)" class="product-select w-44 rounded-lg border-gray-300">
                        <option value="">Custom Item</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}">
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </td>

                <td class="px-3 py-3">
                    <input type="text" name="items[${itemIndex}][item_name]" class="item-name w-52 rounded-lg border-gray-300">
                </td>

                <td class="px-3 py-3">
                    <input type="number" name="items[${itemIndex}][quantity]" value="1" min="1" oninput="calculateTotal()" class="qty w-24 rounded-lg border-gray-300">
                </td>

                <td class="px-3 py-3">
                    <input type="number" step="0.01" name="items[${itemIndex}][price]" value="0" oninput="calculateTotal()" class="price w-28 rounded-lg border-gray-300">
                </td>

                <td class="px-3 py-3">
                    <span class="row-total font-medium">$0.00</span>
                </td>

                <td class="px-3 py-3 text-right">
                    <button type="button" onclick="removeItem(this)" class="text-red-600 hover:text-red-800">Remove</button>
                </td>
            </tr>
        `;

        wrapper.insertAdjacentHTML('beforeend', row);
        itemIndex++;
    }

    function removeItem(button) {
        if (document.querySelectorAll('.item-row').length > 1) {
            button.closest('tr').remove();
            calculateTotal();
        }
    }

    function selectProduct(select) {
        const option = select.options[select.selectedIndex];
        const row = select.closest('tr');

        if (option.value) {
            row.querySelector('.item-name').value = option.dataset.name;
            row.querySelector('.price').value = option.dataset.price;
        }

        calculateTotal();
    }

    function calculateTotal() {
        let subtotal = 0;

        document.querySelectorAll('.item-row').forEach(row => {
            const qty = parseFloat(row.querySelector('.qty').value) || 0;
            const price = parseFloat(row.querySelector('.price').value) || 0;
            const total = qty * price;

            row.querySelector('.row-total').innerText = '$' + total.toFixed(2);
            subtotal += total;
        });

        const tax = parseFloat(document.getElementById('tax').value) || 0;
        const discount = parseFloat(document.getElementById('discount').value) || 0;
        const grandTotal = subtotal + tax - discount;

        document.getElementById('subtotalText').innerText = '$' + subtotal.toFixed(2);
        document.getElementById('totalText').innerText = '$' + grandTotal.toFixed(2);
    }

    calculateTotal();
</script>