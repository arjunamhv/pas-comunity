<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            News
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div id="news-container" class="p-6 sm:px-20 bg-white border-b border-gray-200 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Initial News Items -->
                    @foreach ($news->take(10) as $item)
                        <div class="bg-gray-100 p-6 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="News Image" class="w-full h-48 object-cover rounded-md">
                            </div>
                            <a href="{{ route('news.detail', $item->id) }}" class="text-xl font-semibold text-blue-600 hover:underline">
                                {{ $item->title }}
                            </a>
                            <p class="mt-4 text-gray-600">
                                {{ Str::limit(strip_tags($item->content), 100) }}
                            </p>
                            <a href="{{ route('news.detail', $item->id) }}" class="mt-4 inline-block text-blue-500 underline hover:text-blue-700">
                                Read More
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Show More Button -->
                <div class="text-center my-6">
                    <button id="load-more-btn" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-50">
                        Show More
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Load More Functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let skip = 10; // Start loading from the 11th item
            const loadMoreBtn = document.getElementById('load-more-btn');

            loadMoreBtn.addEventListener('click', () => {
                // Show loading state
                loadMoreBtn.innerText = 'Loading...';
                loadMoreBtn.disabled = true;

                fetch(`{{ route('news.load-more') }}?skip=${skip}`)
                    .then(response => response.json())
                    .then(data => {
                        const newsContainer = document.getElementById('news-container');
                        data.news.forEach(item => {
                            // Create a card for each new item
                            const newsCard = document.createElement('div');
                            newsCard.classList.add('bg-gray-100', 'p-6', 'rounded-lg', 'shadow-md', 'hover:shadow-lg', 'transition-shadow');
                            newsCard.innerHTML = `
                                <div class="mb-4">
                                    <img src="{{ asset('storage/') }}/${item.image}" alt="News Image" class="w-full h-48 object-cover rounded-md">
                                </div>
                                <a href="{{ url('news') }}/${item.id}" class="text-xl font-semibold text-blue-600 hover:underline">
                                    ${item.title}
                                </a>
                                <p class="mt-4 text-gray-600">
                                    ${item.content.slice(0, 100)}...
                                </p>
                                <a href="{{ url('news') }}/${item.id}" class="mt-4 inline-block text-blue-500 underline hover:text-blue-700">
                                    Read More
                                </a>
                            `;
                            newsContainer.appendChild(newsCard);
                        });

                        // Update the skip value for the next batch
                        skip += 10;

                        // Reset button state
                        loadMoreBtn.innerText = 'Show More';
                        loadMoreBtn.disabled = false;

                        // Hide button if no more news items are available
                        if (data.news.length < 10) {
                            loadMoreBtn.style.display = 'none';
                        }
                    })
                    .catch(error => {
                        console.error('Error loading more news:', error);
                        loadMoreBtn.innerText = 'Show More';
                        loadMoreBtn.disabled = false;
                    });
            });
        });
    </script>
</x-app-layout>
