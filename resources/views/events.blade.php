<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Events
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex flex-wrap gap-6">
                    @foreach ($events as $month => $monthlyEvents)
                        <!-- Monthly Card Container -->
                        <div class="w-64 border border-gray-300 rounded-lg p-4 shadow-lg bg-gradient-to-r from-indigo-100 via-red-100 to-yellow-100 hover:shadow-2xl transition-all duration-300">
                            <!-- Month Title -->
                            <h2 class="text-2xl font-semibold text-blue-600 mb-4 text-center">{{ $month }}</h2>

                            <!-- Events within the month -->
                            <div class="space-y-2">
                                @foreach ($monthlyEvents as $event)
                                    <!-- Event Card -->
                                    <a href="{{ route('events.detail', $event->id) }}" class="flex items-center bg-white border border-gray-200 rounded-lg p-3 shadow-sm hover:shadow-lg transition duration-200 transform hover:scale-105">
                                        <div class="flex-shrink-0">
                                            <p class="text-gray-500 mr-3 text-lg font-bold">{{ $event->event_date->format('d') }}</p>
                                        </div>
                                        <div>
                                            <h3 class="text-md font-semibold text-gray-900">{{ $event->title }}</h3>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
