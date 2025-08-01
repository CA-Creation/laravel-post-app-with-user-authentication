<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Search Form --}}
            <form action="{{ route('dashboard') }}" method="GET" class="mb-6 flex flex-col md:flex-row gap-4">
                <input
                    type="text"
                    name="search"
                    placeholder="Search posts by title..."
                    value="{{ request('search') }}"
                    class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded w-full md:w-1/2"
                >
                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
                >
                    Search
                </button>
            </form>

            {{-- Posts List --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200">Your Posts</h2>
                    <button
                        onclick="document.getElementById('createPostModal').classList.remove('hidden')"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded"
                    >
                        Create New Post
                    </button>
                </div>

                @if ($posts->isEmpty())
                    <p class="text-gray-600 dark:text-gray-400">No posts found{{ request('search') ? ' for your search.' : '.' }}</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($posts as $post)
                            <div class="bg-white dark:bg-gray-700 rounded shadow p-4 flex flex-col">
                                @if ($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover rounded mb-4">
                                @endif
                                <p class="mt-2 text-gray-700 text-opacity-50 dark:text-gray-300 dark:text-opacity-50">Title</p>
                                <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-gray-100">{{ $post->title }}</h3>

                                <p class="mt-2 text-gray-700 text-opacity-50 dark:text-gray-300 dark:text-opacity-50">Content</p>
                                <p class="mt-1 text-gray-700 dark:text-gray-300 flex-grow">{{ Str::limit($post->content, 150) }}</p>

                                <div class="mt-4 flex space-x-4">
                                    <a href="{{ route('posts.edit', $post) }}" class="text-yellow-500 dark:text-yellow-400 hover:underline">Edit</a>

                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post? This action cannot be undone.');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center text-sm font-medium text-red-600 hover:text-red-800 hover:underline focus:outline-none focus:ring-2 focus:ring-red-400 rounded">
                                            🗑️ Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Create Post Modal --}}
    <div id="createPostModal" class="fixed inset-0 bg-gray-900 bg-opacity-75 flex justify-center items-center hidden z-50">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg w-full max-w-md">
            <h2 class="text-lg font-bold mb-4 text-gray-800 dark:text-gray-100">Create New Post</h2>

            <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block text-gray-700 dark:text-gray-300 mb-1">Title:</label>
                    <input id="title" type="text" name="title" class="w-full border border-gray-300 p-2 rounded" required value="{{ old('title') }}">
                    @error('title')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="content" class="block text-gray-700 dark:text-gray-300 mb-1">Content:</label>
                    <textarea id="content" name="content" class="w-full border border-gray-300 p-2 rounded" required rows="5">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-gray-700 dark:text-gray-300 mb-1">Image:</label>
                    <input id="image" type="file" name="image" class="w-full">
                    @error('image')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="button" onclick="document.getElementById('createPostModal').classList.add('hidden')" class="mr-2 bg-gray-500 hover:bg-gray-600 text-white py-1 px-4 rounded">Cancel</button>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-1 px-4 rounded">Save</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
