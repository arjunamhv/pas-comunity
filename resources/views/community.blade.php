<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Community') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div class="p-6">
                <h1 class="text-2xl font-semibold text-gray-800 leading-tight mb-2">Find Agus</h1>

                <!-- Search Input -->
                <form action="{{ route('community.index') }}" method="GET" class="mt-4">
                    <div class="flex flex-col md:flex-row items-center">
                        <!-- Dropdown filter -->
                        <select name="filter"
                            class="w-full md:w-1/4 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="name">Name</option>
                            <option value="provinsi">Provinsi</option>
                            <option value="kota">Kota</option>
                            <option value="kecamatan">Kecamatan</option>
                            <option value="kelurahan">Kelurahan</option>
                        </select>

                        <!-- Input search -->
                        <input type="text" name="search" placeholder="Search..."
                            class="w-full md:flex-grow px-4 py-2 mt-2 md:mt-0 md:ml-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">

                        <!-- Submit button -->
                        <button type="submit"
                            class="w-full md:w-auto mt-2 md:mt-0 md:ml-2 inline-flex items-center justify-center px-4 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Search
                        </button>
                    </div>
                </form>

                @if ($searchResults)
                    <div class="overflow-x-auto mt-8">
                        <table class="min-w-full bg-white border-collapse shadow-lg">
                            <thead class="bg-gray-800 text-white rounded-t-lg">
                                <tr>
                                    <th class="px-4 py-2 text-center">Foto</th>
                                    <th class="px-4 py-2 text-center">Name</th>
                                    <th class="px-4 py-2 text-center">Provinsi</th>
                                    <th class="px-4 py-2 text-center">Kota</th>
                                    <th class="px-4 py-2 text-center">Kecamatan</th>
                                    <th class="px-4 py-2 text-center"></th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @foreach ($searchResults as $agus)
                                    <tr class="hover:bg-gray-100 border-b even:bg-gray-50">
                                        <td class="px-4 py-2 text-center">
                                            <img src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('img/id_card_foto.png') }}" alt="User Photo"
                                                class="w-16 h-16 rounded-full shadow-md border-2 border-gray-300 object-cover">
                                        </td>
                                        <td class="px-4 py-2 text-center">{{ $agus->name }}</td>
                                        <td class="px-4 py-2 text-center">{{ $agus->provinsi->name }}</td>
                                        <td class="px-4 py-2 text-center">{{ $agus->kota->name }}</td>
                                        <td class="px-4 py-2 text-center">{{ $agus->kecamatan->name }}</td>
                                        <td class="px-4 py-2 text-center">
                                            <button type="button"
                                                onclick="window.location.href='{{ url('user/' . $agus->id) }}'"
                                                class="ml-2 inline-flex items-center px-4 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Connect to this Agus
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                @endif
            </div>
        </div>
    </div>

    @if ($nearbyMembers)
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h1 class="text-2xl font-semibold text-gray-800 leading-tight mb-2">Agus Nearby</h1>

                    <div class="overflow-x-auto mt-8">
                        <table class="min-w-full bg-white border-collapse shadow-lg">
                            <thead class="bg-gray-800 text-white rounded-t-lg">
                                <tr>
                                    <th class="px-4 py-2 text-center">Foto</th>
                                    <th class="px-4 py-2 text-center">Name</th>
                                    <th class="px-4 py-2 text-center">Provinsi</th>
                                    <th class="px-4 py-2 text-center">Kota</th>
                                    <th class="px-4 py-2 text-center">Kecamatan</th>
                                    <th class="px-4 py-2 text-center"></th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @foreach ($nearbyMembers as $agus)
                                    <tr class="hover:bg-gray-100 border-b even:bg-gray-50">
                                        <td class="px-4 py-2 text-center">
                                            <img src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('img/id_card_foto.png') }}" alt="User Photo"
                                                class="w-16 h-16 rounded-full shadow-md border-2 border-gray-300 object-cover">
                                        </td>
                                        <td class="px-4 py-2 text-center">{{ $agus->name }}</td>
                                        <td class="px-4 py-2 text-center">{{ $agus->provinsi->name }}</td>
                                        <td class="px-4 py-2 text-center">{{ $agus->kota->name }}</td>
                                        <td class="px-4 py-2 text-center">{{ $agus->kecamatan->name }}</td>
                                        <td class="px-4 py-2 text-center">
                                            <button type="button"
                                                onclick="window.location.href='{{ url('user/' . $agus->id) }}'"
                                                class="ml-2 inline-flex items-center px-4 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Connect to this Agus
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
    @endif

    @if ($newMembers->isNotEmpty())
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h1 class="text-2xl font-semibold text-gray-800 leading-tight mb-2">Currently Joined Agus</h1>

                    <div class="overflow-x-auto mt-8">
                        <table class="min-w-full bg-white border-collapse shadow-lg">
                            <thead class="bg-gray-800 text-white rounded-t-lg">
                                <tr>
                                    <th class="px-4 py-2 text-center">Foto</th>
                                    <th class="px-4 py-2 text-center">Name</th>
                                    <th class="px-4 py-2 text-center">Provinsi</th>
                                    <th class="px-4 py-2 text-center">Kota</th>
                                    <th class="px-4 py-2 text-center">Kecamatan</th>
                                    <th class="px-4 py-2 text-center"></th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700">
                                @foreach ($newMembers as $agus)
                                    <tr class="hover:bg-gray-100 border-b even:bg-gray-50">
                                        <td class="px-4 py-2 text-center">
                                            <img src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('img/id_card_foto.png') }}" alt="User Photo"
                                                class="w-16 h-16 rounded-full shadow-md border-2 border-gray-300 object-cover">
                                        </td>
                                        <td class="px-4 py-2 text-center">{{ $agus->name }}</td>
                                        <td class="px-4 py-2 text-center">{{ $agus->provinsi->name }}</td>
                                        <td class="px-4 py-2 text-center">{{ $agus->kota->name }}</td>
                                        <td class="px-4 py-2 text-center">{{ $agus->kecamatan->name }}</td>
                                        <td class="px-4 py-2 text-center">
                                            <button type="button"
                                                onclick="window.location.href='{{ url('user/' . $agus->id) }}'"
                                                class="ml-2 inline-flex items-center px-4 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Connect to this Agus
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @else
    @endif
    <script>
        document.querySelector('form').addEventListener('submit', function(event) {
            event.preventDefault();

            const query = document.querySelector('input[name="search"]').value.trim();

            if (query) {
                fetch(`{{ route('community.index') }}?search=${encodeURIComponent(query)}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).catch(error => {
                    console.error('Error:', error);
                });
            }
        });
    </script>
</x-app-layout>
