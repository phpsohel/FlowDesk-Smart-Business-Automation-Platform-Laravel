@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">

    <h1 class="text-3xl font-bold text-gray-900 mb-6">Email Logs</h1>

    <div class="bg-white rounded-2xl shadow-sm border p-6">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b text-gray-500 text-sm">
                    <th class="py-3">Template</th>
                    <th class="py-3">To</th>
                    <th class="py-3">Subject</th>
                    <th class="py-3">Status</th>
                    <th class="py-3">Sent At</th>
                </tr>
            </thead>

            <tbody>
                @foreach($logs as $log)
                    <tr class="border-b">
                        <td class="py-4">{{ $log->template->name ?? '-' }}</td>
                        <td class="py-4">{{ $log->to_email }}</td>
                        <td class="py-4">{{ $log->subject }}</td>
                        <td class="py-4">
                            @if($log->status == 'Sent')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">Sent</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">Failed</span>
                            @endif
                        </td>
                        <td class="py-4">{{ $log->sent_at ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection