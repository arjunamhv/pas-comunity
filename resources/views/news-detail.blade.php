<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            News Details
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- News Title -->
                <h2 class="text-3xl font-semibold text-gray-800">{{ $news->title }}</h2>

                <!-- Date -->
                <p class="text-gray-600 mt-2">{{ $news->created_at->format('F j, Y') }}</p>

                <!-- Display News Image -->
                <div class="mt-4">
                    @if ($news->image)
                        <img src="{{ asset('storage/' . $news->image) }}" alt="News Image"
                             class="w-full rounded-md">
                    @else
                        <span class="text-gray-400">No Image Available</span>
                    @endif
                </div>

                <!-- Display Content -->
                <div class="mt-6 text-gray-700 leading-relaxed">
                    {!! $news->content !!}
                </div>

                <!-- Back Button -->
                <div class="mt-6">
                    <a href="{{ route('news') }}"
                       class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                        Back to News List
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
