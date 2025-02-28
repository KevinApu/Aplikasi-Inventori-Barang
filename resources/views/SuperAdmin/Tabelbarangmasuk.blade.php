<x-sidebar-layout>
    <div class="container mx-auto px-4 max-w-full">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold font-heading text-gray-500">Data Barang Masuk</h1>
        </div>

        <div x-data="searchApp()" class="relative mt-12 bottom-8">
            <div class="flex justify-start h-12">
                <div class="relative" x-data="{ bulan: null }">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-4 h-4 mb-2 text-gray-500 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>

                    <select x-model="pop" @change="search()" class="block w-full pl-10 bg-body text-sm text-gray-900 border-0 focus:ring-0 focus:border-b focus:border-zinc-700" required>
                        <option value="" class="bg-gray-400 hover:bg-gray-300" selected>Pilih pop...</option>
                        @foreach ($kantorlayanan as $item)
                        <option value="{{ $item->pop}}">
                            {{ $item->pop }} - {{ $item->lokasi }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="overflow-x-auto shadow-md rounded-t-lg overscroll-x-none transition-shadow duration-900 ease-in-out shadow hover:shadow-2xl hover:shadow-header-1">
                <table class="w-full text-left rtl:text-right font-roboto">
                    <thead class="text-sm uppercase whitespace-nowrap bg-header-1 text-center bg-opacity-30 text-gray-500 shadow-inner">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Kode
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Kategori
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Nama Barang
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Seri
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Jumlah
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Satuan
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Lokasi
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Foto
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Keterangan
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Stok Terakhir
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Diinput Oleh
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Waktu
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="item in paginatedResults" :key="item.id">
                            <tr class="odd:odd-1 even:bg-even-1 whitespace-nowrap border-6 border-b border-gray-300 mobile:text-xs laptop:text-sm hover:bg-gray-200 cursor-pointer transition-colors duration-300 ease-in-out">
                                <th scope="row" class="px-6 py-3 font-medium whitespace-nowrap" x-text="item.kode_barang"></th>
                                <td class="px-6 py-3 truncate" x-text="item.kategori"></td>
                                <td class="px-6 py-3 truncate" x-text="item.nama_barang"></td>
                                <td class="px-6 py-3 truncate" x-text="item.seri"></td>
                                <td class="px-6 py-3 truncate">
                                    <span>
                                        <template x-if="item.satuan === 'roll'">
                                            <span x-text="item.jumlah + ' roll'"></span>
                                        </template>
                                        <template x-if="item.satuan === 'pack'">
                                            <span x-text="item.jumlah + ' pack'"></span>
                                        </template>
                                        <template x-if="item.satuan !== 'roll' && item.satuan !== 'pack'">
                                            <span x-text="item.jumlah"></span>
                                        </template>
                                    </span>
                                </td>
                                <td class="px-6 py-3">
                                    <span>
                                        <template x-if="item.satuan === 'roll'">
                                            <span x-text="item.rasio + ' meter'"></span>
                                        </template>
                                        <template x-if="item.satuan === 'pack'">
                                            <span x-text="item.rasio + ' pcs'"></span>
                                        </template>
                                        <template x-if="item.satuan !== 'roll' && item.satuan !== 'pack'">
                                            <span>-</span>
                                        </template>
                                    </span>
                                </td>
                                <td class="px-6 py-3 truncate" x-text="item.lokasi"></td>
                                <td class="px-6 py-3">
                                    <!-- Pop Up Lihat Foto -->
                                    <div x-data="{ open: false }">
                                        <button x-on:click="open = ! open" class="no-underline hover:underline w-[70px] text-blue-400">Lihat Foto</button>
                                        <div x-show="open" x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0 transform scale-90"
                                            x-transition:enter-end="opacity-100 transform scale-100"
                                            x-transition:leave="transition ease-in duration-200"
                                            x-transition:leave-start="opacity-100 transform scale-100"
                                            x-transition:leave-end="opacity-0 transform scale-90"
                                            tabindex="-1" @keydown.escape.window="open = false" @click.self="open = false" class="fixed inset-0 z-50 flex items-center justify-center w-full h-screen">
                                            <div class="relative w-full max-w-[300px] mobile:max-w-[200px] max-h-full rounded-lg bg-zinc-700 shadow-[0px_50px_60px_20px_rgba(0,0,0,0.3)]">
                                                <!-- Modal header -->
                                                <div class="flex items-center justify-between p-1 border-b rounded-t border-gray-600">
                                                    <button type="button" x-on:click="open = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center hover:bg-gray-600 hover:text-white">
                                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <!-- Modal body -->
                                                <div class="p-4 w-full flex items-center justify-center shadow">
                                                    <img :src="`/storage/${item.foto}`" width="200" height="100">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3 truncate" x-text="item.keterangan ? item.keterangan : '-'"></td>
                                <td class="px-6 py-3 truncate" x-text="item.hasil ? item.hasil : '-'"></td>
                                <td class="px-6 py-3 truncate" x-text="item.input_by"></td>
                                <td class="px-6 py-3 truncate" x-text="item.created_at"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <div class="absolute z-50 flex justify-end left-auto right-16 bottom-0">
                    <!-- Modal Pop-up -->
                    <div x-show="showPrintPopup" x-cloak
                        x-transition:enter="transition transform duration-300"
                        x-transition:enter-start="translate-y-full scale-50 opacity-0"
                        x-transition:enter-end="translate-y-0 scale-100 opacity-100"
                        x-transition:leave="transition transform duration-300"
                        x-transition:leave-start="translate-y-0 scale-100 opacity-100"
                        x-transition:leave-end="translate-y-full scale-50 opacity-0"
                        class="flex items-center space-x-6 p-4 w-[25rem] h-10 bg-white shadow-md rounded-md">
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" class="w-5 h-5 cursor-pointer rounded-md mr-2 hover:border-indigo-500 hover:bg-indigo-100 checked:bg-indigo-500 checked:border-indigo-500 checked:text-indigo-500 focus:ring-0 focus:border-0" checked disabled>
                            <span class="text-gray-700" x-text="`${checkedItems.length} Items`"></span>
                        </div>
                        <div class="flex items-center space-x-2 cursor-pointer" @click="printSelectedItems">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2V10a2 2 0 012-2h16a2 2 0 012 2v6a2 2 0 01-2 2h-2M6 14h0M10 14h0M14 14h0M14 18h6v4H4v-4h2" />
                            </svg>
                            <span class="text-gray-700">Print Barcode</span>
                        </div>
                        <div class="flex items-center space-x-2 cursor-pointer" @click="deleteSelectedItems">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7L5 7M10 11V17M14 11V17M7 7L7 19A2 2 0 009 21H15A2 2 0 0017 19V7M9 7V4A2 2 0 0111 2H13A2 2 0 0115 4V7" />
                            </svg>
                            <span class="text-gray-700">Remove</span>
                        </div>
                    </div>
                </div>
                <!-- Pagination -->
                <div class="absolute mb-12 mobile:mb-8 rounded-md bg-zinc-200 flex justify-between w-full px-6 py-4 shadow-md">
                    <div>
                        <span class="text-sm tablet:text-xs mobile:text-[10px] text-gray-700">
                            <template x-if="results.length > 0">
                                <span>
                                    Menampilkan
                                    <span x-text="perPage ? (currentPage - 1) * perPage + 1 : 1"></span> - <span x-text="perPage ? Math.min(currentPage * perPage, results.length) : results.length"></span>
                                    dari <span x-text="results.length"></span> barang
                                </span>
                            </template>
                            <template x-if="results.length === 0">
                                <span>Tidak ada data</span>
                            </template>
                        </span>
                    </div>
                    <div class="flex space-x-2 mobile:space-x-1 items-center justify-center">
                        <button @click="currentPage = Math.max(currentPage - 1, 1)"
                            class="bg-gray-200 text-gray-600 text-xl tablet:text-lg mobile:text-sm hover:bg-blue-400 hover:text-white transition-colors duration-200 rounded-full laptop:px-3 laptop:py-1 tablet:px-2 tablet:py-0.5 tablet:w-8 tablet:h-8 mobile:px-1 mobile:py-0 mobile:w-6 mobile:h-6"
                            :class="{'opacity-50 cursor-not-allowed': currentPage === 1}">
                            <
                                </button>
                                <template x-if="currentPage > 3">
                                    <span class="laptop:px-3 laptop:py-1 tablet:px-2 tablet:py-0.5 tablet:w-8 tablet:h-8 mobile:px-1 mobile:py-0 mobile:w-6 mobile:h-6">...</span>
                                </template>
                                <template x-for="page in totalPages" :key="page">
                                    <template x-if="page >= Math.max(currentPage - 2, 1) && page <= Math.min(currentPage + 2, totalPages)">
                                        <button @click="currentPage = page"
                                            class="laptop:px-3 laptop:py-1 tablet:px-2 tablet:py-0.5 tablet:w-7 tablet:h-7 tablet:text-xs mobile:px-1 mobile:py-0 mobile:w-6 mobile:h-6 mobile:text-[10px] rounded-full border text-gray-700"
                                            :class="{'bg-blue-500 text-white': currentPage === page, 
                                            'bg-white hover:bg-gray-200': currentPage !== page}">
                                            <span x-text="page"></span>
                                        </button>
                                    </template>
                                </template>
                                <template x-if="currentPage < totalPages - 3">
                                    <span class="laptop:px-3 laptop:py-1 tablet:px-2 tablet:py-0.5 tablet:w-8 tablet:h-8 mobile:px-1 mobile:py-0 mobile:w-6 mobile:h-6">...</span>
                                </template>
                                <button @click="currentPage = Math.min(currentPage + 1, totalPages)"
                                    class="bg-gray-200 text-gray-600 text-xl tablet:text-lg mobile:text-sm hover:bg-blue-400 hover:text-white transition-colors duration-200 rounded-full laptop:px-3 tablet:px-2 tablet:py-0.5 tablet:w-8 tablet:h-8 laptop:py-1 mobile:px-1 mobile:py-0 mobile:w-6 mobile:h-6"
                                    :class="{'opacity-50 cursor-not-allowed': currentPage === totalPages}">
                                    >
                                </button>
                                <button @click="perPage = null; currentPage = 1"
                                    x-show="perPage"
                                    class="laptop:px-3 laptop:py-1 tablet:px-2 tablet:py-0.5 mobile:px-1 mobile:py-0 ml-2 border text-sm tablet:text-xs mobile:text-[10px] font-medium focus:outline-none bg-white text-gray-700 hover:bg-gray-200 bg-gray-700 text-white rounded-full transition-colors duration-200">
                                    All
                                </button>
                                <button @click="perPage = 10; currentPage = 1"
                                    x-show="!perPage"
                                    class="laptop:px-3 laptop:py-1 tablet:px-2 tablet:py-0.5 mobile:px-1 mobile:py-0 ml-2 border text-sm tablet:text-xs mobile:text-[10px] font-medium focus:outline-none bg-blue-500 text-white rounded-full transition-colors duration-200">
                                    Page
                                </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function searchApp() {
            return {
                pop: '',
                currentPage: 1,
                perPage: 10,
                defaultPerPage: 10,
                results: [],
                search() {
                    if (this.pop === '') {
                        this.results = [];
                        return;
                    }
                    // Ambil data dari server
                    fetch(`/search/pop?pop=${this.pop}`)
                        .then(response => response.json())
                        .then(data => {
                            this.results = data;
                        });
                },

                get totalPages() {
                    return this.perPage ? Math.ceil(this.results.length / this.perPage) : 1;
                },

                get paginatedResults() {
                    if (!this.perPage) return this.results;
                    const start = (this.currentPage - 1) * this.perPage;
                    const end = start + this.perPage;
                    return this.results.slice(start, end);
                },
            };
        }
    </script>
</x-sidebar-layout>