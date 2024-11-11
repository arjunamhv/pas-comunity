<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Event Detail
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <!-- Flex container for image and map side by side -->
                    <div class="lg:flex lg:gap-6 mb-6">
                        <!-- Image Section (70%) -->
                        <div class="w-full lg:w-7/12 mb-6 lg:mb-0">
                            <label class="font-semibold text-gray-700">Image:</label>
                            @if ($event->image)
                                <img src="{{ asset('storage/' . $event->image) }}" alt="Event Image"
                                     class="w-full h-64 object-cover rounded-md mt-2">
                            @else
                                <p class="text-gray-400">No Image</p>
                            @endif
                        </div>

                        <!-- Map Section (30%) -->
                        <div class="w-full lg:w-5/12">
                            <label class="font-semibold text-gray-700">Map Location:</label>
                            <div id="map" class="w-full h-64 mt-2 rounded-md"></div>

                            <!-- Location Text Below Map -->
                            <div class="mt-2 text-gray-600">
                                <label class="font-semibold text-gray-700">Location:</label>
                                <p>{{ $event->location ?? 'No Location' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Event Title -->
                    <h1 class="text-2xl font-bold mb-4">{{ $event->title }}</h1>

                    <!-- Event Details -->
                    <div class="mb-4">
                        <label class="font-semibold text-gray-700">Description:</label>
                        <p class="text-gray-600">{{ $event->description }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="font-semibold text-gray-700">Date:</label>
                        <p class="text-gray-600">{{ $event->event_date->format('Y-m-d') }}</p>
                    </div>

                    <div class="mb-4">
                        <label class="font-semibold text-gray-700">Start Time:</label>
                        <p class="text-gray-600">{{ $event->start_time }}</p>
                    </div>

                    <!-- Back Button -->
                    <div class="mt-6">
                        <a href="{{ route('events') }}"
                           class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-all duration-200">Back to Events</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>

<!-- Leaflet JS and CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<script>
    // Check if latitude and longitude are available before initializing map
    @if ($event->latitude && $event->longitude)
        // Initialize the map
        var map = L.map('map').setView([{{ $event->latitude }}, {{ $event->longitude }}], 13);

        // Load and display the map using OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Add a marker at the event's coordinates
        L.marker([{{ $event->latitude }}, {{ $event->longitude }}]).addTo(map)
            .bindPopup("<b>{{ $event->title }}</b><br>{{ $event->location ?? 'Location not available' }}")
            .openPopup();
    @else
        // Display a fallback message if coordinates are not available
        console.error('Event location is not available.');
    @endif
</script>
