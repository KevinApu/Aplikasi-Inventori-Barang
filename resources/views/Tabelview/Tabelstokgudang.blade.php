<x-sidebar-layout>
    <div class="container mx-auto px-4">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold font-heading text-gray-500">Data Stok Gudang</h1>
        </div>
        <div x-data="searchApp()" x-init="search()" class="relative mt-12 bottom-8">

            <div x-data="{ openFilter: false }" class="md:hidden -mt-2 mb-2 flex justify-end">
                <button @click="openFilter = !openFilter" class="text-white py-2 px-4 rounded-md">
                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z"/>
                    </svg>
                </button>

                <div x-show="openFilter" @click.away="openFilter = false" class="md:hidden absolute top-16 left-0 right-0 bg-white p-4 rounded-md shadow-lg z-10">
                    <div class="space-y-4">
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 mobile:ps-1 pointer-events-none">
                                <svg class="w-4 h-4 mobile:w-2 mobile:h-2 mb-2 mobile:mb-3 text-gray-500 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="search" x-model="kategori" @input="search()" class="block w-full ps-10 mobile:ps-4 text-sm mobile:text-[10px] bg-body text-gray-900 border-0 rounded-l-md focus:ring-0 focus:border-b focus:border-zinc-700" placeholder="Kategori..." required />
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 mobile:ps-1 pointer-events-none">
                                <svg class="w-4 h-4 mobile:w-2 mobile:h-2 mb-2 mobile:mb-3 text-gray-500 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="search" x-model="namabarang" @input="search()" class="block w-full ps-10 mobile:ps-4 bg-body text-sm mobile:text-[10px] text-gray-900 border-0 rounded-md focus:ring-0 focus:border-b focus:border-zinc-700" placeholder="Nama barang..." required />
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 mobile:ps-1 pointer-events-none">
                                <svg class="w-4 h-4 mobile:w-2 mobile:h-2 mb-2 text-gray-500 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="search" x-model="seri" @keyup="search()" class="block w-full ps-10 mobile:ps-4 bg-body text-sm mobile:text-[10px] text-gray-900 border-0 rounded-md focus:ring-0 focus:border-b focus:border-zinc-700" placeholder="Seri ..." required />
                        </div>
                        <div class="flex justify-between mt-4">
                            <button @click="resetFilter()" class="bg-gray-500 text-white text-[10px] px-2 rounded-md hover:bg-red-600">
                                Reset Filter
                            </button>
                            <button @click="applyFilter()" class="bg-gray-500 text-white text-[10px] px-2 rounded-md hover:bg-red-600">
                                Terapkan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden md:flex justify-start h-12">
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 mb-2 text-gray-500 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" x-model="kategori" @input="search()" class="block w-full ps-10 bg-body text-sm text-gray-900 border-0 focus:ring-0 focus:border-b focus:border-zinc-700" placeholder="Kategori..." required />
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 mb-2 text-gray-500 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" x-model="namabarang" @input="search()" class="block w-full ps-10 bg-body text-sm text-gray-900 border-0 focus:ring-0 focus:border-b focus:border-zinc-700" placeholder="Nama barang..." required />
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 mb-2 text-gray-500 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" x-model="seri" @input="search()" class="block w-full ps-10 bg-body text-sm text-gray-900 border-0 focus:ring-0 focus:border-b focus:border-zinc-700" placeholder="Seri ..." required />
                </div>
                <div class="flex justify-between">
                    <button @click="resetFilter()" class="hidden md:block bg-gray-700 text-white py-1 px-2 ml-2 h-9 text-xs rounded-md hover:bg-gray-600" title="Reset Filter">
                        Reset
                    </button>
                </div>
            </div>
            <div class="overflow-x-auto shadow-md rounded-t-lg overscroll-x-none transition-shadow duration-200 ease-in-out shadow hover:shadow-2xl hover:shadow-header-4">
                <table class="w-full text-left rtl:text-right font-roboto">
                    <thead class="text-sm mobile:text-xs uppercase whitespaces-nowrap bg-gray-600 text-center text-white">
                        <tr>
                            <th scope="col" class="px-6 py-3">Kode Barang</th>
                            <th scope="col" class="px-6 py-3">Kategori</th>
                            <th scope="col" class="px-6 py-3">Nama Barang</th>
                            <th scope="col" class="px-6 py-3">Seri</th>
                            <th scope="col" class="px-6 py-3">Jumlah</th>
                            <th scope="col" class="px-6 py-3">Satuan</th>
                            <th scope="col" class="px-6 py-3">Lokasi</th>
                            <th scope="col" class="px-6 py-3">Foto</th>
                            <th scope="col" class="px-6 py-3">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="item in paginatedResults" :key="item.id">
                            <tr class="odd:bg-gray-50 even:bg-white whitespace-nowrap border-6 border-b border-gray-300 mobile:text-xs laptop:text-sm hover:bg-gray-200 cursor-pointer transition-colors duration-300 ease-in-out">
                                <th scope="row" class="px-6 py-3 font-medium whitespace-nowrap" x-text="item.kode_barang"></th>
                                <td class="px-6 py-3 truncate" x-text="item.kategori"></td>
                                <td class="px-6 py-3 truncate" x-text="item.nama_barang"></td>
                                <td class="px-6 py-3 truncate" x-text="item.seri"></td>
                                <td class="px-6 py-3 truncate" x-text="item.jumlah"></td>
                                <td class="px-6 py-3 truncate" x-text="item.satuan"></td>
                                <td class="px-6 py-3 truncate" x-text="item.lokasi"></td>
                                <td class="px-6 py-3 truncate">
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
                                                <div class="flex items-center justify-between p-1 border-b rounded-t border-gray-600">
                                                    <button type="button" x-on:click="open = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center hover:bg-gray-600 hover:text-white">
                                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="p-4 w-full flex items-center justify-center shadow">
                                                    <img :src="`/storage/${item.foto}`" width="200" height="100">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3 truncate" x-text="item.keterangan ? item.keterangan : '-'"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
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
                            class="laptop:px-3 laptop:py-1 tablet:px-2 tablet:py-0.5 mobile:px-1 mobile:py-0 ml-2 border text-sm tablet:text-xs mobile:text-[10px] font-medium focus:outline-none bg-white text-gray-700 hover:bg-gray-200 bg-gray-700 text-black rounded-full transition-colors duration-200">
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
        <script>
            function searchApp() {
                return {
                    kategori: '',
                    namabarang: '',
                    seri: '',
                    currentPage: 1,
                    perPage: 10,
                    defaultPerPage: 10,
                    results: [],
                    search() {
                        // Ambil data dari server
                        fetch(`/search/stokgudang?kategori=${this.kategori}&namabarang=${this.namabarang}&seri=${this.seri}`)
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
                    resetFilter() {
                        this.kategori = '';
                        this.namabarang = '';
                        this.seri = '';
                        this.search(); // Panggil search untuk update tampilan setelah reset
                    },

                    applyFilter() {
                        this.search(); // Lakukan pencarian dengan filter
                        this.openFilter = false; // Tutup pop-up filter setelah submit
                    },
                };
            }
        </script>
</x-sidebar-layout>