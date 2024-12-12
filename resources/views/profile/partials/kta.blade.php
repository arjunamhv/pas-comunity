<!-- ID Card Container -->
<div class="id-card flex flex-col items-center p-4 w-[322px] h-[190px] bg-white border border-gray-300 rounded-lg shadow-md"
    id="idCard"
    style="background-image: url('{{ asset('img/id_card_bg.png') }}'); background-size: cover; background-position: center;">
    <div class="flex w-full h-full">
        <!-- Left Section (Photo) -->
        <div class="flex flex-col items-center justify-center" style="width: 96px;">
            <div style="width: 80px; height: 120px; overflow: hidden; border-radius: 8px;">
                <img src="{{ $user->foto ? env('MINIO_ENDPOINT') . '/pas-comunity/' . $user->foto : asset('img/id_card_foto.png') }}" alt="User Photo" id="photo"
                    style="width: 80px; height: 120px; object-fit: cover;">
            </div>
        </div>

        <!-- Right Section (Details and Logo) -->
        <div class="flex flex-col" style="width: 224px; padding-left: 8px;">
            <!-- Logo at the Top Right -->
            <div class="flex justify-end" style="padding-right: 4px; margin-bottom: 32px;">
                <img src="{{ asset('logo.png') }}" alt="Logo" style="width: 55px; height: 55px;">
            </div>
            <div>
                <!-- Card Number -->
                <div style="font-size: 14px; font-weight: bold; letter-spacing: 0.05em; font-family: 'OCR-A', monospace;">
                    <p>{{ $formattedId }}</p>
                </div>
                <!-- Name -->
                <div style="font-size: 13px; font-weight: 600;">
                    <p>{{ $user->name }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Download Button -->
<button id="downloadButton" onclick="downloadIdCard()"
    style="margin-top: 16px; padding: 8px 16px; background-color: #2D3748; border: none; border-radius: 4px; font-size: 10px; font-weight: 600; color: #FFF; text-transform: uppercase; letter-spacing: 0.1em; cursor: pointer; transition: background-color 0.15s ease-in-out;"
    onmouseover="this.style.backgroundColor='#4A5568'" onmouseout="this.style.backgroundColor='#2D3748'">
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

<style>
    @font-face {
        font-family: 'OCR-A';
        src: url('/font/OCR-a___.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }
</style>
