<x-admin-layout>
    <div class="p-6">
        <!-- Flex container for image and map side by side -->
        <div class="flex gap-4 mb-4">
            <!-- Image Section (70%) -->
            <div class="w-[70%]">
                <label class="font-semibold text-gray-700">Image:</label>
                @if ($event->image)
                    <img src="{{ env('MINIO_ENDPOINT') . '/pas-comunity/' . $event->image }}" alt="Event Image"
                        class="w-full h-64 object-cover rounded-md mt-2">
                @else
                    <p class="text-gray-400">No Image</p>
                @endif
            </div>

            <!-- Map Section (30%) -->
            <div class="w-[30%]">
                <label class="font-semibold text-gray-700">Map Location:</label>
                <div id="map" class="w-full h-64 mt-2 rounded-md"></div>

                <!-- Location Text Below Map -->
                <div class="mt-2 text-gray-600">
                    <label class="font-semibold text-gray-700">Location:</label>
                    <p>{{ $event->location ?? 'No Location' }}</p>
                </div>
            </div>
        </div>
        <!-- Title -->
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

        <div class="mt-6">
            <a href="{{ route('events.index') }}"
                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">Back to Events</a>
        </div>
    </div>

    <!-- Leaflet JS and CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <script>
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
    </script>
</x-admin-layout>
