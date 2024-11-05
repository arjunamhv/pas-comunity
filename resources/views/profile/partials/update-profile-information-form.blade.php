<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Image Preview and File Input -->
        <div class="flex items-center gap-6 mt-4">
            <!-- Image Preview -->
            <div class="flex-shrink-0">
                <img id="preview-image"
                    src="{{ $user->foto ? asset('storage' . $user->foto) : asset('img/id_card_foto.png') }}"
                    class="w-32 h-48 object-cover border rounded-md" alt="Photo Preview">
            </div>

            <!-- File Input -->
            <div>
                <x-input-label for="foto" :value="__('Photo')" />
                <input id="foto" name="foto" type="file" class="mt-1 block w-full" accept="image/*">
                <x-input-error class="mt-2" :messages="$errors->get('foto')" />
            </div>
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" disabled />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Telepon -->
        <div>
            <x-input-label for="telepon" :value="__('Phone')" />
            <x-text-input id="telepon" name="telepon" type="number" class="mt-1 block w-full" :value="old('telepon', $user->telepon)" />
            <x-input-error class="mt-2" :messages="$errors->get('telepon')" />
        </div>

        <!-- Kota Tempat Lahir -->
        <div>
            <x-input-label for="kota_tempat_lahir_id" :value="__('Place of Birth City')" />
            <x-text-input id="kota_tempat_lahir_id" name="kota_tempat_lahir_id" type="text" class="mt-1 block w-full"
                :value="old('kota_tempat_lahir_id', $user->kotaTempatLahir->name)" disabled />
            <x-input-error class="mt-2" :messages="$errors->get('kota_tempat_lahir_id')" />
        </div>

        <!-- Tanggal Lahir -->
        <div>
            <x-input-label for="tanggal_lahir" :value="__('Date of Birth')" />
            <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" class="mt-1 block w-full"
                :value="old('tanggal_lahir', $user->tanggal_lahir->format('Y-m-d'))" disabled />
            <x-input-error class="mt-2" :messages="$errors->get('tanggal_lahir')" />
        </div>

        <!-- Provinsi -->
        <div>
            <x-input-label for="provinsi_id" :value="__('Province')" />
            <x-text-input id="provinsi_id" name="provinsi_id" type="text" class="mt-1 block w-full"
                :value="old('provinsi_id', $user->provinsi->name)" disabled />
            <x-input-error class="mt-2" :messages="$errors->get('provinsi_id')" />
        </div>

        <!-- Kota -->
        <div>
            <x-input-label for="kota_id" :value="__('City')" />
            <x-text-input id="kota_id" name="kota_id" type="text" class="mt-1 block w-full" :value="old('kota_id', $user->kota->name)"
                disabled />
            <x-input-error class="mt-2" :messages="$errors->get('kota_id')" />
        </div>

        <!-- Kecamatan -->
        <div>
            <x-input-label for="kecamatan_id" :value="__('Subdistrict')" />
            <x-text-input id="kecamatan_id" name="kecamatan_id" type="text" class="mt-1 block w-full"
                :value="old('kecamatan_id', $user->kecamatan->name)" disabled />
            <x-input-error class="mt-2" :messages="$errors->get('kecamatan_id')" />
        </div>

        <!-- Kelurahan -->
        <div>
            <x-input-label for="kelurahan_id" :value="__('Village')" />
            <x-text-input id="kelurahan_id" name="kelurahan_id" type="text" class="mt-1 block w-full"
                :value="old('kelurahan_id', $user->kelurahan->name)" disabled />
            <x-input-error class="mt-2" :messages="$errors->get('kelurahan_id')" />
        </div>

        <!-- Kode Pos -->
        <div>
            <x-input-label for="kode_pos" :value="__('Postal Code')" />
            <x-text-input id="kode_pos" name="kode_pos" type="text" class="mt-1 block w-full" :value="old('kode_pos', $user->kode_pos)"
                disabled />
            <x-input-error class="mt-2" :messages="$errors->get('kode_pos')" />
        </div>

        <!-- Detail Alamat -->
        <div>
            <x-input-label for="detail_alamat" :value="__('Address Details')" />
            <textarea id="detail_alamat" name="detail_alamat" class="mt-1 block w-full">{{ old('detail_alamat', $user->detail_alamat) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('detail_alamat')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
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
