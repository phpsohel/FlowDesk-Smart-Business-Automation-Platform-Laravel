@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">

    <div class="bg-white rounded-2xl shadow-sm border p-8">
        <h1 class="text-3xl font-bold text-gray-900">{{ $template->name }}</h1>
        <p class="text-gray-500 mt-1">{{ $template->type }}</p>

        <div class="mt-8">
            <p class="text-gray-500">Subject</p>
            <h2 class="text-xl font-bold">{{ $template->subject }}</h2>
        </div>

        <div class="mt-8">
            <p class="text-gray-500 mb-2">Body</p>
            <div class="bg-gray-50 rounded-xl border p-5 whitespace-pre-line">
                {{ $template->body }}
            </div>
        </div>
    </div>

</div>
@endsection