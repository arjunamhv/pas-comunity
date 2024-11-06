<x-admin-layout>
    <div class="p-6">
        <h2 class="text-2xl font-semibold text-gray-700">Create News</h2>

        <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data" class="mt-6">
            @csrf

            <!-- Title -->
            <div class="mb-4">
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')"
                    required autofocus />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <!-- Image -->
            <div class="mb-4">
                <x-input-label for="image" :value="__('Image')" />
                <x-text-input id="image" class="block mt-1 w-full" type="file" name="image" />
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>

            <!-- Content with Trix Editor -->
            <div class="mb-4">
                <x-input-label for="content" :value="__('Content')" />
                <input id="content" type="hidden" name="content" value="{{ old('content') }}">
                <trix-editor input="content" class="trix-content"></trix-editor>
                <x-input-error :messages="$errors->get('content')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <x-primary-button>
                    {{ __('Submit') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-admin-layout>

<!-- JavaScript to remove unnecessary file tools button group in Trix Editor -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Find the file tools button group and remove it
        const fileToolsButtonGroup = document.querySelector('.trix-button-group--file-tools');
        if (fileToolsButtonGroup) {
            fileToolsButtonGroup.remove();
        }
    });
</script>
