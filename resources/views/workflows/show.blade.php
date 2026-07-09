@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">

    <div class="bg-white rounded-2xl shadow-sm border p-8 mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $workflow->name }}</h1>
                <p class="text-gray-500 mt-1">{{ $workflow->description }}</p>
            </div>

            <form action="{{ route('workflows.run', $workflow) }}" method="POST">
                @csrf
                <button class="px-5 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700">
                    Run Workflow
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div>
                <p class="text-gray-500">Trigger</p>
                <p class="font-semibold">{{ $workflow->trigger_type }}</p>
            </div>

            <div>
                <p class="text-gray-500">Condition</p>
                <p class="font-semibold">{{ $workflow->condition_type ?? 'No Condition' }}</p>
            </div>

            <div>
                <p class="text-gray-500">Action</p>
                <p class="font-semibold">{{ $workflow->action_type }}</p>
            </div>

            <div>
                <p class="text-gray-500">Status</p>
                <p class="font-semibold">{{ $workflow->is_active ? 'Active' : 'Inactive' }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-5">Workflow Logs</h2>

        <table class="w-full text-left">
            <thead>
                <tr class="border-b text-gray-500 text-sm">
                    <th class="py-3">Status</th>
                    <th class="py-3">Message</th>
                    <th class="py-3">Executed At</th>
                </tr>
            </thead>

            <tbody>
                @forelse($workflow->logs as $log)
                    <tr class="border-b">
                        <td class="py-3">
                            @if($log->status == 'Completed')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">Completed</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">Failed</span>
                            @endif
                        </td>

                        <td class="py-3">{{ $log->message }}</td>

                        <td class="py-3">
                            {{ $log->executed_at ? \Carbon\Carbon::parse($log->executed_at)->format('M d, Y h:i A') : '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="py-4 text-gray-500">
                            No logs found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection