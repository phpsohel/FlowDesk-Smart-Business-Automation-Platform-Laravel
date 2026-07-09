@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium mb-2">Title</label>
        <input type="text" name="title" value="{{ old('title', $notification->title ?? '') }}"
            class="w-full border rounded-xl px-4 py-3" required>
        @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">Type</label>
        <select name="type" class="w-full border rounded-xl px-4 py-3" required>
            @foreach(['General', 'Invoice', 'Payment', 'Workflow', 'Email', 'Product', 'System'] as $type)
                <option value="{{ $type }}" @selected(old('type', $notification->type ?? '') == $type)>
                    {{ $type }}
                </option>
            @endforeach
        </select>
        @error('type') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>
</div>

<div class="mt-6">
    <label class="block text-sm font-medium mb-2">Message</label>
    <textarea name="message" rows="6"
        class="w-full border rounded-xl px-4 py-3" required>{{ old('message', $notification->message ?? '') }}</textarea>
    @error('message') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
</div>

<div class="mt-6">
    <label class="flex items-center gap-3">
        <input type="checkbox" name="is_read" value="1"
            class="rounded text-indigo-600"
            @checked(old('is_read', $notification->is_read ?? false))>
        <span class="font-medium text-gray-700">Mark as Read</span>
    </label>
</div>

<div class="mt-8">
    <button class="px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700">
        Save Notification
    </button>
</div>