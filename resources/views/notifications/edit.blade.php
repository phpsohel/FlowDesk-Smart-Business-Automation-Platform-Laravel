@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Edit Notification</h1>

    <div class="bg-white rounded-2xl shadow-sm border p-8">
        <form action="{{ route('notifications.update', $notification) }}" method="POST">
            @method('PUT')
            @include('notifications.partials.form')
        </form>
    </div>
</div>
@endsection