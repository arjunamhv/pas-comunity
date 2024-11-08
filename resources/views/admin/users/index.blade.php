<x-admin-layout>
    <!-- Search Form -->
    <form method="GET" action="{{ route('users.index') }}" class="mb-4">
        <div class="flex items-center space-x-2">
            <select name="filter"
                class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="name" {{ request('filter') == 'name' ? 'selected' : '' }}>Name</option>
                <option value="provinsi" {{ request('filter') == 'provinsi' ? 'selected' : '' }}>Provinsi</option>
                <option value="kota" {{ request('filter') == 'kota' ? 'selected' : '' }}>Kota</option>
                <option value="kecamatan" {{ request('filter') == 'kecamatan' ? 'selected' : '' }}>Kecamatan</option>
                <option value="kelurahan" {{ request('filter') == 'kelurahan' ? 'selected' : '' }}>Kelurahan</option>
                <option value="admin" {{ request('filter') == 'admin' ? 'selected' : '' }}>Admin Status</option>
            </select>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                Search
            </button>
        </div>
    </form>

    <div class="overflow-x-auto">
        <div class="max-w-full bg-white border border-gray-200 shadow-md rounded-lg">
            <div class="overflow-y-auto max-h-80">
                <table class="min-w-full table-auto border-collapse border border-gray-300">
                    <thead class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal sticky top-0 z-10">
                        <tr>
                            <th class="py-3 px-6 text-left w-1/12">ID</th>
                            <th class="py-3 px-6 text-left w-2/12">Name</th>
                            <th class="py-3 px-6 text-left w-2/12">Kota Tempat Lahir</th>
                            <th class="py-3 px-6 text-left w-2/12">Tanggal Lahir</th>
                            <th class="py-3 px-6 text-left w-1/12">Provinsi</th>
                            <th class="py-3 px-6 text-left w-1/12">Kota</th>
                            <th class="py-3 px-6 text-left w-1/12">Kecamatan</th>
                            <th class="py-3 px-6 text-left w-1/12">Kelurahan</th>
                            <th class="py-3 px-6 text-left w-1/12">Admin Status</th>
                            <th class="py-3 px-6 text-left w-2/12">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        @foreach ($users as $user)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 w-1/12">{{ $user->id }}</td>
                                <td class="py-3 px-6 w-2/12">{{ $user->name }}</td>
                                <td class="py-3 px-6 w-2/12">{{ $user->kotaTempatLahir->name }}</td>
                                <td class="py-3 px-6 w-2/12">{{ $user->tanggal_lahir->format('d-m-Y') }}</td>
                                <td class="py-3 px-6 w-1/12">{{ $user->provinsi->name }}</td>
                                <td class="py-3 px-6 w-1/12">{{ $user->kota->name }}</td>
                                <td class="py-3 px-6 w-1/12">{{ $user->kecamatan->name }}</td>
                                <td class="py-3 px-6 w-1/12">{{ $user->kelurahan->name }}</td>
                                <td class="py-3 px-6 w-1/12">{{ $user->is_admin ? 'Admin' : 'User' }}</td>
                                <td class="py-3 px-6 w-2/12 flex space-x-2">
                                    <a href="{{ route('users.show', $user->id) }}"
                                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                                        title="View">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('users.edit', $user->id) }}"
                                        class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600"
                                        title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <button type="button" onclick="confirmDelete({{ substr($user->id, -9) }})"
                                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600"
                                        title="Delete">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>

                                    <!-- Delete form (hidden) -->
                                    <form id="delete-form-{{ substr($user->id, -9) }}"
                                        action="{{ route('users.destroy', $user->id) }}" method="POST">
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
        {{ $users->appends(['search' => request('search'), 'filter' => request('filter')])->links('pagination::tailwind') }}
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
                } else if (
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire({
                        title: "Cancelled",
                        text: "Your data is safe :)",
                        icon: "error"
                    });
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
