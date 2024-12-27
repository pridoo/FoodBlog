@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Manage Blog Posts</h1>

        <a href="{{ route('admin.create') }}" class="btn btn-primary mb-3">Create New Blog Post</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($blogs as $blog)
                    <tr>
                        <td>{{ $blog->title }}</td>
                        <td>
                            <a href="{{ route('admin.edit', $blog->id) }}" class="btn btn-warning">Edit</a>
                            <a href="{{ route('admin.delete', $blog->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this blog post?')">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
