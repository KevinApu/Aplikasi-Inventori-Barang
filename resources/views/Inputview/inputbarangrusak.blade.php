<x-sidebar-layout>
    <div class="max-w-2xl mx-auto mt-12 p-6 bg-gradient-to-br from-white via-gray-100 to-gray-200 shadow-2xl rounded-2xl border border-gray-300 backdrop-blur-lg animate-fade-in">
        <h2 class="text-[22px] laptop:text-2xl font-bold text-gray-900 text-center mb-6">
            Laporkan Barang Rusak
        </h2>

        @php
        $check_barcode = session('check_barcode');
        $barcode = session('barcode');
        @endphp


        @if(isset($check_barcode) && isset($barcode))
        <form action="{{ route('input_barang_rusak.store', $check_barcode->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @endif

            @if(!isset($check_barcode) && !isset($barcode))
            <div class="block items-center relative" x-data="barcodeScannerApp()" x-init="window.innerWidth >= 1025 ? initScanner() : initCameraScanner()">
                <div class="flex flex-col items-center mobile:block laptop:hidden">
                    <div id="reader" class="w-full max-w-sm border-2 border-gray-300 rounded-xl shadow-lg p-2 bg-white"></div>
                </div>
                <div class="flex items-center justify-center space-x-4 mobile:hidden tablet:hidden" title="Tombol Scanner">
                    <button
                        @click.prevent="toggleScanner"
                        :class="scannerActive ? 'bg-green-500 shadow-lg scale-105' : 'bg-orange-500'"
                        class="relative inline-flex items-center justify-center w-14 h-8 rounded-full transition-all duration-300 focus:outline-none shadow-md hover:scale-105 hover:shadow-xl">
                        <span
                            :class="scannerActive ? 'translate-x-7 bg-white' : 'translate-x-1 bg-gray-200'"
                            class="absolute left-0 w-5 h-5 rounded-full transform transition-transform duration-300 shadow-md flex items-center justify-center">
                            <template x-if="scannerActive">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="w-4 h-4 text-gray-800">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M4 7v-1a2 2 0 0 1 2 -2h2" />
                                    <path d="M5 12l14 0" />
                                </svg>
                            </template>
                            <template x-if="!scannerActive">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
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

                <form action="{{ route('input_barang_rusak.check_barcode') }}" method="POST">
                    @csrf
                    <label class="block font-semibold text-gray-800 mt-4 text-[16px] laptop:text-[18px]">🔍 Barcode</label>
                    <input
                        type="text"
                        id="barcode"
                        name="barcode"
                        x-model="barcode"
                        class="w-full mt-2 px-4 py-3 border-2 rounded-lg shadow-md bg-white focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 hover:scale-[1.02] text-[15px] laptop:text-[16px]"
                        placeholder="Scan atau masukkan barcode"
                        required>
                    <button
                        type="submit"
                        class="w-full px-4 py-3 bg-red-600 text-white font-semibold rounded-lg shadow-xl hover:bg-red-700 hover:scale-105 transition-all duration-300 text-[16px] laptop:text-[18px]">
                        Lanjut ke Detail Kerusakan
                    </button>
                </form>
            </div>
            @endif


            @if(isset($check_barcode) && isset($barcode))
            <div class="flex items-center space-x-6 bg-gray-100 p-4 rounded-lg shadow-md">
                <img src="{{ asset('storage/' . $check_barcode->foto) }}"
                    alt="Gambar Barang"
                    class="w-20 h-20 rounded-lg shadow-md">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">{{ $check_barcode->nama_barang ?? 'Barang Tidak Ditemukan' }}</h2>
                    <p class="text-gray-600 text-sm">🔖 Seri: <span class="font-mono">{{ $check_barcode->seri ?? 'Seri Tidak Ditemukan'}}</span></p>
                    <p class="text-gray-600 text-sm">
                        📦 Stok:
                        <span class="font-bold">
                            @if(isset($check_barcode))
                            @if(in_array($check_barcode->satuan, ['roll', 'pack']))
                            {{ $check_barcode->hasil ?? '0' }}
                            @else
                            {{ $check_barcode->jumlah ?? '0' }}
                            @endif
                            @else
                            0
                            @endif
                        </span>
                        {{ $check_barcode->satuan ?? '-' }}
                    </p>
                </div>
            </div>

            @if(($check_barcode->satuan === 'roll' || $check_barcode->satuan === 'pack'))
            <div>
                <label class="block font-semibold text-gray-800 text-[16px] laptop:text-[18px]">📦 Jumlah yang Rusak</label>
                <input
                    type="number"
                    name="jumlah_rusak"
                    id="jumlah-rusak"
                    min="1"
                    max="{{ $check_barcode->hasil }}"
                    oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                    class="w-full mt-2 px-4 py-3 border-2 rounded-lg shadow-md bg-white focus:ring-red-500 focus:border-red-500 transition-all duration-300 hover:scale-[1.02] text-[15px] laptop:text-[16px]"
                    placeholder="Masukkan jumlah barang yang rusak"
                    required>
            </div>
            @else
            <input type="text" class="hidden" name="jumlah_rusak" value="1">
            @endif

            <div>
                <label class="block font-semibold text-gray-800 text-[16px] laptop:text-[18px]">Kondisi Barang</label>
                <textarea
                    name="kondisi"
                    class="w-full mt-2 px-4 py-3 border-2 rounded-lg shadow-md bg-white focus:ring-red-500 focus:border-red-500 transition-all duration-300 hover:scale-[1.02] text-[15px] laptop:text-[16px]"
                    rows="1"
                    placeholder="Kondisi Barang"
                    required></textarea>
            </div>
            <div>
                <label class="block font-semibold text-gray-800 text-[16px] laptop:text-[18px]">Penyebab Kerusakan</label>
                <textarea
                    name="penyebab"
                    class="w-full mt-2 px-4 py-3 border-2 rounded-lg shadow-md bg-white focus:ring-red-500 focus:border-red-500 transition-all duration-300 hover:scale-[1.02] text-[15px] laptop:text-[16px]"
                    rows="1"
                    placeholder="Penyebab Kerusakan"
                    required></textarea>
            </div>
            <div x-data="{ photo: null, isDragging: false }" class="bg-transparent rounded-lg mt-6 ml-2">
                <input type="file" name="foto" @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = e => photo = e.target.result; reader.readAsDataURL(file); }" accept="image/*"
                    class="hidden" x-ref="fileInput">
                <div @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false" @drop.prevent="isDragging = false; const file = $event.dataTransfer.files[0]; if (file) { const reader = new FileReader(); reader.onload = e => photo = e.target.result; reader.readAsDataURL(file); $refs.fileInput.files = $event.dataTransfer.files; }"
                    :class="{'border-indigo-500': isDragging, 'border-gray-300': !isDragging}"
                    class="border-2 border-dashed border-gray-300 rounded-lg p-4 flex flex-col items-center justify-center cursor-pointer"
                    @click="$refs.fileInput.click()">

                    <template x-if="!photo">
                        <div class="flex flex-col items-center">
                            <p class="text-gray-600 text-sm font-medium transition-opacity duration-300 ease-in-out">Drag & drop a photo here or click to select</p>
                            <div class="w-32 h-32 flex items-center justify-center mt-2 animate-bounce">
                                <img src="/img/Animasi Photo.png" alt="Animation" class="w-24 h-24 transition-opacity duration-300 ease-in-out">
                            </div>
                        </div>
                    </template>

                    <img :src="photo" alt="Preview" class="w-40 h-40 rounded-lg shadow-md mx-auto mt-2" x-show="photo">
                </div>
                @error('foto')
                <p class="text-red-500 text-sm mt-1">{{$message}}</p>
                @enderror
            </div>
            <input type="text" name="barcode" class="hidden" value="{{ $barcode }}">
            <button
                type="submit"
                class="w-full px-4 py-3 bg-red-600 text-white font-semibold rounded-lg shadow-xl hover:bg-red-700 hover:scale-105 transition-all duration-300 text-[16px] laptop:text-[18px]">
                🚨 Laporkan Kerusakan
            </button>
        </form>
        @endif
    </div>

    @if (session('success_rusak'))
    <div x-data="{ isOpen: true }" x-init="setTimeout(() => isOpen = false, 2000)">
        <div
            x-show="isOpen"
            @keydown.escape.window="isOpen = false"
            @click.self="isOpen = false"
            tabindex="-1"
            aria-hidden="true"
            class="overflow-y-auto overflow-x-hidden fixed inset-0 z-50 flex justify-center items-center w-full md:inset-0 h-screen bg-black bg-opacity-30"
            x-transition:enter="transition-opacity duration-300 ease-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-300 ease-in"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            <div @click.stop
                class="bg-white rounded-xl shadow-lg p-4 text-center w-48 transition-transform"
                x-transition:enter="transform transition-transform duration-300 ease-out"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transform transition-transform duration-200 ease-in"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95">
                <!-- Icon Success -->
                <div class="bg-green-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-green-500 animate-pulse" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l5 5l10-10" />
                    </svg>
                </div>

                <!-- Pesan -->
                <h1 class="text-base font-semibold text-green-600">Success</h1>
                <p class="text-gray-500 text-xs mb-3 leading-tight">
                    {{ session('success_rusak') }}
                </p>

                <!-- Tombol Continue -->
                <button type="button" @click="isOpen = false"
                    class="bg-green-500 text-white py-1 px-4 rounded-full text-sm hover:bg-green-600 focus:ring focus:ring-green-300 transition">
                    Continue
                </button>
            </div>
        </div>
    </div>
    @endif

    @if(session('error_rusak'))
    <div x-data="{ isOpen: true }">
        <div
            x-show="isOpen"
            @keydown.escape.window="isOpen = false"
            @click.self="isOpen = false"
            tabindex="-1"
            aria-hidden="true"
            class="overflow-y-auto overflow-x-hidden fixed inset-0 z-50 flex justify-center items-center w-full md:inset-0 h-screen bg-black bg-opacity-30"
            x-transition:enter="transition-opacity duration-300 ease-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-300 ease-in"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            <div @click.stop
                class="bg-white rounded-xl shadow-lg p-4 text-center w-48 transition-transform"
                x-transition:enter="transform transition-transform duration-300 ease-out"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transform transition-transform duration-200 ease-in"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95">
                <!-- Icon Error -->
                <div class="bg-red-100 rounded-full w-12 h-12 flex items-center justify-center mx-auto mb-3 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-red-500 animate-pulse" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M18 6l-12 12" />
                        <path d="M6 6l12 12" />
                    </svg>
                </div>

                <!-- Pesan -->
                <h1 class="text-base font-semibold text-red-600">Gagal</h1>
                <p class="text-gray-500 text-xs mb-3 leading-tight">
                    {{ session('error_rusak') }}
                </p>

                <!-- Tombol Continue -->
                <button type="button" @click="isOpen = false"
                    class="bg-red-500 text-white py-1 px-4 rounded-full text-sm hover:bg-red-600 focus:ring focus:ring-red-300 transition">
                    Continue
                </button>
            </div>
        </div>
    </div>
    @endif

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