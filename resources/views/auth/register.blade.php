<x-auth-layout>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Kota Tempat Lahir ID -->
        <div class="mt-4">
            <x-input-label for="kota_tempat_lahir_id" :value="__('Kota Tempat Lahir')" />
            <select id="kota_tempat_lahir_id" name="kota_tempat_lahir_id" class="w-full" required>
                <option value="" disabled>Select city...</option>
                <option value="{{ old('kota_tempat_lahir_id') }}" selected>
                    {{ old('kota_tempat_lahir_id') ? 'Previously selected city' : '' }}</option>
            </select>
            <x-input-error :messages="$errors->get('kota_tempat_lahir_id')" class="mt-2" />
        </div>

        <!-- Tanggal Lahir -->
        <div class="mt-4">
            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
            <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir"
                :value="old('tanggal_lahir')" required />
            <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
        </div>

        <!-- Provinsi -->
        <div class="mt-4">
            <x-input-label for="province_id" :value="__('Provinsi')" />
            <select id="province_id" name="province_id"
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                required>
                <option value="" disabled>Select province...</option>
                <option value="{{ old('province_id') }}" selected>
                    {{ old('province_id') ? 'Previously selected province' : '' }}</option>
            </select>
            <x-input-error :messages="$errors->get('province_id')" class="mt-2" />
        </div>

        <!-- Kota -->
        <div class="mt-4">
            <x-input-label for="regency_id" :value="__('Kota')" />
            <select id="regency_id" name="regency_id"
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                required>
                <option value="" disabled>Select city...</option>
                <option value="{{ old('regency_id') }}" selected>
                    {{ old('regency_id') ? 'Previously selected city' : '' }}</option>
            </select>
            <x-input-error :messages="$errors->get('regency_id')" class="mt-2" />
        </div>

        <!-- Kecamatan -->
        <div class="mt-4">
            <x-input-label for="district_id" :value="__('Kecamatan')" />
            <select id="district_id" name="district_id"
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                required>
                <option value="" disabled>Select district...</option>
                <option value="{{ old('district_id') }}" selected>
                    {{ old('district_id') ? 'Previously selected district' : '' }}</option>
            </select>
            <x-input-error :messages="$errors->get('district_id')" class="mt-2" />
        </div>

        <!-- Kelurahan -->
        <div class="mt-4">
            <x-input-label for="village_id" :value="__('Kelurahan')" />
            <select id="village_id" name="village_id"
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                required>
                <option value="" disabled>Select village...</option>
                <option value="{{ old('village_id') }}" selected>
                    {{ old('village_id') ? 'Previously selected village' : '' }}</option>
            </select>
            <x-input-error :messages="$errors->get('village_id')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
    <style>
        .select2-container {
            width: 100% !important;
        }

        .select2-container .select2-selection--single {
            height: 42px;
            width: 100% !important;
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
            border-color: rgb(209 213 219);
            border-width: 1px;
            border-radius: .375rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 42px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 42px;
        }

        .select2-container--default .select2-selection--single:focus {
            border-color: rgb(99 102 241);
            box-shadow: 0 0 0 1px rgba(99, 102, 241, 0.5);
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#kota_tempat_lahir_id').select2({
                width: '100%',
                placeholder: 'Search for a city...',
                minimumInputLength: 1,
                ajax: {
                    url: '{{ route('kota.lahir.autocomplete') }}',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            query: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
            $.ajax({
                url: '{{ route('provinsi.get') }}',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#province_id').empty().append(
                        '<option value="" disabled selected>Select province...</option>');
                    $('#regency_id').empty().append(
                        '<option value="" disabled selected>Select city...</option>');
                    $('#district_id').empty().append(
                        '<option value="" disabled selected>Select district...</option>');
                    $('#village_id').empty().append(
                        '<option value="" disabled selected>Select village...</option>');
                    $.each(data, function(index, item) {
                        $('#province_id').append('<option value="' + item.id + '">' + item
                            .name + '</option>');
                    });

                }
            });

            $('#province_id').on('change', function() {
                var provinsiId = $(this).val();
                $('#regency_id').empty().append(
                    '<option value="" disabled selected>Select city...</option>');
                $('#district_id').empty().append(
                    '<option value="" disabled selected>Select district...</option>');
                $('#village_id').empty().append(
                    '<option value="" disabled selected>Select village...</option>');

                $.ajax({
                    url: '{{ route('kota.get') }}',
                    type: 'GET',
                    data: {
                        province_id: provinsiId
                    },
                    dataType: 'json',
                    success: function(data) {
                        $.each(data, function(index, item) {
                            $('#regency_id').append('<option value="' + item.id + '">' +
                                item.name + '</option>');
                        });
                    }
                });
            });

            $('#regency_id').on('change', function() {
                var kotaId = $(this).val();
                $('#district_id').empty().append(
                    '<option value="" disabled selected>Select district...</option>');
                $('#village_id').empty().append(
                    '<option value="" disabled selected>Select village...</option>');

                $.ajax({
                    url: '{{ route('kecamatan.get') }}',
                    type: 'GET',
                    data: {
                        regency_id: kotaId
                    },
                    dataType: 'json',
                    success: function(data) {
                        $.each(data, function(index, item) {
                            $('#district_id').append('<option value="' + item.id +
                                '">' + item.name + '</option>');
                        });
                    }
                });
            });

            $('#district_id').on('change', function() {
                var kecamatanId = $(this).val();
                $('#village_id').empty().append(
                    '<option value="" disabled selected>Select village...</option>');

                $.ajax({
                    url: '{{ route('kelurahan.get') }}',
                    type: 'GET',
                    data: {
                        district_id: kecamatanId
                    },
                    dataType: 'json',
                    success: function(data) {
                        $.each(data, function(index, item) {
                            $('#village_id').append('<option value="' + item.id +
                                '">' + item.name + '</option>');
                        });
                    }
                });
            });
        });
    </script>
</x-auth-layout>
