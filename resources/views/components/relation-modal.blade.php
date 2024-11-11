<div id="{{ $id }}" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
        <h3 class="text-lg font-semibold mb-4">{{ $title }}</h3>

        <!-- Choose between Scan QR Code or Input ID -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Choose an option</label>
            <div class="flex gap-4 mt-2">
                <!-- Option for Scan QR Code -->
                <button type="button" id="scanQRBtn"
                    class="w-full inline-flex items-center justify-center text-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Scan QR Code
                </button>

                <!-- Option for Input ID -->
                <button type="button" id="inputIDBtn"
                    class="w-full inline-flex items-center justify-center text-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Input ID
                </button>
            </div>
        </div>

        <!-- QR Code Scan Section -->
        <div id="qrCodeSection" class="hidden mb-4">
            <label class="block text-sm font-medium text-gray-700">Scan the QR Code</label>
            <div id="reader" class="mt-2 w-full h-64 border-2 border-gray-300 rounded-md"></div>
            <input type="hidden" name="qr_code" id="result" />
        </div>

        <!-- Input ID Section -->
        <div id="inputIDSection" class="hidden mb-4">
            <label for="input_id" class="block text-sm font-medium text-gray-700">Enter ID</label>
            <div class="flex gap-2 mt-2">
                <!-- Input Field -->
                <input type="text" name="input_id" id="input_id"
                    class="p-2 border border-gray-300 rounded-md w-full" placeholder="Enter ID here" />

                <!-- Submit Button -->
                <button type="button"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                    onclick="redirectToUser()">
                    {{ __('Submit') }}
                </button>
            </div>
        </div>

        <div class="flex justify-end gap-4">
            <button type="button"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150"
                onclick="closeModal('{{ $id }}')">
                Cancel
            </button>
        </div>
    </div>
</div>

<style>
    #reader__scan_region img {
        display: block;
        margin: 0 auto;
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Check if the decoded text is a URL
        try {
            const url = new URL(decodedText);

            // Redirect to the URL if it's valid
            window.location.href = url.href;
        } catch (e) {
            // If it's not a URL, proceed with the existing AJAX request
            $('#result').val(decodedText);
            html5QrcodeScanner.clear().then(_ => {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    url: "{{ route('relations.create') }}",
                    type: 'POST',
                    data: {
                        _method: "POST",
                        _token: CSRF_TOKEN,
                        qr_code: decodedText
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            alert('Successfully processed');
                        } else {
                            alert('Failed to process');
                        }
                    }
                });
            }).catch(error => {
                alert('Something went wrong while clearing scanner');
            });
        }
    }

    function onScanFailure(error) {
        // Handle scan failure
        console.warn(`Scan error: ${error}`);
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", {
            fps: 10,
            qrbox: {
                width: 250,
                height: 250
            }
        },
        false
    );
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
<script>
    // Show and hide sections based on button clicks
    document.getElementById('scanQRBtn').addEventListener('click', function() {
        document.getElementById('qrCodeSection').classList.remove('hidden');
        document.getElementById('inputIDSection').classList.add('hidden');
    });

    document.getElementById('inputIDBtn').addEventListener('click', function() {
        document.getElementById('inputIDSection').classList.remove('hidden');
        document.getElementById('qrCodeSection').classList.add('hidden');
    });

    function redirectToUser() {
        const inputId = document.getElementById('input_id').value;
        if (inputId) {
            window.location.href = `/user/${inputId}`;
        } else {
            alert("Please enter a valid ID.");
        }
    }
</script>
