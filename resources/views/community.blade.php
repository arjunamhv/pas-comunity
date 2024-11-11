<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Community') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

            <!-- Search Bar -->
            <div class="p-6">
                <form method="GET" action="{{ route('community.index') }}" class="flex mb-4">
                    <input
                        type="text"
                        name="search"
                        value="{{ request()->search }}"
                        class="border-gray-300 rounded-l-md p-2 w-2/3"
                        placeholder="Search for members like Agus..."
                    />
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-md">
                        Search
                    </button>
                </form>
            </div>

            <!-- Newly Joined Members -->
            <div class="p-6 mt-6">
                <h3 class="text-xl font-semibold text-gray-800">Newly Joined Members</h3>
                <ul class="mt-4">
                    @foreach($newMembers as $member)
                        <li class="py-2 border-b">
                            <strong>{{ $member->name }}</strong> - Joined on {{ $member->created_at->format('d M Y') }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Nearby Members (Assuming there is a location-based search) -->
            <div class="p-6 mt-6">
                <h3 class="text-xl font-semibold text-gray-800">Nearby Members</h3>
                <form method="GET" action="{{ route('community.index') }}" class="flex mb-4">
                    <input
                        type="text"
                        name="location"
                        class="border-gray-300 rounded-l-md p-2 w-2/3"
                        placeholder="Enter your location..."
                    />
                    <button type="submit" name="nearby" value="1" class="bg-blue-500 text-white px-4 py-2 rounded-r-md">
                        Find Nearby
                    </button>
                </form>

                @if(count($nearbyMembers) > 0)
                    <ul class="mt-4">
                        @foreach($nearbyMembers as $member)
                            <li class="py-2 border-b">
                                <strong>{{ $member->name }}</strong> - Located near you
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No nearby members found.</p>
                @endif
            </div>

            <!-- All Members -->
            <div class="p-6 mt-6">
                <h3 class="text-xl font-semibold text-gray-800">All Members</h3>
                <ul class="mt-4">
                    @foreach($members as $member)
                        <li class="py-2 border-b">
                            <strong>{{ $member->name }}</strong> - {{ $member->email }}
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</x-app-layout>
