@extends('layouts.app')

@section('content')
    <h1>{{ $post->title }}</h1>
    <p>by {{ $post->user->name }}</p>
    <p>{{ $post->content }}</p>

    @if ($post->image)
        <img src="{{ asset('storage/' . $post->image) }}" width="300">
    @endif

    <a href="{{ route('posts.edit', $post) }}">Edit</a>
    <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
    <a href="{{ route('posts.index') }}">Back to All Posts</a>
@endsection