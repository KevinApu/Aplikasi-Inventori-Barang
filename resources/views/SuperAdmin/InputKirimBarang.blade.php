<x-sidebar-layout>

    @if(session('error'))
    <div x-data="{ isOpen: true }">
        <div
            x-show="isOpen"
            @keydown.escape.window="isOpen = false"
            @click.self="isOpen = false"
            tabindex="-1"
            aria-hidden="true"
            class="overflow-y-auto overflow-x-hidden fixed inset-0 z-50 flex justify-center items-center w-full md:inset-0 h-screen md:h-full bg-black bg-opacity-30"
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
            class="overflow-y-auto overflow-x-hidden fixed inset-0 z-50 flex justify-center items-center w-full md:inset-0 h-screen md:h-full bg-black bg-opacity-30"
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
            <div x-show="step === 1">
                <h2 class="text-xl mobile:text-md font-semibold text-gray-700 mb-4 mobile:mb-2">Step 1: Input Barang</h2>

                <template x-for="(item, index) in items" :key="index">
                    <div class="border-b pb-4 mb-4">
                        <h3 class="text-lg mobile:text-sm font-semibold text-gray-700 md:mb-2">Data Barang - <span x-text="index + 1"></span></h3>
                        <div class="grid grid-cols-2 gap-4 mb-4 mobile:gap-2 mobile:mb-2">
                            <div class="col-span-2 sm:col-span-1">
                                <label for="nama_barang" class="block text-sm mobile:text-[10px] font-medium text-gray-700">Nama Barang</label>
                                <input type="text" :id="'nama_barang_' + index" class="w-full px-4 py-2 md:py-2 mobile:px-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" x-model="item.nama_barang" required>
                            </div>
                            <div class="col-span-2 sm:col-span-1">
                                <label for="seri" class="block text-sm mobile:text-[10px] font-medium text-gray-700">Seri</label>
                                <input type="text" :id="'seri_' + index" class="w-full px-4 py-2 md:py-2 mobile:px-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" x-model="item.seri" required>
                            </div>
                            <div class="col-span-2">
                                <label for="jumlah" class="block text-sm mobile:text-[10px] font-medium text-gray-700">Jumlah</label>
                                <input type="number" :id="'jumlah_' + index" class="w-full px-4 md:py-2 mobile:px-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" x-model="item.jumlah" required>
                            </div>
                            <div class="col-span-2">
                                <label for="satuan" class="block text-sm mobile:text-[10px] font-medium text-gray-700">Satuan</label>
                                <div class="flex space-x-6 mobile:space-x-3 md:mt-2 text-sm mobile:text-[10px] mobile:h-9">
                                    <!-- Satuan -->
                                    <select x-model="item.satuan" class="mobile:text-[10px]" @change="updateRasio(index)">
                                        <option value="" class="bg-gray-400 hover:bg-gray-300" selected>Pilih satuan...</option>
                                        <option value="Pcs">Pcs</option>
                                        <option value="Roll">Roll</option>
                                        <option value="Pack">Pack</option>
                                        <option value="Unit">Unit</option>
                                    </select>

                                    <!-- Rasio Input (Jika Diperlukan) -->
                                    <div x-show="item.showRasio">
                                        <input type="number" x-model="item.rasio" class="mobile:text-[10px] mobile:w-24 mobile:h-9" :placeholder="item.placeholder" :required="item.rasioRequired">
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-2">
                                <label for="lokasi" class="block text-sm mobile:text-[10px] font-medium text-gray-700">Lokasi</label>
                                <select :id="'lokasi_' + index" x-model="item.lokasi" class="block w-full pl-10 mobile:pl-5 bg-body text-sm mobile:text-[10px] text-gray-900 border-0 focus:ring-0" required>
                                    <option value="" selected>Pilih lokasi...</option>
                                    @foreach ($kantorlayanan as $item)
                                    <option value="{{ $item->lokasi }}">
                                        {{ $item->pop }} - {{ $item->lokasi }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label for="catatan" class="block text-sm mobile:text-[10px] font-medium text-gray-700">Catatan (opsional)</label>
                                <input type="text" :id="'catatan_' + index" class="w-full px-4 md:py-2 mobile:px-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" x-model="item.catatan">
                            </div>
                            <button type="button" @click="removeItem(index)" class="bg-red-500 text-white px-2 py-1 rounded-lg mt-2" x-show="items.length > 1">Hapus Data</button>
                        </div>
                    </div>
                </template>

                <button type="button" @click="addItem" class="bg-blue-500 text-white px-4 md:py-2 mobile:px-2 rounded-lg md:mt-2">Tambah Data</button>

                <div class="flex md:justify-end mt-4 md:-mt-10">
                    <button type="button" @click="step = 2" :disabled="!isFormValid()" class="bg-blue-500 text-white px-4 md:py-2 mobile:px-2 rounded-lg hover:bg-blue-600">Lanjut ke Pengiriman</button>
                </div>
            </div>

            <!-- Step 2: Kirim Barang -->
            <div x-show="step === 2">
                <h2 class="text-xl mobile:text-md font-semibold text-gray-700 mb-4 mobile:mb-2">Step 2: Kirim Barang</h2>
                <form action="{{ route('pengiriman_barang.input.post.superadmin') }}" method="POST">
                    @csrf
                    <template x-for="(item, index) in items" :key="index">
                        <div>
                            <!-- Hidden inputs to capture item data -->
                            <input type="hidden" :name="'items[' + index + '][nama_barang]'" :value="item.nama_barang">
                            <input type="hidden" :name="'items[' + index + '][seri]'" :value="item.seri">
                            <input type="hidden" :name="'items[' + index + '][jumlah]'" :value="item.jumlah">
                            <input type="hidden" :name="'items[' + index + '][satuan]'" :value="item.satuan">
                            <input type="hidden" :name="'items[' + index + '][rasio]'" :value="item.rasio">
                            <input type="hidden" :name="'items[' + index + '][lokasi]'" :value="item.lokasi">
                            <input type="hidden" :name="'items[' + index + '][catatan]'" :value="item.catatan">

                            <!-- Displayed item details -->
                            <p class="md:mb-2">
                                <span class="font-medium text-gray-700">Nama Barang:</span>
                                <span x-text="item.nama_barang"></span>
                            </p>
                            <p>
                                <span class="font-medium text-gray-700">Seri:</span>
                                <span x-text="item.seri"></span>
                            </p>
                            <p>
                                <span class="font-medium text-gray-700">Jumlah:</span>
                                <span x-text="item.jumlah"></span>
                            </p>
                            <p>
                                <span class="font-medium text-gray-700">Satuan:</span>
                                <span x-text="item.satuan"></span>
                            </p>
                            <p>
                                <span class="font-medium text-gray-700">Rasio:</span>
                                <span x-text="item.rasio"></span>
                            </p>
                            <p>
                                <span class="font-medium text-gray-700">Lokasi Tujuan:</span>
                                <span x-text="item.lokasi"></span>
                            </p>
                            <p>
                                <span class="font-medium text-gray-700">Catatan:</span>
                                <span x-text="item.catatan"></span>
                            </p>
                            <hr class="my-4">
                        </div>
                    </template>


                    <div class="flex justify-between">
                        <button type="button" @click="step = 1" class="bg-gray-300 text-gray-700 px-4 md:py-2 mobile:px-2 rounded-lg hover:bg-gray-400 mobile:mr-2">Kembali ke Input Barang</button>
                        <button type="submit" class="bg-green-500 text-white px-4 md:py-2 mobile:px-2 rounded-lg hover:bg-green-600">Kirim Barang</button>
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