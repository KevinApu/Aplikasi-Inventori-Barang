<x-sidebar-layout>
<div class="max-w-2xl mx-auto mt-12 p-8 bg-gradient-to-br from-white via-gray-100 to-gray-200 shadow-2xl rounded-2xl border border-gray-300 backdrop-blur-lg animate-fade-in">
    <h2 class="text-3xl font-extrabold text-gray-900 text-center mb-6 tracking-wide animate-slide-in">
        🚀 Laporkan Barang Rusak
    </h2>

    <form action="{{ route('input_barang_rusak.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Mobile Barcode Scanner -->
        <div class="block items-center relative" x-data="barcodeScannerApp()" x-init="window.innerWidth >= 1024 ? initScanner() : initCameraScanner()">
            <div class="flex flex-col items-center laptop:hidden">
                <div id="reader" class="w-full max-w-sm border-2 border-gray-300 rounded-xl shadow-lg p-2 bg-white"></div>
            </div>
            <div class="flex items-center justify-center space-x-4 mobile:hidden tablet:hidden" title="Tombol Scanner">
                <button
                    @click.prevent="toggleScanner"
                    :class="scannerActive ? 'bg-green-500 shadow-lg scale-105' : 'bg-orange-500'"
                    class="relative inline-flex items-center justify-center w-16 h-9 rounded-full transition-all duration-300 focus:outline-none shadow-md hover:scale-105 hover:shadow-xl">

                    <span
                        :class="scannerActive ? 'translate-x-8 bg-white' : 'translate-x-2 bg-gray-200'"
                        class="absolute left-0 w-6 h-6 rounded-full transform transition-transform duration-300 shadow-md flex items-center justify-center">

                        <!-- Ikon Scanner -->
                        <template x-if="scannerActive">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="w-4 h-4 text-gray-800">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 7v-1a2 2 0 0 1 2 -2h2" />
                                <path d="M5 12l14 0" />
                            </svg>
                        </template>

                        <template x-if="!scannerActive">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                 stroke-linejoin="round" class="w-4 h-4 text-gray-800">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 7v-1c0 -.552 .224 -1.052 .586 -1.414" />
                                <path d="M5 11h1v2h-1z" />
                            </svg>
                        </template>
                    </span>
                    <span class="sr-only" x-text="scannerActive ? 'Matikan Scanner' : 'Aktifkan Scanner'"></span>
                </button>
            </div>

            <label class="block font-semibold text-gray-800 mt-4">🔍 Barcode</label>
            <input
                type="text"
                id="barcode"
                name="barcode"
                x-model="barcode"
                class="w-full mt-2 px-4 py-3 border-2 rounded-lg shadow-md bg-white focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 hover:scale-[1.02]"
                placeholder="Scan atau masukkan barcode"
                required>
        </div>

        <div>
            <label class="block font-semibold text-gray-800">📦 Jumlah yang Rusak</label>
            <input
                type="number"
                name="jumlah_rusak"
                id="jumlah-rusak"
                min="1"
                class="w-full mt-2 px-4 py-3 border-2 rounded-lg shadow-md bg-white focus:ring-red-500 focus:border-red-500 transition-all duration-300 hover:scale-[1.02]"
                placeholder="Masukkan jumlah barang yang rusak"
                required>
        </div>

        <button
            type="submit"
            class="w-full px-4 py-3 bg-red-600 text-white font-semibold rounded-lg shadow-xl hover:bg-red-700 hover:scale-105 transition-all duration-300">
            🚨 Laporkan Kerusakan
        </button>
    </form>
</div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js" integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function barcodeScannerApp() {
            return {
                barcode: '',
                scannerActive: false,
                scannerActive: JSON.parse(localStorage.getItem('scannerActive')) || false,
                captureBarcodeListener: null,
                isProcessing: false,


                initScanner() {
                    // Ambil status scanner dari Local Storage, jika ada
                    const savedStatus = JSON.parse(localStorage.getItem('scannerActive'));
                    this.scannerActive = savedStatus || false; // Set scannerActive berdasarkan status tersimpan

                    if (this.scannerActive) {
                        this.activateScanner(); // Aktifkan scanner jika sebelumnya aktif
                    }
                },

                toggleScanner() {
                    if (this.scannerActive) {
                        this.deactivateScanner();
                    } else {
                        this.activateScanner();
                    }
                    location.reload();
                },

                activateScanner() {
                    this.scannerActive = true;
                    this.barcode = '';
                    this.captureBarcodeListener = (event) => this.captureBarcode(event);
                    window.addEventListener('keydown', this.captureBarcodeListener);
                    localStorage.setItem('scannerActive', JSON.stringify(this.scannerActive));
                },

                captureBarcode(event) {
                    if (this.scannerActive === false) return;
                    if (event.key === 'Enter') {
                        console.log("Barcode Captured: ", this.barcode);
                        document.getElementById('barcode').value = this.barcode; // Memasukkan barcode ke input field   
                    } else {
                        this.barcode += event.key;
                    }
                },

                // Fungsi untuk menonaktifkan scanner
                deactivateScanner() {
                    this.scannerActive = false;
                    if (this.captureBarcodeListener) {
                        window.removeEventListener('keydown', this.captureBarcodeListener); // Hapus event listener
                        this.captureBarcodeListener = null;
                    }
                    localStorage.setItem('scannerActive', JSON.stringify(this.scannerActive));
                },


                initCameraScanner() {
                    let qrboxSize;

                    if (window.innerWidth < 640) { // Mobile
                        qrboxSize = {
                            width: 200,
                            height: 100
                        };
                    } else if (window.innerWidth < 1024) { // Tablet
                        qrboxSize = {
                            width: 300,
                            height: 120
                        };
                    } else {
                        return; // Jangan jalankan jika di laptop
                    }

                    // Pastikan ID `reader` tidak tersembunyi
                    document.getElementById("reader").classList.remove("hidden");

                    const html5QrcodeScanner = new Html5QrcodeScanner("reader", {
                        fps: 30,
                        qrbox: qrboxSize,
                        supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA] // Pakai kamera saja
                    });

                    html5QrcodeScanner.render((decodedText) => {
                        if (this.isProcessing || decodedText.trim() === '') return;

                        this.isProcessing = true;
                        this.barcode = decodedText; // Masukkan hasil scan ke input barcode
                        document.getElementById("barcode").value = decodedText; // Tampilkan di input

                        setTimeout(() => {
                            this.isProcessing = false;
                        }, 3000);
                    });
                }
            }
        }
    </script>
</x-sidebar-layout>