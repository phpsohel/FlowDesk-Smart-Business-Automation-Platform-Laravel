@extends('layouts.app')

@section('content')

<div class="p-8 bg-gray-50 min-h-screen">

<div class="flex justify-between items-center mb-8">

<div>

<h1 class="text-3xl font-bold">

Categories

</h1>

<p class="text-gray-500">

Manage all categories

</p>

</div>

<a
href="{{ route('categories.create') }}"
class="bg-indigo-600 text-white px-5 py-3 rounded-xl">

+ Add Category

</a>

</div>

<div class="bg-white rounded-2xl shadow border p-6">

<div class="flex justify-between mb-6">

<h2 class="text-xl font-bold">

Category List

</h2>

<form>

<input
type="search"
name="search"
value="{{ request('search') }}"
placeholder="Search..."
class="border rounded-xl px-4 py-2">

</form>

</div>

<table class="w-full">

<thead>

<tr class="border-b">

<th class="py-3 text-left">Name</th>

<th class="py-3 text-left">Products</th>

<th class="py-3 text-left">Status</th>

<th class="py-3 text-right">Action</th>

</tr>

</thead>

<tbody>

@foreach($categories as $category)

<tr class="border-b">

<td class="py-4">

{{ $category->name }}

</td>

<td>

{{ $category->products_count }}

</td>

<td>

@if($category->status=='Active')

<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">

Active

</span>

@else

<span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">

Inactive

</span>

@endif

</td>

<td class="text-right">

<a
href="{{ route('categories.show',$category) }}"
class="text-indigo-600">

View

</a>

<a
href="{{ route('categories.edit',$category) }}"
class="ml-3 text-gray-600">

Edit

</a>

<form
action="{{ route('categories.destroy',$category) }}"
method="POST"
class="inline">

@csrf

@method('DELETE')

<button
onclick="return confirm('Delete category?')"
class="ml-3 text-red-600">

Delete

</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

<div class="mt-6">

{{ $categories->links() }}

</div>

</div>

</div>

@endsection