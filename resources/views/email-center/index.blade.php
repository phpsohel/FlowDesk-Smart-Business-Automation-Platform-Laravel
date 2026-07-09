@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Email Center</h1>
            <p class="text-gray-500 mt-1">Manage automation email templates.</p>
        </div>

        <a href="{{ route('email-center.create') }}"
            class="px-5 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700">
            + Create Template
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Total Templates</p>
            <h2 class="text-3xl font-bold mt-2">{{ $templates->total() }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Active Templates</p>
            <h2 class="text-3xl font-bold mt-2">{{ \App\Models\EmailTemplate::where('is_active', true)->count() }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Sent Emails</p>
            <h2 class="text-3xl font-bold mt-2">{{ \App\Models\EmailLog::where('status', 'Sent')->count() }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Failed Emails</p>
            <h2 class="text-3xl font-bold mt-2">{{ \App\Models\EmailLog::where('status', 'Failed')->count() }}</h2>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border p-6">
        <div class="flex justify-between mb-5">
            <h2 class="text-xl font-bold">Template List</h2>

            <form action="{{ route('email-center.index') }}" method="GET">
                <input type="search" name="search" value="{{ request('search') }}"
                    placeholder="Search templates..."
                    class="border rounded-xl px-4 py-2 w-72">
            </form>
        </div>

        <table class="w-full text-left">
            <thead>
                <tr class="border-b text-gray-500 text-sm">
                    <th class="py-3">Name</th>
                    <th class="py-3">Subject</th>
                    <th class="py-3">Type</th>
                    <th class="py-3">Status</th>
                    <th class="py-3 text-right">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($templates as $template)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-4 font-semibold">{{ $template->name }}</td>
                        <td class="py-4">{{ $template->subject }}</td>
                        <td class="py-4">{{ $template->type }}</td>
                        <td class="py-4">
                            @if($template->is_active)
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">Active</span>
                            @else
                                <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">Inactive</span>
                            @endif
                        </td>
                        <td class="py-4 text-right">
                            <a href="{{ route('email-center.show', $template) }}" class="text-indigo-600">View</a>
                            <a href="{{ route('email-center.edit', $template) }}" class="ml-3 text-gray-500">Edit</a>

                            <form action="{{ route('email-center.destroy', $template) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Delete template?')" class="ml-3 text-red-600">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6">
            {{ $templates->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection