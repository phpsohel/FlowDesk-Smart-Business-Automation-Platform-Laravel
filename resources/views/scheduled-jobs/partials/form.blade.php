@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label class="block text-sm font-medium mb-2">Job Name</label>
        <input type="text" name="name" value="{{ old('name', $scheduledJob->name ?? '') }}"
            class="w-full border rounded-xl px-4 py-3" required>
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">Job Type</label>
        <select name="job_type" class="w-full border rounded-xl px-4 py-3" required>
            @foreach(['Invoice Reminder', 'Overdue Check', 'Weekly Report', 'Monthly Report', 'Low Stock Alert', 'Database Backup'] as $type)
                <option value="{{ $type }}" @selected(old('job_type', $scheduledJob->job_type ?? '') == $type)>
                    {{ $type }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">Frequency</label>
        <select name="frequency" class="w-full border rounded-xl px-4 py-3" required>
            @foreach(['Hourly', 'Daily', 'Weekly', 'Monthly'] as $frequency)
                <option value="{{ $frequency }}" @selected(old('frequency', $scheduledJob->frequency ?? '') == $frequency)>
                    {{ $frequency }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">Next Run At</label>
        <input type="datetime-local" name="next_run_at"
            value="{{ old('next_run_at', isset($scheduledJob->next_run_at) ? \Carbon\Carbon::parse($scheduledJob->next_run_at)->format('Y-m-d\TH:i') : '') }}"
            class="w-full border rounded-xl px-4 py-3">
    </div>

    <div>
        <label class="block text-sm font-medium mb-2">Status</label>
        <select name="status" class="w-full border rounded-xl px-4 py-3" required>
            @foreach(['Active', 'Paused', 'Failed'] as $status)
                <option value="{{ $status }}" @selected(old('status', $scheduledJob->status ?? 'Active') == $status)>
                    {{ $status }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="mt-6">
    <label class="block text-sm font-medium mb-2">Description</label>
    <textarea name="description" rows="5"
        class="w-full border rounded-xl px-4 py-3">{{ old('description', $scheduledJob->description ?? '') }}</textarea>
</div>

<div class="mt-8">
    <button class="px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700">
        Save Job
    </button>
</div>