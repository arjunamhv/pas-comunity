<x-admin-layout>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Edit Event</h1>

        <form method="POST" action="{{ route('events.update', $event->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            <!-- Title -->
            <div>
                <x-input-label for="title" :value="__('Title')" />
                <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title', $event->title)" required autofocus />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
            </div>

            <!-- Description -->
            <div class="mt-4">
                <x-input-label for="description" :value="__('Description')" />
                <textarea id="description" name="description" class="block mt-1 w-full px-3 py-2 border border-gray-300 rounded-md" rows="4" required>{{ old('description', $event->description) }}</textarea>
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>

            <!-- Event Date -->
            <div class="mt-4">
                <x-input-label for="event_date" :value="__('Event Date')" />
                <x-text-input id="event_date" class="block mt-1 w-full" type="date" name="event_date" :value="old('event_date', $event->event_date ? $event->event_date->format('Y-m-d') : '')" required />
                <x-input-error :messages="$errors->get('event_date')" class="mt-2" />
            </div>

            <!-- Start Time -->
            <div class="mt-4">
                <x-input-label for="start_time" :value="__('Start Time')" />
                <x-text-input id="start_time" class="block mt-1 w-full" type="time" name="start_time" :value="old('start_time', $event->start_time ? $event->start_time->format('H:i') : '')" required />
                <x-input-error :messages="$errors->get('start_time')" class="mt-2" />
            </div>

            <!-- Image Upload -->
            <div class="mt-4">
                <x-input-label for="image" :value="__('Event Image')" />

                <!-- Show Current Image -->
                @if($event->image)
                    <div class="mb-2">
                        <img src="{{ Storage::url($event->image) }}" alt="Current Image" class="w-32 h-32 object-cover">
                    </div>
                @endif

                <input type="file" id="image" name="image" class="block mt-1 w-full px-3 py-2 border border-gray-300 rounded-md" />
                <x-input-error :messages="$errors->get('image')" class="mt-2" />
            </div>

            <!-- Map for selecting latitude and longitude -->
            <div class="mt-4">
                <x-input-label :value="__('Event Location')" />
                <div id="map" class="w-full h-64 mt-2 rounded-md border border-gray-300"></div>
                <p class="text-gray-500 text-sm mt-2">Click on the map to set the event location.</p>
            </div>

            <!-- Latitude and Longitude -->
            <div class="grid grid-cols-2 gap-4 mt-4">
                <div>
                    <x-input-label for="latitude" :value="__('Latitude')" />
                    <x-text-input id="latitude" class="block mt-1 w-full" type="text" name="latitude" :value="old('latitude', $event->latitude)" readonly required />
                    <x-input-error :messages="$errors->get('latitude')" class="mt-2" />
                </div>
                <div>
                    <x-input-label for="longitude" :value="__('Longitude')" />
                    <x-text-input id="longitude" class="block mt-1 w-full" type="text" name="longitude" :value="old('longitude', $event->longitude)" readonly required />
                    <x-input-error :messages="$errors->get('longitude')" class="mt-2" />
                </div>
            </div>

            <!-- Location (optional) -->
            <div class="mt-4">
                <x-input-label for="location" :value="__('Location')" />
                <x-text-input id="location" class="block mt-1 w-full" type="text" name="location" :value="old('location', $event->location)" required />
                <x-input-error :messages="$errors->get('location')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <x-primary-button>
                    {{ __('Update Event') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <!-- Leaflet JS and CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <script>
        // Initialize the map
        var map = L.map('map').setView([{{ $event->latitude ?? '-6.1751' }}, {{ $event->longitude ?? '106.8650' }}], 13);

        // Load and display the map using OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Marker for selected location
        var marker = L.marker([{{ $event->latitude ?? '-6.1751' }}, {{ $event->longitude ?? '106.8650' }}]).addTo(map);

        // Event listener for map clicks to set latitude and longitude
        map.on('click', function(e) {
            var lat = e.latlng.lat.toFixed(6);
            var lng = e.latlng.lng.toFixed(6);

            // Update the input fields
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;

            // Update marker location
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker([lat, lng]).addTo(map);
        });
    </script>
</x-admin-layout>
