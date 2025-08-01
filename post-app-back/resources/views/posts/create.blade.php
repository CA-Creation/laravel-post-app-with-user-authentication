@extends('layouts.app')

@section('content')
    <h1>Create Post</h1>
    <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf
        <label>Title:</label>
        <input type="text" name="title" value="{{ old('title') }}" required>

        <label>Content:</label>
        <textarea name="content" required>{{ old('content') }}</textarea>

        <label>Image:</label>
        <input type="file" name="image">

        <button type="submit">Publish</button>
    </form>
@endsection