<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 dark:text-gray-300 mb-1">Title:</label>
                        <input id="title" type="text" name="title" value="{{ old('title', $post->title) }}" 
                               class="w-full border border-gray-300 p-2 rounded" required>
                        @error('title')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="content" class="block text-gray-700 dark:text-gray-300 mb-1">Content:</label>
                        <textarea id="content" name="content" rows="6" required
                                  class="w-full border border-gray-300 p-2 rounded">{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    @if ($post->image)
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-300 mb-1">Current Image:</label>
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Current Image" class="w-48 h-auto rounded">
                        </div>
                    @endif

                    <div class="mb-4">
                        <label for="image" class="block text-gray-700 dark:text-gray-300 mb-1">Change Image (optional):</label>
                        <input id="image" type="file" name="image" class="w-full">
                        @error('image')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="confirmCancel()" 
                                class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded">
                            Save
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function confirmCancel() {
            if (confirm("Are you sure you want to cancel editing? Unsaved changes will be lost.")) {
                window.location.href = "{{ route('dashboard') }}";
            }
        }
    </script>
</x-app-layout>
