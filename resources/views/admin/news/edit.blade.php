<x-admin-layout>
    <div class="p-6">
        <h2 class="text-2xl font-semibold text-gray-700">Edit News</h2>

        <form action="{{ route('news.update', $news->id) }}" method="POST" enctype="multipart/form-data" class="mt-6">
            @csrf
            @method('PATCH')

            <!-- Title -->
            <div class="mb-4">
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $news->title)"
                    required />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <!-- Image -->
            <div class="mb-4">
                <x-input-label for="image" :value="__('Image')" />

                <!-- Show Current Image -->
                @if ($news->image)
                    <div class="mb-2">
                        <img src="{{ Storage::url($news->image) }}" alt="Current Image" class="w-32 h-32 object-cover">
                    </div>
                @endif

                <x-text-input id="image" class="block mt-1 w-full" type="file" name="image" />
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>

            <!-- Content with Trix Editor -->
            <div class="mb-4">
                <x-input-label for="content" :value="__('Content')" />
                <input id="content" type="hidden" name="content" value="{{ old('content', $news->content) }}">
                <trix-editor input="content" class="trix-content"></trix-editor>
                <x-input-error :messages="$errors->get('content')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <x-primary-button>
                    {{ __('Update') }}
                </x-primary-button>
            </div>
        </form>
    </div>
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
