<x-admin-layout>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <div class="p-6">
        <h2 class="text-2xl font-semibold text-gray-700">Edit User</h2>

        <form id="update-form" action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data"
            class="mt-6">
            @csrf
            @method('PUT')

            <!-- Image Preview and File Input -->
            <div class="flex items-center gap-6 mb-4">
                <div class="flex-shrink-0">
                    <img id="preview-image"
                        src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('img/id_card_foto.png') }}"
                        class="w-32 h-48 object-cover border rounded-md" alt="Photo Preview">
                </div>
                <div>
                    <x-input-label for="foto" :value="__('Photo')" />
                    <input id="foto" name="foto" type="file" class="mt-1 block w-full" accept="image/*">
                    <x-input-error class="mt-2" :messages="$errors->get('foto')" />
                </div>
            </div>

            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name', $user->name)"
                    required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                    required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Phone -->
            <div class="mb-4">
                <x-input-label for="telepon" :value="__('Phone')" />
                <x-text-input id="telepon" name="telepon" type="number" class="mt-1 block w-full" :value="old('telepon', $user->telepon)"
                    required />
                <x-input-error :messages="$errors->get('telepon')" class="mt-2" />
            </div>

            <!-- City of Birth -->
            <div class="mb-4">
                <x-input-label for="kota_tempat_lahir_id" :value="__('Kota Tempat Lahir')" />
                <select id="kota_tempat_lahir_id" name="kota_tempat_lahir_id"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required>
                    <!-- Placeholder for previously selected city (will be filled with AJAX if applicable) -->
                    @if (old('kota_tempat_lahir_id', $user->kota_tempat_lahir_id))
                        <option value="{{ old('kota_tempat_lahir_id', $user->kota_tempat_lahir_id) }}" selected>
                            Loading city...
                        </option>
                    @else
                        <option value="" disabled>Select city...</option>
                    @endif
                </select>
                <x-input-error :messages="$errors->get('kota_tempat_lahir_id')" class="mt-2" />
            </div>

            <!-- Birth Date -->
            <div class="mb-4">
                <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir"
                    :value="old('tanggal_lahir', $user->tanggal_lahir->format('Y-m-d'))" required />
                <x-input-error :messages="$errors->get('tanggal_lahir')" class="mt-2" />
            </div>

            <!-- Province -->
            <div class="mb-4">
                <x-input-label for="province_id" :value="__('Province')" />
                <select id="province_id" name="province_id"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required>
                    <option value="" disabled>Select province...</option>
                    <option value="{{ old('province_id', $user->province_id) }}" selected>
                        {{ old('province_id', $user->province_id) ? 'Previously selected province' : '' }}</option>
                </select>
                <x-input-error :messages="$errors->get('province_id')" class="mt-2" />
            </div>

            <!-- City -->
            <div class="mb-4">
                <x-input-label for="regency_id" :value="__('City')" />
                <select id="regency_id" name="regency_id"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required>
                    <option value="" disabled>Select city...</option>
                    <option value="{{ old('regency_id', $user->regency_id) }}" selected>
                        {{ old('regency_id', $user->regency_id) ? 'Previously selected city' : '' }}</option>
                </select>
                <x-input-error :messages="$errors->get('regency_id')" class="mt-2" />
            </div>

            <!-- District -->
            <div class="mb-4">
                <x-input-label for="district_id" :value="__('District')" />
                <select id="district_id" name="district_id"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required>
                    <option value="" disabled>Select district...</option>
                    <option value="{{ old('district_id', $user->district_id) }}" selected>
                        {{ old('district_id', $user->district_id) ? 'Previously selected district' : '' }}</option>
                </select>
                <x-input-error :messages="$errors->get('district_id')" class="mt-2" />
            </div>

            <!-- Village -->
            <div class="mb-4">
                <x-input-label for="village_id" :value="__('Village')" />
                <select id="village_id" name="village_id"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required>
                    <option value="" disabled>Select village...</option>
                    <option value="{{ old('village_id', $user->village_id) }}" selected>
                        {{ old('village_id', $user->village_id) ? 'Previously selected village' : '' }}</option>
                </select>
                <x-input-error :messages="$errors->get('village_id')" class="mt-2" />
            </div>

            <!-- Address Details -->
            <div class="mb-4">
                <x-input-label for="detail_alamat" :value="__('Address Details')" />
                <textarea id="detail_alamat" name="detail_alamat" class="mt-1 block w-full" required>{{ old('detail_alamat', $user->detail_alamat) }}</textarea>
                <x-input-error class="mt-2" :messages="$errors->get('detail_alamat')" />
            </div>

            <!-- Admin Status -->
            <div class="mb-4">
                <x-input-label for="is_admin" :value="__('Admin Status')" />
                <select id="is_admin" name="is_admin"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    required>
                    <option value="0" {{ old('is_admin', $user->is_admin) == 0 ? 'selected' : '' }}>User</option>
                    <option value="1" {{ old('is_admin', $user->is_admin) == 1 ? 'selected' : '' }}>Admin
                    </option>
                </select>
                <x-input-error :messages="$errors->get('is_admin')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end mt-6">
                <button type="button" onclick="confirmUpdate()"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Update
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>


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

<!-- Modal Structure -->
<div id="cropperModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 items-center justify-center hidden">
    <div class="bg-white p-4 rounded-lg w-full max-w-md">
        <h2 class="text-lg font-medium text-gray-900 mb-4">Crop your photo</h2>
        <div class="flex justify-center">
            <img id="modal-image" class="max-w-full max-h-96">
        </div>
        <div class="mt-4 flex justify-end space-x-2">
            <button id="cancel-crop"
                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">Cancel</button>
            <button id="confirm-crop"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Crop
                & Save</button>
        </div>
    </div>
</div>

<!-- Cropper.js CSS and JS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

<script>
    let cropper;
    const fileInput = document.getElementById('foto');
    const previewImage = document.getElementById('preview-image');
    const modalImage = document.getElementById('modal-image');
    const cropperModal = document.getElementById('cropperModal');
    const cancelCropButton = document.getElementById('cancel-crop');
    const confirmCropButton = document.getElementById('confirm-crop');

    fileInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                modalImage.src = e.target.result;
                modalImage.onload = () => {
                    if (cropper) cropper.destroy();
                    cropper = new Cropper(modalImage, {
                        aspectRatio: 2 / 3,
                        viewMode: 1
                    });
                };
                cropperModal.classList.remove('hidden');
                cropperModal.classList.add('flex');
            };
            reader.readAsDataURL(file);
        }
    });

    cancelCropButton.addEventListener('click', function() {
        cropperModal.classList.add('hidden');
        cropperModal.classList.remove('flex');
        fileInput.value = '';
        if (cropper) cropper.destroy();
    });

    confirmCropButton.addEventListener('click', function() {
        if (cropper) {
            cropper.getCroppedCanvas({
                width: 240,
                height: 360
            }).toBlob(blob => {
                const croppedFile = new File([blob], 'cropped_image.jpg', {
                    type: 'image/jpeg'
                });
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(croppedFile);
                fileInput.files = dataTransfer.files;

                const croppedUrl = URL.createObjectURL(croppedFile);
                previewImage.src = croppedUrl;

                cropperModal.classList.add('hidden');
                cropperModal.classList.remove('flex');
                cropper.destroy();
            });
        }
    });
</script>

<script>
    $(document).ready(function() {
        var oldProvinceId = "{{ old('province_id', $user->provinsi_id ?? '') }}";
        var oldRegencyId = "{{ old('regency_id', $user->kota_id ?? '') }}";
        var oldDistrictId = "{{ old('district_id', $user->kecamatan_id ?? '') }}";
        var oldVillageId = "{{ old('village_id', $user->kelurahan_id ?? '') }}";

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

        // Preload Previously Selected City
        var oldCityId = "{{ old('kota_tempat_lahir_id', $user->kota_tempat_lahir_id) }}";
        if (oldCityId) {
            $.ajax({
                url: '{{ route('get.kota.by.id') }}',
                type: 'GET',
                data: {
                    id: oldCityId
                },
                dataType: 'json',
                success: function(data) {
                    var option = new Option(data.name, data.id, true, true);
                    $('#kota_tempat_lahir_id').append(option).trigger('change');
                }
            });
        }

        // Mengisi dropdown provinsi dan memilih yang lama jika ada
        $.ajax({
            url: '{{ route('provinsi.get') }}',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#province_id').empty().append(
                    '<option value="" disabled>Select province...</option>');
                $('#regency_id').empty().append(
                    '<option value="" disabled>Select city...</option>');
                $('#district_id').empty().append(
                    '<option value="" disabled>Select district...</option>');
                $('#village_id').empty().append(
                    '<option value="" disabled>Select village...</option>');

                $.each(data, function(index, item) {
                    $('#province_id').append('<option value="' + item.id + '">' + item
                        .name + '</option>');
                });

                if (oldProvinceId) {
                    $('#province_id').val(oldProvinceId).trigger('change');
                }
            }
        });

        // Menangani perubahan provinsi dan memilih regency yang lama jika ada
        $('#province_id').on('change', function() {
            var provinsiId = $(this).val();
            $('#regency_id').empty().append('<option value="" disabled>Select city...</option>');
            $('#district_id').empty().append('<option value="" disabled>Select district...</option>');
            $('#village_id').empty().append('<option value="" disabled>Select village...</option>');

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

                    if (oldRegencyId) {
                        $('#regency_id').val(oldRegencyId).trigger('change');
                    }
                }
            });
        });

        // Menangani perubahan kota dan memilih district yang lama jika ada
        $('#regency_id').on('change', function() {
            var kotaId = $(this).val();
            $('#district_id').empty().append('<option value="" disabled>Select district...</option>');
            $('#village_id').empty().append('<option value="" disabled>Select village...</option>');

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

                    if (oldDistrictId) {
                        $('#district_id').val(oldDistrictId).trigger('change');
                    }
                }
            });
        });

        // Menangani perubahan district dan memilih village yang lama jika ada
        $('#district_id').on('change', function() {
            var kecamatanId = $(this).val();
            $('#village_id').empty().append('<option value="" disabled>Select village...</option>');

            $.ajax({
                url: '{{ route('kelurahan.get') }}',
                type: 'GET',
                data: {
                    district_id: kecamatanId
                },
                dataType: 'json',
                success: function(data) {
                    $.each(data, function(index, item) {
                        $('#village_id').append('<option value="' + item.id + '">' +
                            item.name + '</option>');
                    });

                    if (oldVillageId) {
                        $('#village_id').val(oldVillageId).trigger('change');
                    }
                }
            });
        });
    });
</script>

<script>
    const originalValues = {
        tanggal_lahir: "{{ \Carbon\Carbon::parse($user->tanggal_lahir)->format('Y-m-d') }}",
        province_id: String("{{ $user->provinsi_id }}"),
        regency_id: String("{{ $user->kota_id }}"),
        district_id: String("{{ $user->kecamatan_id }}"),
        village_id: String("{{ $user->kelurahan_id }}"),
    };

    function confirmUpdate() {
        let isChanged = false;
        const fieldsToCheck = ['tanggal_lahir', 'province_id', 'regency_id', 'district_id', 'village_id'];

        fieldsToCheck.forEach(field => {
            const element = document.getElementById(field);

            let newValue = element ? element.value : null;
            if (field === 'tanggal_lahir' && newValue) {
                newValue = newValue.split(' ')[0];
            }

            if (newValue && newValue !== originalValues[field]) {
                isChanged = true;
            }
        });

        if (isChanged) {
            Swal.fire({
                title: 'Peringatan!',
                text: 'Perubahan pada tanggal lahir, provinsi, kota, kecamatan, atau kelurahan akan mengubah ID pengguna dan dapat menghilangkan relasi pengguna. Apakah Anda ingin melanjutkan?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, saya mengerti',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Konfirmasi Akhir',
                        text: 'Apakah Anda yakin ingin melakukan perubahan ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, saya yakin',
                        cancelButtonText: 'Tidak'
                    }).then((finalResult) => {
                        if (finalResult.isConfirmed) {
                            document.getElementById('update-form').submit();
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
            });
        } else {
            document.getElementById('update-form').submit();
        }

    }
</script>
