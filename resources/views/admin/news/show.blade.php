<x-admin-layout>
    <div class="p-6">
        <h2 class="text-2xl font-semibold text-gray-800">{{ $news->title }}</h2>
        <p class="text-gray-600 mt-2">{{ $news->created_at->format('F j, Y') }}</p>

        <!-- Display News Image -->
        <div class="mt-4">
            @if ($news->image)
                <img src="{{ env('MINIO_ENDPOINT') . '/pas-comunity/' . $news->image }}" alt="News Image" class="w-full h-auto rounded-md">
            @else
                <span class="text-gray-400">No Image Available</span>
            @endif
        </div>

        <!-- Display Content -->
        <div class="mt-6">
            <div class="text-gray-700 mt-2">{!! $news->content !!}</div>
        </div>


        <!-- Back Button -->
        <div class="mt-6">
            <a href="{{ route('news.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                Back to News List
            </a>
        </div>
    </div>
</x-admin-layout>
