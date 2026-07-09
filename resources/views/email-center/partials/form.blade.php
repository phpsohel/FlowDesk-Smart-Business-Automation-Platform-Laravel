@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium mb-2">Template Name</label>
        <input type="text" name="name" value="{{ old('name', $template->name ?? '') }}"
            class="w-full border rounded-xl px-4 py-3" required>
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">Type</label>
        <select name="type" class="w-full border rounded-xl px-4 py-3" required>
            @foreach(['General', 'Welcome Email', 'Invoice Reminder', 'Payment Received', 'Workflow Alert'] as $type)
                <option value="{{ $type }}" @selected(old('type', $template->type ?? '') == $type)>
                    {{ $type }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-2">Subject</label>
        <input type="text" name="subject" value="{{ old('subject', $template->subject ?? '') }}"
            class="w-full border rounded-xl px-4 py-3" required>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium mb-2">Email Body</label>
        <textarea name="body" rows="10"
            class="w-full border rounded-xl px-4 py-3" required>{{ old('body', $template->body ?? '') }}</textarea>
    </div>
</div>

<div class="mt-6">
    <label class="flex items-center gap-3">
        <input type="checkbox" name="is_active" value="1"
            class="rounded text-indigo-600"
            @checked(old('is_active', $template->is_active ?? true))>
        <span class="font-medium text-gray-700">Active Template</span>
    </label>
</div>

<div class="mt-8">
    <button class="px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700">
        Save Template
    </button>
</div>