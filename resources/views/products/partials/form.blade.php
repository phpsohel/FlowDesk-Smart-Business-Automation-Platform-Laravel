@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium mb-2">Product Name</label>
        <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}"
            class="w-full border rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-500" required>
        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">Category</label>
        <select name="category_id" class="w-full border rounded-xl px-4 py-3">
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    @selected(old('category_id', $product->category_id ?? '') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">SKU</label>
        <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}"
            class="w-full border rounded-xl px-4 py-3">
        @error('sku') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">Price</label>
        <input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}"
            class="w-full border rounded-xl px-4 py-3" required>
        @error('price') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">Stock</label>
        <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}"
            class="w-full border rounded-xl px-4 py-3" required>
        @error('stock') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">Status</label>
        <select name="status" class="w-full border rounded-xl px-4 py-3">
            <option value="Active" @selected(old('status', $product->status ?? '') == 'Active')>Active</option>
            <option value="Inactive" @selected(old('status', $product->status ?? '') == 'Inactive')>Inactive</option>
        </select>
        @error('status') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-6">
    <label class="block text-sm font-medium mb-2">Description</label>
    <textarea name="description" rows="5"
        class="w-full border rounded-xl px-4 py-3">{{ old('description', $product->description ?? '') }}</textarea>
</div>

<div class="mt-8">
    <button class="px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700">
        Save Product
    </button>
</div>