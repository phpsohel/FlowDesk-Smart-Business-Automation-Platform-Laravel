@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">

    <div class="bg-white rounded-2xl shadow-sm border p-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $scheduledJob->name }}</h1>
                <p class="text-gray-500 mt-1">{{ $scheduledJob->description }}</p>
            </div>

            <form action="{{ route('scheduled-jobs.run', $scheduledJob) }}" method="POST">
                @csrf
                <button class="px-5 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700">
                    Run Job
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <p class="text-gray-500">Type</p>
                <p class="font-semibold">{{ $scheduledJob->job_type }}</p>
            </div>

            <div>
                <p class="text-gray-500">Frequency</p>
                <p class="font-semibold">{{ $scheduledJob->frequency }}</p>
            </div>

            <div>
                <p class="text-gray-500">Status</p>
                <p class="font-semibold">{{ $scheduledJob->status }}</p>
            </div>

            <div>
                <p class="text-gray-500">Last Run</p>
                <p class="font-semibold">
                    {{ $scheduledJob->last_run_at ? \Carbon\Carbon::parse($scheduledJob->last_run_at)->format('M d, Y h:i A') : '-' }}
                </p>
            </div>

            <div>
                <p class="text-gray-500">Next Run</p>
                <p class="font-semibold">
                    {{ $scheduledJob->next_run_at ? \Carbon\Carbon::parse($scheduledJob->next_run_at)->format('M d, Y h:i A') : '-' }}
                </p>
            </div>
        </div>
    </div>

</div>
@endsection