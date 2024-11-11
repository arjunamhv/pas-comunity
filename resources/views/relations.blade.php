<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Relations') }}
        </h2>
    </x-slot>

    <x-relation-modal id="addRelationModal" title="Connect to Agus" action="{{ route('relations.store') }}" />

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">

        <!-- Connect to Agus Section -->
        <div class="bg-white shadow-xl sm:rounded-lg p-6 mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Connect to Agus</h1>

            <!-- Button to open modal -->
            <div class="flex justify-center items-center mt-4">
                <button
                    class="inline-flex items-center px-6 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-md text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    onclick="openModal('addRelationModal')">
                    Connect to Agus
                </button>
            </div>
        </div>

        <!-- Pending Sent Relations Section -->
        @if ($sentRelationsPending->isNotEmpty())
            <div class="bg-white shadow-xl sm:rounded-lg p-6 mb-6">
                <h2 class="text-xl mt-8 font-semibold text-gray-800">Pending Sent Relations</h2>

                <div class="overflow-x-auto mt-4">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="py-3 px-6 text-left font-medium">Related To</th>
                                <th class="py-3 px-6 text-left font-medium">Relation Type</th>
                                <th class="py-3 px-6 text-left font-medium">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sentRelationsPending as $relation)
                                <tr class="text-gray-700 hover:bg-gray-50">
                                    <td class="py-3 px-6 border-b">{{ $relation->userB->name }}</td>
                                    <td class="py-3 px-6 border-b">{{ $relation->Type->name }}</td>
                                    <td class="py-3 px-6 border-b">
                                        <form id="form-delete-{{ $relation->id }}" method="POST"
                                            action="{{ route('relations.destroy', $relation->id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <button onclick="confirmDelete({{ $relation->id }})"
                                            class="px-4 py-2 bg-red-700 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">
                                            Cancel
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Pending Received Relations Section -->
        <div class="bg-white shadow-xl sm:rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Pending Received Relations</h2>

            @if ($receivedRelationsPending->isEmpty())
                <p class="mt-4 text-gray-600">You have no pending received relations.</p>
            @else
                <p class="mt-4 text-gray-600">You have {{ $receivedRelationsPending->count() }} pending relation(s).</p>

                <div class="overflow-x-auto mt-4">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="py-3 px-6 text-left font-medium">Related To</th>
                                <th class="py-3 px-6 text-left font-medium">Relation Type</th>
                                <th class="py-3 px-6 text-left font-medium">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($receivedRelationsPending as $relation)
                                <tr class="text-gray-700 hover:bg-gray-50">
                                    <td class="py-3 px-6 border-b">{{ $relation->UserA->name }}</td>
                                    <td class="py-3 px-6 border-b">{{ $relation->Type->name }}</td>
                                    <td class="py-3 px-6 border-b flex space-x-2">
                                        <!-- Accept Button -->
                                        <button
                                            onclick="document.getElementById('form-update-{{ $relation->id }}').submit()"
                                            class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-600">
                                            Accept
                                        </button>

                                        <!-- Reject Button -->
                                        <button onclick="confirmDelete({{ $relation->id }})"
                                            class="px-4 py-2 bg-red-700 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">
                                            Reject
                                        </button>

                                        <!-- Form for Accepting the Relationship -->
                                        <form id="form-update-{{ $relation->id }}" method="POST"
                                            action="{{ route('relations.update', $relation->id) }}" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="accepted">
                                        </form>

                                        <!-- Form for Rejecting the Relationship -->
                                        <form id="form-delete-{{ $relation->id }}" method="POST"
                                            action="{{ route('relations.destroy', $relation->id) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Accepted Relations Section -->
        <div class="bg-white shadow-xl sm:rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800">Accepted Relations</h2>

            @if ($relationsAccepted->isEmpty())
                <p class="mt-4 text-gray-600">You have no relations yet.</p>
            @else
                <div class="overflow-x-auto mt-4">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-200 text-gray-700">
                            <tr>
                                <th class="py-2 px-4 border-b text-left">Related To</th>
                                <th class="py-2 px-4 border-b text-left">Relation Type</th>
                                <th class="py-2 px-4 border-b text-left">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($relationsAccepted as $relation)
                                <tr class="text-gray-700">
                                    <td class="py-2 px-4 border-b">
                                        {{ $relation->userA->id === Auth::user()->id ? $relation->userB->name : $relation->userA->name }}
                                    </td>
                                    <td class="py-2 px-4 border-b">{{ $relation->Type->name }}</td>
                                    <td class="py-2 px-4 border-b">
                                        <button onclick="confirmDelete({{ $relation->id }})"
                                            class="px-4 py-2 bg-red-700 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">
                                            Remove
                                        </button>
                                        <form id="form-delete-{{ $relation->id }}"
                                            action="{{ route('relations.destroy', $relation->id) }}" method="POST"
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
            @endif
        </div>

    </div>

    <!-- SweetAlert2 Library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.getElementById(id).classList.add('flex');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.getElementById(id).classList.remove('flex');
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this action!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-delete-' + id).submit();
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
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'error',
                text: "{{ session('error') }}",
                timer: 1500,
                timerProgressBar: true,
                showConfirmButton: false,
            });
        </script>
    @endif
</x-app-layout>
