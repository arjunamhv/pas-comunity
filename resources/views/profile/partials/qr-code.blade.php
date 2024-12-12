<div class="text-center">
    <!-- QR Code -->
    <div onclick="showModal()" class="cursor-pointer">
        {!! QrCode::size(200)->generate(url('/user/' . $user->id)) !!}
    </div>
</div>

<!-- Modal -->
<div id="qrModal" class="fixed inset-0 bg-white bg-opacity-95 items-center justify-center hidden z-50" onclick="closeModal()">
    <div class="bg-white p-4 rounded-lg shadow-lg" onclick="event.stopPropagation()">
        <!-- Fullscreen QR Code -->
        <div class="text-center">
            {!! QrCode::size(400)->generate(url('/user/' . $user->id)) !!}
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
    function showModal() {
        const modal = document.getElementById('qrModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        const modal = document.getElementById('qrModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>
