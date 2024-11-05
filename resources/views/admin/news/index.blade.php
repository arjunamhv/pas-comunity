<x-admin-layout>
    <!-- Search Form -->
    <form method="GET" action="{{ route('news.index') }}" class="mb-4">
        <div class="flex items-center">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search news..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                Search
            </button>
        </div>
    </form>

    <div class="overflow-x-auto">
        <div class="min-w-full bg-white border border-gray-200 shadow-md rounded-lg">
            <table class="min-w-full table-auto border-collapse border border-gray-300">
                <thead class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                    <tr>
                        <th class="py-3 px-6 text-left w-1/12">ID</th>
                        <th class="py-3 px-6 text-left w-6/12">Title</th>
                        <th class="py-3 px-6 text-left w-6/12">Content</th>
                        <th class="py-3 px-6 text-left w-2/12">Image</th>
                        <th class="py-3 px-6 text-left w-3/12">Action</th>
                    </tr>
                </thead>
            </table>

            <!-- Wrapper for the scrollable tbody -->
            <div class="max-h-80 overflow-y-auto">
                <table class="min-w-full table-auto border-collapse border-t border-gray-300">
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($news as $item)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 w-1/12">{{ $item->id }}</td>
                                <td class="py-3 px-6 w-6/12">{{ $item->title }}</td>
                                <td class="py-3 px-6 w-6/12">{{ Str::limit(strip_tags($item->content), 50) }}</td>
                                <td class="py-3 px-6 w-2/12">
                                    @if ($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="News Image"
                                            class="w-24 h-24 object-cover rounded-md">
                                    @else
                                        <span class="text-gray-400">No Image</span>
                                    @endif
                                </td>
                                <td class="py-3 px-6 w-3/12 flex space-x-2">
                                    <a href="{{ route('news.show', $item->id) }}"
                                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                                        title="View">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('news.edit', $item->id) }}"
                                        class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600"
                                        title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <button type="button"
                                        onclick="confirmDelete({{ $item->id }})"
                                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600"
                                        title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>

                                    <!-- Delete form (hidden) -->
                                    <form id="delete-form-{{ $item->id }}" action="{{ route('news.destroy', $item->id) }}" method="POST" class="hidden">
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
        {{ $news->appends(['search' => request('search')])->links('pagination::tailwind') }}
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
@if(session('success'))
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
