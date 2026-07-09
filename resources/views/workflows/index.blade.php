@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Workflows</h1>
            <p class="text-gray-500 mt-1">Create and manage automation workflows.</p>
        </div>

        <a href="{{ route('workflows.create') }}"
            class="inline-flex items-center px-5 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition">
            + Create Workflow
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Total Workflows</p>
            <h2 class="text-3xl font-bold mt-2">{{ $workflows->total() }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Active Workflows</p>
            <h2 class="text-3xl font-bold mt-2">{{ \App\Models\Workflow::where('is_active', true)->count() }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Inactive Workflows</p>
            <h2 class="text-3xl font-bold mt-2">{{ \App\Models\Workflow::where('is_active', false)->count() }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Total Runs</p>
            <h2 class="text-3xl font-bold mt-2">{{ \App\Models\WorkflowLog::count() }}</h2>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-xl font-bold text-gray-900">Workflow List</h2>

            <form action="{{ route('workflows.index') }}" method="GET">
                <input type="search" name="search" value="{{ request('search') }}"
                    placeholder="Search workflows..."
                    class="border rounded-xl px-4 py-2 w-72">
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b text-gray-500 text-sm">
                        <th class="py-3">Workflow</th>
                        <th class="py-3">Trigger</th>
                        <th class="py-3">Condition</th>
                        <th class="py-3">Action</th>
                        <th class="py-3">Runs</th>
                        <th class="py-3">Status</th>
                        <th class="py-3 text-right">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($workflows as $workflow)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-4">
                                <h3 class="font-semibold text-gray-900">{{ $workflow->name }}</h3>
                                <p class="text-sm text-gray-500">{{ Str::limit($workflow->description, 45) }}</p>
                            </td>

                            <td class="py-4">{{ $workflow->trigger_type }}</td>
                            <td class="py-4">{{ $workflow->condition_type ?? 'No Condition' }}</td>
                            <td class="py-4">{{ $workflow->action_type }}</td>
                            <td class="py-4">{{ $workflow->logs_count }}</td>

                            <td class="py-4">
                                @if($workflow->is_active)
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">Active</span>
                                @else
                                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">Inactive</span>
                                @endif
                            </td>

                            <td class="py-4 text-right">
                                <form action="{{ route('workflows.run', $workflow) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="text-green-600 hover:underline">Run</button>
                                </form>

                                <a href="{{ route('workflows.show', $workflow) }}" class="text-indigo-600 hover:underline ml-3">View</a>

                                <a href="{{ route('workflows.edit', $workflow) }}" class="text-gray-500 hover:text-indigo-600 hover:underline ml-3">Edit</a>

                                <form action="{{ route('workflows.destroy', $workflow) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Delete workflow?')" class="ml-3 text-red-600 hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-6">
                {{ $workflows->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection