@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">

    <div class="bg-white rounded-2xl shadow-sm border p-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm">
                    {{ $notification->type }}
                </span>

                <h1 class="text-3xl font-bold text-gray-900 mt-4">
                    {{ $notification->title }}
                </h1>

                <p class="text-gray-500 mt-1">
                    {{ $notification->created_at->format('M d, Y h:i A') }}
                </p>
            </div>

            <a href="{{ route('notifications.edit', $notification) }}"
                class="px-5 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700">
                Edit Notification
            </a>
        </div>

        <div class="bg-gray-50 rounded-2xl border p-6">
            <p class="text-gray-800 leading-relaxed">
                {{ $notification->message }}
            </p>
        </div>
    </div>

</div>
@endsection