<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'PAS') }}</title>
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.bunny.net">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen font-sans antialiased">
    <div class="max-w-md w-full bg-white shadow-xl rounded-lg overflow-hidden">
        <div class="flex items-center justify-center p-6 bg-gradient-to-r from-red-500 to-red-600">
            <h1 class="text-2xl font-bold text-white">User Profile</h1>
        </div>
        <div class="p-6">
            <div class="flex justify-center mb-6 mt-4">
                <img src="{{ $user->foto ? env('MINIO_ENDPOINT') . '/pas-comunity/' . $user->foto : asset('img/id_card_foto.png') }}" alt="User Photo"
                    class="w-32 h-32 rounded-full shadow-lg border-4 border-red-500 object-cover">
            </div>
            <h2 class="text-center text-2xl font-semibold text-gray-900 mt-4">{{ $user->name }}</h2>
            <p class="text-center text-gray-500 mt-2 text-lg">{{ $user->kota->name }}</p>
            <div class="border-t-2 border-gray-200 mt-6 mb-6"></div>

            <!-- Connect Button with onclick event -->
            <div class="flex justify-center">
                <button type="button" onclick="window.location.href='{{ route('relations.show', $user->id) }}'"
                    class="px-6 py-3 bg-red-500 text-white font-semibold rounded-full shadow-lg hover:bg-red-600 transition transform hover:-translate-y-0.5 duration-150 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2">
                    Connect to this Agus
                </button>
            </div>
        </div>

        <div class="p-4 bg-gray-50 text-center text-gray-400 text-sm">
            <p>&copy; 2024 Community Connect. All rights reserved.</p>
        </div>
    </div>

    <!-- Include SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (isset($relationshipTypes) && count($relationshipTypes) > 0)
            window.onload = function() {
                Swal.fire({
                    title: 'Select Relationship Type',
                    html: `
                        <form id="relationshipTypeForm" action="{{ route('relations.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="related_user_id" value="{{ $user->id  }}">
                            <div id="dropdownContainer">
                                <label for="relationship_type_id" class="block text-left mb-2">Choose a type:</label>
                                <select name="relationship_type_id" id="relationship_type_id" class="swal2-input" required style="width: 100%; box-sizing: border-box;">
                                    @foreach ($relationshipTypes as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                <p class="text-blue-500 cursor-pointer mt-2" onclick="toggleInputField()">Or create a new type</p>
                            </div>
                            <div id="inputContainer" style="display: none;">
                                <label for="new_type" class="block text-left mt-3 mb-2">New type name:</label>
                                <input type="text" name="new_type" id="new_type" class="swal2-input" placeholder="New type name" required style="width: 80%; box-sizing: border-box;">
                                <p class="text-blue-500 cursor-pointer mt-2" onclick="toggleInputField()">Back to select</p>
                            </div>
                        </form>`,
                    confirmButtonText: 'Submit',
                    focusConfirm: false,
                    preConfirm: () => {
                        document.getElementById('relationshipTypeForm').submit();
                    }
                });
            };

            function toggleInputField() {
                const dropdownContainer = document.getElementById('dropdownContainer');
                const inputContainer = document.getElementById('inputContainer');

                if (dropdownContainer.style.display === 'none') {
                    dropdownContainer.style.display = 'block';
                    inputContainer.style.display = 'none';
                    document.getElementById('relationship_type_id').required = true;
                    document.getElementById('new_type').required = false;
                } else {
                    dropdownContainer.style.display = 'none';
                    inputContainer.style.display = 'block';
                    document.getElementById('relationship_type_id').required = false;
                    document.getElementById('new_type').required = true;
                }
            }
        @endif
    </script>
</body>

</html>
