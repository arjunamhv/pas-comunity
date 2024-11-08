<x-admin-layout>
    <div class="p-6">
        <!-- User Details -->
        <h2 class="text-2xl font-semibold mb-4">User Details</h2>

        <!-- Photo -->
        @if ($user->foto)
            <div class="mb-4">
                <img src="{{ asset('storage/' . $user->foto) }}" alt="User Photo" class="w-32 h-32 rounded-full">
            </div>
        @endif

        <!-- Name -->
        <div class="mb-4">
            <strong>Name:</strong> {{ $user->name }}
        </div>

        <!-- Email -->
        <div class="mb-4">
            <strong>Email:</strong> {{ $user->email }}
        </div>

        <!-- Telepon -->
        <div class="mb-4">
            <strong>Telepon:</strong> {{ $user->telepon }}
        </div>

        <!-- Tempat Lahir -->
        <div class="mb-4">
            <strong>Tempat Lahir:</strong> {{ $user->tempat_lahir }}
        </div>

        <!-- Tanggal Lahir -->
        <div class="mb-4">
            <strong>Tanggal Lahir:</strong> {{ $user->tanggal_lahir }}
        </div>

        <!-- Alamat -->
        <div class="mb-4">
            <strong>Alamat:</strong> {{ $user->detail_alamat }}
        </div>

        <!-- Kode Pos -->
        <div class="mb-4">
            <strong>Kode Pos:</strong> {{ $user->kode_pos }}
        </div>

        <!-- Provinsi -->
        <div class="mb-4">
            <strong>Provinsi:</strong> {{ $user->provinsi->name }}
        </div>

        <!-- Kota -->
        <div class="mb-4">
            <strong>Kota:</strong> {{ $user->kota->name }}
        </div>

        <!-- Kecamatan -->
        <div class="mb-4">
            <strong>Kecamatan:</strong> {{ $user->kecamatan->name }}
        </div>

        <!-- Kelurahan -->
        <div class="mb-4">
            <strong>Kelurahan:</strong> {{ $user->kelurahan->name }}
        </div>

        <!-- Is Admin -->
        <div class="mb-4">
            <strong>Admin:</strong> {{ $user->is_admin ? 'Yes' : 'No' }}
        </div>

        <!-- Back Button -->
        <div class="mt-6">
            <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                Back to Users List
            </a>
        </div>

    </div>
</x-admin-layout>
