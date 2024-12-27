@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-semibold text-gray-800">Manage Blog Posts</h1>
        
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
                Create New Blog Post
            </a>
        </div>

        
    </div>

    
    @if (session('success'))
        <div class="alert alert-success bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
            {{ session('success') }}
        </div>
    @endif

    <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden">
        <thead>
            <tr class="bg-gray-200">
                <th class="py-3 px-6 text-left text-sm font-medium text-gray-700">Blog Title</th>
                <th class="py-3 px-6 text-center text-sm font-medium text-gray-700">Blog Content</th>
                <th class="py-3 px-6 text-center text-sm font-medium text-gray-700">Blog Image</th>
                <th class="py-3 px-6 text-center text-sm font-medium text-gray-700">Edit</th>
                <th class="py-3 px-6 text-center text-sm font-medium text-gray-700">Delete</th>
            </tr>
        </thead>
        <tbody>
            @foreach($blogs as $blog)
                <tr class="border-t hover:bg-gray-50">
                    <td class="py-3 px-6 text-sm text-gray-800">{{ $blog->title }}</td>
                    <td class="py-3 px-6 text-sm text-gray-600">{!! $blog->content !!}</td>
                    <td class="py-3 px-6 text-center">
                        @if($blog->image)
                            <img src="{{ asset('storage/' . $blog->image) }}" alt="Blog Image" class="w-100 h-48 object-cover rounded-md">
                        @else
                            <img src="{{ asset('images/default.jpg') }}" alt="Default Image" class="w-100 h-48 object-cover rounded-md">
                        @endif
                    </td>
                    <td class="py-3 px-6 text-center">
                        <a href="{{ route('admin.edit', $blog->id) }}" class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">
                            Edit
                        </a>
                    </td>
                    <td class="py-3 px-6 text-center">
                        <a href="{{ route('admin.delete', $blog->id) }}" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600"
                           onclick="return confirm('Are you sure you want to delete this blog post?')">
                            Delete
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
