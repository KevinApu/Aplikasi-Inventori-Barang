<x-sidebar-layout>
    <div x-data="searchApp()">
        @if($kantorlayanan && $kantorlayanan->count() > 0)
        <div class="relative w-64">
            <label class="block text-purple-600 mb-1">Pilih Cabang</label>
            <div class="relative">
                <select x-model="pop" @change="search()" class="block appearance-none w-full bg-white border border-purple-600 text-gray-700 py-2 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-purple-500">
                    <option value="" class="bg-gray-400 hover:bg-gray-300" selected>Pilih Cabang...</option>
                    @foreach ($kantorlayanan as $item)
                    <option value="{{ $item->tujuan }}">
                        {{ $item->tujuan }}
                    </option>
                    @endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-purple-600">
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
        </div>
        @else
        <div class="text-center">
            <p class="text-gray-600">Belum ada riwayat pengiriman barang.</p>
        </div>
        @endif


        <template x-for="(item, index) in results" :key="item.id">
            <template x-if="index === 0">
                <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
                    <!-- Hanya tampilkan progress bar untuk item pertama -->
                    <div>
                        <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Status Pengiriman Barang</h2>
                        <!-- Progress Bar -->
                        <div class="flex items-center justify-between mb-6">
                            <!-- Step 2: Diproses -->
                            <div class="flex items-center flex-col text-center">
                                <div class="w-10 h-10 flex items-center justify-center bg-green-500 text-white rounded-full font-semibold">
                                    <span>1</span>
                                </div>
                                <span class="text-gray-700 mt-2">Diproses</span>
                                <span class="text-sm text-gray-500" x-text="item.formatted_created_at"></span>
                            </div>

                            <!-- Line -->
                            <div class="h-1 flex-1 bg-blue-300"></div>

                            <!-- Step 3: Dalam Pengiriman -->
                            <div class="flex items-center flex-col text-center">
                                <div class="w-10 h-10 flex items-center justify-center bg-blue-500 text-white rounded-full font-semibold">
                                    <span>2</span>
                                </div>
                                <span class="text-gray-700 mt-2">Dalam Pengiriman</span>
                                <span class="text-sm text-gray-500" x-text="item.formatted_updated_at || 'Menunggu penjemputan'"></span>
                            </div>

                            <!-- Line -->
                            <div class="h-1 flex-1 bg-gray-300"></div>

                            <!-- Step 4: Sampai Tujuan -->
                            <div class="flex items-center flex-col text-center">
                                <div class="w-10 h-10 flex items-center justify-center bg-gray-300 text-gray-600 rounded-full font-semibold">
                                    <span>3</span>
                                </div>
                                <span class="text-gray-700 mt-2">Sampai Tujuan</span>
                                <span class="text-sm text-gray-500" x-text="item.formatted_tanggal_estimasi || 'Estimasi Belum Tersedia'"></span>
                            </div>
                        </div>
                    </div>


                    <!-- Tabel detail pengiriman -->
                    <div x-show="results.length > 0" class="overflow-x-auto">
                        <table class="min-w-full table-auto bg-gray-50 border-separate border-spacing-2 border border-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-2 text-left">Nama Barang</th>
                                    <th class="px-4 py-2 text-left">Seri</th>
                                    <th class="px-4 py-2 text-left">Jumlah</th>
                                    <th class="px-4 py-2 text-left" x-show="results.some(item => item.rasio !== null)">Satuan</th>
                                    <th class="px-4 py-2 text-left">Catatan</th>
                                    <th class="px-4 py-2 text-left">Lokasi Tujuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="item in results" :key="item.id">
                                    <tr>
                                        <td class="px-4 py-2" x-text="item.nama_barang"></td>
                                        <td class="px-4 py-2" x-text="item.seri"></td>
                                        <td class="px-4 py-2" x-text="item.satuan ? `${item.jumlah} ${item.satuan}` : item.jumlah"></td>
                                        <td class="px-4 py-2" x-text="item.rasio !== null ? item.rasio : '-'"></td>
                                        <td class="px-4 py-2" x-text="item.catatan ? item.catatan : '-'"></td>
                                        <td class="px-4 py-2" x-text="item.tujuan"></td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <!-- Timeline Riwayat Pengiriman -->
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Pengiriman</h3>
                        <div class="space-y-6">
                            <!-- Step 1: Barang Diproses -->
                            <div x-data="{ open: false }" class="p-4 bg-white rounded-lg shadow-md border border-gray-200">
                                <div class="flex items-start space-x-4">
                                    <div class="w-8 h-8 mobile:w-4 mobile:h-4 p-2 bg-green-500 text-white rounded-full flex items-center justify-center font-semibold">1</div>
                                    <div class="flex-1">
                                        <p class="text-gray-700 font-medium">Barang diproses untuk pengiriman</p>
                                        <p class="text-sm text-gray-500" x-text="item.formatted_created_at"></p>
                                    </div>
                                    <button
                                        x-show="!(item.status === 'Sedang Dikirim' && item.resi !== null)"
                                        x-on:click="open = ! open"
                                        class="text-blue-500 hover:underline focus:outline-none">
                                        Input Resi
                                    </button>
                                </div>

                                <!-- Modal Input Resi -->
                                <div
                                    x-show="open"
                                    @keydown.escape.window="open = false"
                                    @click.self="open = false"
                                    class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50"
                                    x-cloak>
                                    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                                        <h2 class="text-xl font-semibold text-gray-700 mb-4">Input Resi & Estimasi</h2>
                                        <form :action="`/update-shipping/${item.tujuan}`" method="POST">
                                            @csrf
                                            <div class="mb-4">
                                                <label for="resi" class="block text-sm font-medium text-gray-700">Nomor Resi</label>
                                                <input
                                                    type="text"
                                                    name="resi"
                                                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                    placeholder="Masukkan Nomor Resi"
                                                    required>
                                            </div>
                                            <div class="mb-4">
                                                <label for="resi" class="block text-sm font-medium text-gray-700">Nama Driver</label>
                                                <input
                                                    type="text"
                                                    name="namakurir"
                                                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                    placeholder="Masukkan Nama Driver"
                                                    required>
                                            </div>
                                            <div class="mb-4">
                                                <label for="estimasi" class="block text-sm font-medium text-gray-700">Tanggal Estimasi</label>
                                                <input
                                                    type="date"
                                                    name="tanggal_estimasi"
                                                    class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                                    required
                                                    min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                                    value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}">
                                            </div>
                                            <div class="flex justify-end space-x-2">
                                                <button
                                                    type="button"
                                                    x-on:click="open = false"
                                                    class="px-4 py-2 bg-gray-300 rounded-md text-gray-700 hover:bg-gray-400">
                                                    Batal
                                                </button>
                                                <button
                                                    type="submit"
                                                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                                    Simpan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Barang Dalam Perjalanan -->
                            <div
                                x-show="item.status === 'Sedang Dikirim' && item.resi !== null"
                                class="p-4 bg-white rounded-lg shadow-md border border-gray-200"
                                x-cloak>
                                <div class="flex items-start space-x-4">
                                    <div class="w-8 h-8 mobile:w-4 mobile:h-4 p-2 bg-blue-500 text-white rounded-full flex items-center justify-center font-semibold">2</div>
                                    <div class="flex-1">
                                        <p class="text-gray-700 font-medium">Barang dalam perjalanan</p>
                                        <p class="text-sm text-gray-500 mb-2" x-text="item.formatted_updated_at"></p>
                                        <div class="bg-gray-50 p-3 border border-dashed border-blue-300 rounded-lg flex items-center justify-between">
                                            <div>
                                                <p class="text-sm mobile:text-[10px] text-gray-600 font-semibold">Nomor Resi</p>
                                                <p class="text-lg text-blue-600 font-bold" x-text="item.resi || 'Resi tidak tersedia'" id="resiText"></p>
                                            </div>
                                            <button @click="navigator.clipboard.writeText(document.getElementById('resiText').innerText); copied = true; setTimeout(() => copied = false, 2000)"
                                                class="p-2 rounded-md text-blue-600 hover:bg-gray-200 transition" x-data="{ copied: false }">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-copy">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M7 7m0 2.667a2.667 2.667 0 0 1 2.667 -2.667h8.666a2.667 2.667 0 0 1 2.667 2.667v8.666a2.667 2.667 0 0 1 -2.667 2.667h-8.666a2.667 2.667 0 0 1 -2.667 -2.667z" />
                                                    <path d="M4.012 16.737a2.005 2.005 0 0 1 -1.012 -1.737v-10c0 -1.1 .9 -2 2 -2h10c.75 0 1.158 .385 1.5 1" />
                                                </svg>
                                                <span x-show="copied" class="text-xs text-green-600 absolute mt-1">Copied!</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 3: Estimasi Sampai -->
                            <div
                                x-show="item.status === 'Sedang Dikirim' && item.resi !== null"
                                class="p-4 bg-white rounded-lg shadow-md border border-gray-200"
                                x-cloak>
                                <div class="flex items-start space-x-4">
                                    <div class="w-8 h-8 mobile:w-4 mobile:h-4 p-2 bg-gray-300 text-gray-500 rounded-full flex items-center justify-center font-semibold">3</div>
                                    <div class="flex-1">
                                        <p class="text-gray-700 font-medium">Estimasi sampai di Lokasi tujuan</p>
                                        <p class="text-sm text-gray-500" x-text="item.formatted_tanggal_estimasi || 'Estimasi Belum Tersedia'"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </template>

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

    </div>

    <script>
        function searchApp() {
            return {
                pop: '',
                results: [],
                search() {
                    // Simpan nilai `pop` ke sessionStorage setiap kali berubah
                    sessionStorage.setItem('selectedPop', this.pop);

                    if (this.pop === '') {
                        this.results = [];
                        return;
                    }

                    // Lakukan fetch untuk mendapatkan data
                    fetch(`/search/pengiriman?pop=${this.pop}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log(data); // Lihat data dari server
                            this.results = data;
                        })
                        .catch(error => {
                            console.error('Error fetching data:', error);
                        });
                },
                init() {
                    // Ambil nilai `pop` dari sessionStorage jika ada
                    const savedPop = sessionStorage.getItem('selectedPop');
                    if (savedPop) {
                        this.pop = savedPop;
                        this.search();
                    }
                },
            };
        }
    </script>
</x-sidebar-layout>