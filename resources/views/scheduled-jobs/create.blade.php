@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Create Scheduled Job</h1>

    <div class="bg-white rounded-2xl shadow-sm border p-8">
        <form action="{{ route('scheduled-jobs.store') }}" method="POST">
            @include('scheduled-jobs.partials.form')
        </form>
    </div>
</div>
@endsection