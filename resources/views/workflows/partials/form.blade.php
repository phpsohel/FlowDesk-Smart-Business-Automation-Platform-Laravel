@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div>
        <label class="block text-sm font-medium mb-2">Workflow Name</label>
        <input type="text" name="name" value="{{ old('name', $workflow->name ?? '') }}"
            class="w-full border rounded-xl px-4 py-3" required>
        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">Trigger</label>
        <select name="trigger_type" class="w-full border rounded-xl px-4 py-3" required>
            <option value="">Select Trigger</option>
            @foreach(['New Customer', 'Invoice Created', 'Invoice Overdue', 'Payment Received', 'Manual Run'] as $trigger)
                <option value="{{ $trigger }}" @selected(old('trigger_type', $workflow->trigger_type ?? '') == $trigger)>
                    {{ $trigger }}
                </option>
            @endforeach
        </select>
        @error('trigger_type') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">Condition</label>
        <select name="condition_type" class="w-full border rounded-xl px-4 py-3">
            <option value="">No Condition</option>
            @foreach(['Immediately', 'After 1 Day', 'After 3 Days', 'If Status Pending', 'If Status Overdue'] as $condition)
                <option value="{{ $condition }}" @selected(old('condition_type', $workflow->condition_type ?? '') == $condition)>
                    {{ $condition }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">Action</label>
        <select name="action_type" class="w-full border rounded-xl px-4 py-3" required>
            <option value="">Select Action</option>
            @foreach(['Send Email', 'Create Notification', 'Create Task', 'Send Invoice Reminder', 'Mark Invoice Overdue'] as $action)
                <option value="{{ $action }}" @selected(old('action_type', $workflow->action_type ?? '') == $action)>
                    {{ $action }}
                </option>
            @endforeach
        </select>
        @error('action_type') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

</div>

<div class="mt-6">
    <label class="block text-sm font-medium mb-2">Description</label>
    <textarea name="description" rows="5"
        class="w-full border rounded-xl px-4 py-3">{{ old('description', $workflow->description ?? '') }}</textarea>
</div>

<div class="mt-6">
    <label class="flex items-center gap-3">
        <input type="checkbox" name="is_active" value="1"
            class="rounded text-indigo-600"
            @checked(old('is_active', $workflow->is_active ?? true))>
        <span class="font-medium text-gray-700">Active Workflow</span>
    </label>
</div>

<div class="mt-8">
    <button class="px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700">
        Save Workflow
    </button>
</div>