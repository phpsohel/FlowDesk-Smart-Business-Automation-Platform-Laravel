@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Scheduled Jobs</h1>
            <p class="text-gray-500 mt-1">Manage automated background jobs and reminders.</p>
        </div>

        <a href="{{ route('scheduled-jobs.create') }}"
            class="px-5 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700">
            + Create Job
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Total Jobs</p>
            <h2 class="text-3xl font-bold mt-2">{{ \App\Models\ScheduledJob::count() }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Active Jobs</p>
            <h2 class="text-3xl font-bold mt-2">{{ \App\Models\ScheduledJob::where('status', 'Active')->count() }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Paused Jobs</p>
            <h2 class="text-3xl font-bold mt-2">{{ \App\Models\ScheduledJob::where('status', 'Paused')->count() }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Failed Jobs</p>
            <h2 class="text-3xl font-bold mt-2">{{ \App\Models\ScheduledJob::where('status', 'Failed')->count() }}</h2>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-xl font-bold text-gray-900">Job List</h2>

            <form action="{{ route('scheduled-jobs.index') }}" method="GET">
                <input type="search" name="search" value="{{ request('search') }}"
                    placeholder="Search jobs..."
                    class="border rounded-xl px-4 py-2 w-72">
            </form>
        </div>

        <table class="w-full text-left">
            <thead>
                <tr class="border-b text-gray-500 text-sm">
                    <th class="py-3">Job</th>
                    <th class="py-3">Type</th>
                    <th class="py-3">Frequency</th>
                    <th class="py-3">Last Run</th>
                    <th class="py-3">Next Run</th>
                    <th class="py-3">Status</th>
                    <th class="py-3 text-right">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($jobs as $job)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4">
                            <h3 class="font-semibold text-gray-900">{{ $job->name }}</h3>
                            <p class="text-sm text-gray-500">{{ Str::limit($job->description, 45) }}</p>
                        </td>

                        <td class="py-4">{{ $job->job_type }}</td>
                        <td class="py-4">{{ $job->frequency }}</td>
                        <td class="py-4">{{ $job->last_run_at ? \Carbon\Carbon::parse($job->last_run_at)->diffForHumans() : '-' }}</td>
                        <td class="py-4">{{ $job->next_run_at ? \Carbon\Carbon::parse($job->next_run_at)->format('M d, Y h:i A') : '-' }}</td>

                        <td class="py-4">
                            @if($job->status == 'Active')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">Active</span>
                            @elseif($job->status == 'Paused')
                                <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm">Paused</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">Failed</span>
                            @endif
                        </td>

                        <td class="py-4 text-right">
                            <form action="{{ route('scheduled-jobs.run', $job) }}" method="POST" class="inline">
                                @csrf
                                <button class="text-green-600 hover:underline">Run</button>
                            </form>

                            <a href="{{ route('scheduled-jobs.show', $job) }}" class="text-indigo-600 hover:underline ml-3">View</a>
                            <a href="{{ route('scheduled-jobs.edit', $job) }}" class="text-gray-500 hover:text-indigo-600 hover:underline ml-3">Edit</a>

                            <form action="{{ route('scheduled-jobs.destroy', $job) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete job?')" class="ml-3 text-red-600 hover:underline">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6">
            {{ $jobs->appends(request()->query())->links() }}
        </div>
    </div>

</div>
@endsection