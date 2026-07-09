@extends('layouts.app')

@section('content')
<div class="p-8 bg-gray-50 min-h-screen">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Edit Workflow</h1>
        <p class="text-gray-500 mt-1">Update automation workflow.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border p-8">
        <form action="{{ route('workflows.update', $workflow) }}" method="POST">
            @method('PUT')
            @include('workflows.partials.form')
        </form>
    </div>
</div>
@endsection