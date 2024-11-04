<!-- ID Card Container -->
<div class="id-card flex flex-col items-center p-4 w-[322px] h-[190px] bg-white border border-gray-300 rounded-lg shadow-md"
    id="idCard"
    style="background-image: url('{{ asset('img/id_card_bg.png') }}'); background-size: cover; background-position: center;">
    <div class="flex w-full h-full">
        <!-- Left Section (Photo) -->
        <div class="flex flex-col items-center justify-center w-[30%]">
            <div class="w-[80px] h-[120px] overflow-hidden rounded-md">
                <img src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('img/id_card_foto.png') }}" alt="User Photo" id="photo"
                    class="w-full h-full object-cover">
            </div>
        </div>

        <!-- Right Section (Details and Logo) -->
        <div class="flex flex-col w-[70%] pl-2">
            <!-- Logo at the Top Right -->
            <div class="flex justify-end pr-1 mb-8">
                <img src="{{ asset('logo.png') }}" alt="Logo" class="h-[55px] w-[55px]">
            </div>
            <div>
                <!-- Card Number -->
                <div class="text-base font-bold tracking-wide">
                    <p>{{ $formattedId }}</p>
                </div>
                <!-- Name -->
                <div class="text-sm font-semibold">
                    <p>{{ $user->name }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Download Button -->
<button id="downloadButton" onclick="downloadIdCard()"
    class="mt-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
    Download ID Card
</button>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    function downloadIdCard() {
        const idCard = document.getElementById('idCard');

        html2canvas(idCard, {
            scale: 2,
            useCORS: true
        }).then((canvas) => {
            const link = document.createElement('a');
            link.href = canvas.toDataURL('image/png');
            link.download = 'ID_Card.png';
            link.click();
        });
    }
</script>
