<x-sidebar-layout>

    @if(session('error'))
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
                    {{ session('error') }}
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


    @if(session('success'))
    <div x-data="{ isOpen: true }" x-init="setTimeout(() => isOpen = false, 3000)">
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
                    {{ session('success') }}
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

    <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <!-- Step Indicator -->
        <div class="flex items-center justify-around mb-8">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 flex items-center justify-center bg-blue-500 text-white rounded-full font-semibold">1</div>
                <span class="text-gray-700 font-medium">Input Barang</span>
            </div>
            <div class="h-px flex-1 bg-gray-300"></div>
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 flex items-center justify-center bg-gray-300 text-gray-700 rounded-full font-semibold">2</div>
                <span class="text-gray-500 font-medium">Kirim Barang</span>
            </div>
        </div>

        <!-- Step 1: Input Barang -->
        <div x-data="formData()">
            <div x-show="step === 1" class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-2">Step 1: Input Barang</h2>

                <template x-for="(item, index) in items" :key="index">
                    <div class="bg-gray-50 border border-gray-300 p-4 rounded-lg shadow-md mb-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-3">Data Barang - <span x-text="index + 1"></span></h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Barang</label>
                                <input type="text" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" x-model="item.nama_barang" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Seri</label>
                                <input type="text" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" x-model="item.seri" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                                <input type="number"
                                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                                    x-model.number="item.jumlah"
                                    min="1"
                                    inputmode="numeric"
                                    pattern="[0-9]*"
                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                    required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Satuan</label>
                                <select x-model="item.satuan" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" @change="updateRasio(index)">
                                    <option value="" selected>Pilih satuan...</option>
                                    <option value="Pcs">Pcs</option>
                                    <option value="Roll">Roll</option>
                                    <option value="Pack">Pack</option>
                                    <option value="Unit">Unit</option>
                                </select>
                            </div>

                            <div x-show="item.showRasio" class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Rasio</label>
                                <input type="number" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" x-model="item.rasio" :placeholder="item.placeholder" :required="item.rasioRequired">
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Lokasi</label>
                                <select x-model="item.lokasi" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" required>
                                    <option value="" selected>Pilih lokasi...</option>
                                    @foreach ($kantorlayanan as $lokasi)
                                    <option value="{{ $lokasi->lokasi }}">{{ $lokasi->pop }} - {{ $lokasi->lokasi }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Catatan (Opsional)</label>
                                <input type="text" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" x-model="item.catatan">
                            </div>
                        </div>

                        <button type="button" @click="removeItem(index)" class="bg-red-500 text-white px-4 py-2 rounded-lg mt-4 hover:bg-red-600 transition" x-show="index > 0">
                            Hapus Data
                        </button>
                    </div>
                </template>

                <div class="flex justify-between items-center mt-4">
                    <button type="button" @click="addItem" class="bg-green-500 hover:bg-green-600 text-white py-2 px-5 rounded-lg shadow-md border border-green-600 transition-transform transform hover:scale-105 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Data
                    </button>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="button" @click="step = 2" :disabled="!isFormValid()" class="bg-blue-500 hover:bg-blue-600 text-white py-3 px-8 text-lg rounded-lg shadow-md border border-blue-700 transition-transform transform hover:scale-105 flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Lanjut ke Pengiriman
                    </button>
                </div>

            </div>


            <!-- Step 2: Kirim Barang -->
            <div x-show="step === 2" class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Step 2: Kirim Barang</h2>

                <form action="{{ route('pengiriman_barang.input.post.superadmin') }}" method="POST">
                    @csrf

                    <template x-for="(item, index) in items" :key="index">
                        <div class="bg-gray-100 p-4 rounded-lg shadow-sm mb-4 border border-gray-200">
                            <input type="hidden" :name="'items[' + index + '][nama_barang]'" :value="item.nama_barang">
                            <input type="hidden" :name="'items[' + index + '][seri]'" :value="item.seri">
                            <input type="hidden" :name="'items[' + index + '][jumlah]'" :value="item.jumlah">
                            <input type="hidden" :name="'items[' + index + '][satuan]'" :value="item.satuan">
                            <input type="hidden" :name="'items[' + index + '][rasio]'" :value="item.rasio">
                            <input type="hidden" :name="'items[' + index + '][lokasi]'" :value="item.lokasi">
                            <input type="hidden" :name="'items[' + index + '][catatan]'" :value="item.catatan">

                            <h3 class="text-lg font-semibold text-gray-700 mb-2">Barang <span x-text="index + 1"></span></h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <p>
                                    <span class="font-medium text-gray-600">Nama Barang:</span>
                                    <span class="text-gray-800 font-semibold" x-text="item.nama_barang"></span>
                                </p>
                                <p>
                                    <span class="font-medium text-gray-600">Seri:</span>
                                    <span class="text-gray-800 font-semibold" x-text="item.seri"></span>
                                </p>
                                <p>
                                    <span class="font-medium text-gray-600">Jumlah:</span>
                                    <span class="text-gray-800 font-semibold" x-text="item.jumlah"></span>
                                </p>
                                <p>
                                    <span class="font-medium text-gray-600">Satuan:</span>
                                    <span class="text-gray-800 font-semibold" x-text="item.satuan"></span>
                                </p>
                                <p x-show="item.rasio">
                                    <span class="font-medium text-gray-600">Rasio:</span>
                                    <span class="text-gray-800 font-semibold" x-text="item.rasio"></span>
                                </p>
                                <p>
                                    <span class="font-medium text-gray-600">Lokasi Tujuan:</span>
                                    <span class="text-gray-800 font-semibold" x-text="item.lokasi"></span>
                                </p>
                                <p x-show="item.catatan">
                                    <span class="font-medium text-gray-600">Catatan:</span>
                                    <span class="text-gray-800 font-semibold" x-text="item.catatan"></span>
                                </p>
                            </div>
                        </div>
                    </template>

                    <div class="flex justify-between mt-6">
                        <button type="button" @click="step = 1"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-5 py-2 rounded-lg shadow-md border border-gray-400 transition-transform transform hover:scale-105 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                            </svg>
                            Kembali
                        </button>

                        <button type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 text-lg rounded-lg shadow-md border border-green-700 transition-transform transform hover:scale-105 flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Kirim Barang
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <script>
        function formData() {
            return {
                step: 1,
                items: [{
                    nama_barang: '',
                    seri: '',
                    jumlah: '',
                    satuan: '',
                    rasio: '',
                    catatan: '',
                    lokasi: '',
                    showRasio: false,
                    placeholder: '',
                    rasioRequired: false
                }],
                addItem() {
                    this.items.push({
                        nama_barang: '',
                        seri: '',
                        jumlah: '',
                        satuan: '',
                        rasio: '',
                        catatan: '',
                        lokasi: '',
                        showRasio: false,
                        placeholder: '',
                        rasioRequired: false
                    });
                },
                removeItem(index) {
                    this.items.splice(index, 1);
                },
                updateRasio(index) {
                    const item = this.items[index];
                    item.showRasio = (item.satuan === 'Roll' || item.satuan === 'Meter' || item.satuan === 'Pack');
                    item.placeholder = item.satuan === 'Roll' ? 'Per Roll berapa meter?' :
                        item.satuan === 'Pack' ? 'Per Pack berapa Pcs?' :
                        item.satuan === 'Meter' ? 'Per Pcs berapa meter?' : '';
                    item.rasioRequired = item.showRasio;
                },
                isFormValid() {
                    return this.items.every(item =>
                        item.nama_barang.trim() &&
                        item.seri.trim() &&
                        item.jumlah.trim() &&
                        item.satuan.trim() &&
                        item.lokasi.trim()
                    );
                }
            }
        }
    </script>

</x-sidebar-layout>