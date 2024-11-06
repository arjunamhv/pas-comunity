<x-admin-layout>
    <!-- Search Form -->
    <form method="GET" action="{{ route('events.index') }}" class="mb-4">
        <div class="flex items-center">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search events..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                Search
            </button>
        </div>
    </form>

    <div class="overflow-x-auto">
        <div class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
            <div class="overflow-y-auto max-h-80">
                <table class="min-w-full table-auto border-collapse border border-gray-300">
                    <thead class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal sticky top-0 z-10">
                        <tr>
                            <th class="py-3 px-6 text-left w-1/12">ID</th>
                            <th class="py-3 px-6 text-left w-4/12">Title</th>
                            <th class="py-3 px-6 text-left w-4/12">Description</th>
                            <th class="py-3 px-6 text-left w-2/12">Date</th>
                            <th class="py-3 px-6 text-left w-2/12">Start Time</th>
                            <th class="py-3 px-6 text-left w-3/12">Location</th>
                            <th class="py-3 px-6 text-left w-3/12">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($events as $event)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 w-1/12">{{ $event->id }}</td>
                                <td class="py-3 px-6 w-4/12">{{ $event->title }}</td>
                                <td class="py-3 px-6 w-4/12">{{ Str::limit(strip_tags($event->description), 50) }}</td>
                                <td class="py-3 px-6 w-2/12">{{ $event->event_date->format('Y-m-d') }}</td>
                                <td class="py-3 px-6 w-2/12">{{ $event->start_time }}</td>
                                <td class="py-3 px-6 w-3/12">{{ $event->location ?? 'No Location' }}</td>
                                <td class="py-3 px-6 w-3/12 flex space-x-2">
                                    <a href="{{ route('events.show', $event->id) }}"
                                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                                        title="View">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('events.edit', $event->id) }}"
                                        class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600"
                                        title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <button type="button" onclick="confirmDelete({{ $event->id }})"
                                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600"
                                        title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>

                                    <!-- Delete form (hidden) -->
                                    <form id="delete-form-{{ $event->id }}"
                                        action="{{ route('events.destroy', $event->id) }}" method="POST"
                                        class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $events->appends(['search' => request('search')])->links('pagination::tailwind') }}
    </div>
</x-admin-layout>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }
</script>
@if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
            timer: 1500,
            timerProgressBar: true,
            showConfirmButton: false,
        });
    </script>
@endif
