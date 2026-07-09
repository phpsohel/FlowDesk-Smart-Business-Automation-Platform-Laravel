@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">

    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Notifications</h1>
            <p class="text-gray-500 mt-1">Manage system and automation notifications.</p>
        </div>

        <a href="{{ route('notifications.create') }}"
            class="px-5 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700">
            + Create Notification
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Total Notifications</p>
            <h2 class="text-3xl font-bold mt-2">{{ \App\Models\Notification::count() }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Unread</p>
            <h2 class="text-3xl font-bold mt-2">{{ \App\Models\Notification::where('is_read', false)->count() }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Read</p>
            <h2 class="text-3xl font-bold mt-2">{{ \App\Models\Notification::where('is_read', true)->count() }}</h2>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border">
            <p class="text-gray-500">Today</p>
            <h2 class="text-3xl font-bold mt-2">{{ \App\Models\Notification::whereDate('created_at', today())->count() }}</h2>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-xl font-bold text-gray-900">Notification List</h2>

            <div class="flex gap-3">
                <form action="{{ route('notifications.index') }}" method="GET">
                    <input type="search" name="search" value="{{ request('search') }}"
                        placeholder="Search notifications..."
                        class="border rounded-xl px-4 py-2 w-72">
                </form>

                <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <button class="bg-gray-100 text-gray-700 px-4 py-2 rounded-xl hover:bg-gray-200">
                        Mark All Read
                    </button>
                </form>
            </div>
        </div>

        <div class="space-y-4">
            @foreach($notifications as $notification)
                <div class="border rounded-2xl p-5 flex items-start justify-between
                    {{ $notification->is_read ? 'bg-white' : 'bg-indigo-50 border-indigo-100' }}">

                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-3 py-1 rounded-full text-xs
                                @if($notification->type == 'Payment') bg-green-100 text-green-700
                                @elseif($notification->type == 'Invoice') bg-orange-100 text-orange-700
                                @elseif($notification->type == 'Workflow') bg-indigo-100 text-indigo-700
                                @elseif($notification->type == 'Email') bg-blue-100 text-blue-700
                                @elseif($notification->type == 'Product') bg-red-100 text-red-700
                                @else bg-gray-100 text-gray-700
                                @endif">
                                {{ $notification->type }}
                            </span>

                            @if(!$notification->is_read)
                                <span class="text-xs text-indigo-600 font-semibold">Unread</span>
                            @endif
                        </div>

                        <h3 class="font-bold text-gray-900">{{ $notification->title }}</h3>
                        <p class="text-gray-500 mt-1">{{ $notification->message }}</p>
                        <p class="text-sm text-gray-400 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('notifications.show', $notification) }}" class="text-indigo-600">View</a>

                        @if(!$notification->is_read)
                            <form action="{{ route('notifications.mark-read', $notification) }}" method="POST">
                                @csrf
                                <button class="text-green-600">Read</button>
                            </form>
                        @endif

                        <a href="{{ route('notifications.edit', $notification) }}" class="text-gray-500">Edit</a>

                        <form action="{{ route('notifications.destroy', $notification) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Delete notification?')" class="text-red-600">
                                Delete
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $notifications->appends(request()->query())->links() }}
        </div>
    </div>

</div>
@endsection