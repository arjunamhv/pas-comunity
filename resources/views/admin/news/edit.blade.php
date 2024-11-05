<x-admin-layout>
    <h2 class="text-2xl font-semibold text-gray-700">Edit News</h2>

    <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data" class="mt-6">
        @csrf
        @method('PATCH')

        <!-- Title -->
        <div class="mb-4">
            <label for="title" class="block text-gray-700">Title</label>
            <input type="text" name="title" id="title"
                class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                required value="{{ old('title', $news->title) }}">
            @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Image -->
        <div class="mb-4">
            <label for="image" class="block text-gray-700">Image</label>

            <!-- Show Current Image -->
            @if($news->image)
                <div class="mb-2">
                    <img src="{{ Storage::url($news->image) }}" alt="Current Image" class="w-32 h-32 object-cover">
                </div>
            @endif

            <input type="file" name="image" id="image"
                class="w-full mt-2 px-4 py-2 border border-gray-300 rounded-md focus:outline-none">
            @error('image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Content with Trix Editor -->
        <div class="mb-4">
            <label for="content" class="block text-gray-700">Content</label>
            <input id="content" type="hidden" name="content" value="{{ old('content', $news->content) }}">
            <trix-editor input="content" class="trix-content"></trix-editor>
            @error('content')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                Update
            </button>
        </div>
    </form>
</x-admin-layout>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Find the file tools button group and remove it
        const fileToolsButtonGroup = document.querySelector('.trix-button-group--file-tools');
        if (fileToolsButtonGroup) {
            fileToolsButtonGroup.remove();
        }
    });
</script>
