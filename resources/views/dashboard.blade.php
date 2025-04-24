<x-sidebar-layout>
    <main>
        <div class="flex items-center justify-between border-b border-primary-darker">
            <h1 class="text-2xl font-semibold font-heading text-gray-500">Dashboard</h1>
        </div>

        <!-- <a href="{{ route('update_rekap_stok') }}" class="block p-4 rounded-md bg-red-600">refresh</a> -->

        <div class="grid grid-cols-3 gap-4 py-4">
            <!-- Card 1: Total Expenses -->
            <div class="overflow-x-auto bg-white shadow-lg rounded-lg p-5 relative pb-10">
                <h2 class="text-sm md:text-lg font-semibold">Barang Masuk</h2>
                <p
                    x-data="{ current: 0, end: {{ $barang_masuk }} }"
                    x-init="let i = setInterval(() => {
      current++;
      if (current >= end) clearInterval(i);
  }, 1)"
                    x-text="current"
                    class="text-2xl font-bold"></p>

                <div class="absolute top-0 right-0 mt-5 mr-5">
                    <svg class="md:w-12 md:h-12 text-emerald-600 text-opacity-60" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.027 10.9a8.729 8.729 0 0 1 6.422-3.62v-1.2A2.061 2.061 0 0 1 12.61 4.2a1.986 1.986 0 0 1 2.104.23l5.491 4.308a2.11 2.11 0 0 1 .588 2.566 2.109 2.109 0 0 1-.588.734l-5.489 4.308a1.983 1.983 0 0 1-2.104.228 2.065 2.065 0 0 1-1.16-1.876v-.942c-5.33 1.284-6.212 5.251-6.25 5.441a1 1 0 0 1-.923.806h-.06a1.003 1.003 0 0 1-.955-.7A10.221 10.221 0 0 1 5.027 10.9Z" />
                    </svg>
                </div>
                <div class="absolute bottom-0 left-0 right-0 mb-5 mx-5">
                    <div class="bg-emerald-400 h-2 rounded-full"></div>
                </div>
            </div>


            <!-- Card 2: Total Salaries -->
            <div class="overflow-x-auto bg-white shadow-lg rounded-lg p-5 relative pb-10">
                <h2 class="text-sm md:text-lg font-semibold">Barang Keluar</h2>
                <p
                    x-data="{ current: 0, end: {{ $barang_keluar }} }"
                    x-init="let i = setInterval(() => {
      current++;
      if (current >= end) clearInterval(i);
  }, 1)"
                    x-text="current"
                    class="text-2xl font-bold"></p>

                <div class="absolute top-0 right-0 mt-5 mr-5">
                    <svg class="md:w-12 md:h-12 text-blue-600 text-opacity-60" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14.502 7.046h-2.5v-.928a2.122 2.122 0 0 0-1.199-1.954 1.827 1.827 0 0 0-1.984.311L3.71 8.965a2.2 2.2 0 0 0 0 3.24L8.82 16.7a1.829 1.829 0 0 0 1.985.31 2.121 2.121 0 0 0 1.199-1.959v-.928h1a2.025 2.025 0 0 1 1.999 2.047V19a1 1 0 0 0 1.275.961 6.59 6.59 0 0 0 4.662-7.22 6.593 6.593 0 0 0-6.437-5.695Z" />
                    </svg>
                </div>
                <div class="absolute bottom-0 left-0 right-0 mb-5 mx-5">
                    <div class="bg-blue-400 h-2 rounded-full"></div>
                </div>
            </div>

            <!-- Card 3: Total Wage's -->
            <div class="overflow-x-auto bg-white shadow-lg rounded-lg p-5 relative pb-10">
                <h2 class="text-sm md:text-lg font-semibold">Barang Rusak</h2>
                <p
                    x-data="{ current: 0, end: {{ $barang_rusak }} }"
                    x-init="
    if (end > 0) {
        let i = setInterval(() => {
            current++;
            if (current >= end) clearInterval(i);
        }, 1);
    }"
                    x-text="current"
                    class="text-2xl font-bold"></p>

                <div class="absolute top-0 right-0 mt-5 mr-5">
                    <svg class="md:w-12 md:h-12 text-red-600 text-opacity-60" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor" viewBox="0 0 512 512">
                        <path
                            d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z" />
                    </svg>
                </div>
                <div class="absolute bottom-0 left-0 right-0 mb-5 mx-5">
                    <div class="bg-red-400 h-2 rounded-full"></div>
                </div>
            </div>
        </div>

        <div class="flex laptop:flex-row flex-col gap-6 laptop:min-h-[40rem]">
            <div x-data="filterChart()" x-init="init()" class="overflow-x-auto w-full laptop:flex-1 bg-white rounded-lg shadow-sm p-4 md:p-6">
                <div class="mb-4">
                    <label for="filterBarang" class="block text-sm font-medium text-gray-700 mb-1">Filter Barang</label>
                    <select id="filterBarang" x-model="selectedBarang" @change="onDropdownChange" class="w-full md:w-1/3 border-gray-300 rounded-lg shadow-sm">
                        <option value="all">Semua Barang</option>
                        @foreach($daftarBarangKeluar as $barang)
                        <option value="{{ $barang->stokGudang->id }}">{{ $barang->stokGudang->nama_barang }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="overflow-x-auto laptop:h-[30rem]">
                    <canvas id="myChart"></canvas>
                </div>
            </div>



            <div class="w-full laptop:w-2/5 bg-white shadow-md sm:rounded-lg p-4">
                <div x-data="searchApp()" x-init="search()" class="relative mt-12 bottom-8">
                    <div class="flex justify-start h-12">
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 mobile:w-3 mobile:h-3 mb-2 mobile:mb-4 text-gray-500 text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="search" x-model="namabarang" @input="search()"
                                class="block rounded-md w-full ps-10 text-sm mobile:text-[10px] text-gray-900 border-0 focus:ring-0 focus:border-b focus:border-zinc-700"
                                placeholder="Nama barang..." required />
                        </div>
                        <div x-data="{ isLoading: false }">
                            <!-- Tombol Cetak Laporan -->
                            <div>
                                <a href="{{ route('view.laporan.rekap') }}"
                                    @click.prevent="isLoading = true; window.location.href = '{{ route('view.laporan.rekap') }}';"
                                    class="block py-1 px-2 transform transition-transform duration-200 hover:scale-110"
                                    title="Print Laporan">
                                    <svg class="w-8 h-8 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M16.444 18H19a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h2.556M17 11V5a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v6h10ZM7 15h10v4a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-4Z" />
                                    </svg>
                                </a>
                            </div>

                            <!-- Overlay Loading -->
                            <div x-show="isLoading"
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-60 transition-opacity duration-300"
                                x-transition:enter="opacity-0"
                                x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100"
                                x-transition:leave="opacity-100"
                                x-transition:leave-start="opacity-100"
                                x-transition:leave-end="opacity-0">
                                <!-- Spinner -->
                                <div class="relative">
                                    <svg class="h-16 w-16 animate-spin text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                    <!-- Glow Effect -->
                                    <div class="absolute inset-0 h-16 w-16 rounded-full bg-blue-500 opacity-20 blur-xl"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div x-data="{
            currentPage: 1,
            perPage: 10,
            get totalPages() {
                return this.perPage ? Math.ceil(results.length / this.perPage) : 1;
            },
            get paginatedResults() {
                if (!this.perPage) return results;
                const start = (this.currentPage - 1) * this.perPage;
                const end = start + this.perPage;
                return results.slice(start, end);
            },
            }" class="relative shadow-md sm:rounded-lg bg-white overflow-x-auto">
                        <table class="w-full text-xs md:text-sm text-left text-gray-900 rounded-t-lg">
                            <thead class="text-[10px] md:text-xs text-gray-700 uppercase bg-gray-100 border-b">
                                <tr>
                                    <th scope="col" class="px-6 py-3 font-semibold">Nama Barang</th>
                                    <th scope="col" class="px-6 py-3 font-semibold">Stok Awal</th>
                                    <th scope="col" class="px-6 py-3 font-semibold">In</th>
                                    <th scope="col" class="px-6 py-3 font-semibold">Out</th>
                                    <th scope="col" class="px-6 py-3 font-semibold">Sisa</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="item in paginatedResults" :key="item.id">
                                    <tr class="bg-white border-b border-gray-200 hover:bg-gray-100 cursor-pointer transition-colors duration-300">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            <span x-text="item.nama_barang"></span> - <span x-text="item.seri"></span>
                                        </th>
                                        <td class="px-6 py-4" x-text="item.stok_awal"></td>
                                        <td class="px-6 py-4" x-text="item.in ?? 0"></td>
                                        <td class="px-6 py-4" x-text="item.out ?? 0"></td>
                                        <td class="px-6 py-4">
                                            <span>
                                                <template x-if="item.satuan === 'pcs' || item.satuan === 'unit'">
                                                    <span x-text="item.jumlah"></span>
                                                </template>
                                                <template x-if="item.satuan === 'roll' || item.satuan === 'pack'">
                                                    <span x-text="item.hasil"></span>
                                                </template>
                                            </span>
                                        </td>
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
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function searchApp() {
            return {
                namabarang: '',
                results: [],
                search() {
                    // Ambil data dari server
                    fetch(`/search/rekap?namabarang=${this.namabarang}`)
                        .then(response => response.json())
                        .then(data => {
                            this.results = data;
                        });
                }
            };
        }

        function filterChart() {
            return {
                selectedBarang: 'all',
                chart: null,
                labels: [],
                data: [],

                onDropdownChange() {
                    localStorage.setItem('lastSelectedBarang', this.selectedBarang);
                    localStorage.setItem('shouldReload', 'true');
                    location.reload(); // reload halaman
                },


                init() {
                    const shouldReload = localStorage.getItem('shouldReload');
                    const lastSelected = localStorage.getItem('lastSelectedBarang');

                    if (shouldReload === 'true' && lastSelected) {
                        this.selectedBarang = lastSelected;
                        localStorage.removeItem('shouldReload'); // supaya reload cuma sekali
                        // lanjut fetch data setelah reload
                    }

                    this.fetchData();
                },


                fetchData() {
                    fetch(`/filter-barang/chart/${this.selectedBarang}`)
                        .then(res => res.json())
                        .then(response => {
                            const {
                                labels,
                                data
                            } = response;

                            this.labels = labels;
                            this.data = data;

                            localStorage.setItem('lastSelectedBarang', this.selectedBarang); // simpan

                            if (this.chart) {
                                this.chart.data.labels = labels;
                                this.chart.data.datasets[0].data = data;
                                this.chart.update();
                            } else {
                                const ctx = document.getElementById("myChart").getContext("2d");
                                this.chart = new Chart(ctx, {
                                    type: "line",
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: "Jumlah Barang Keluar",
                                            data: data,
                                            borderColor: "rgba(75, 192, 192, 1)",
                                            backgroundColor: "rgba(75, 192, 192, 0.2)",
                                            fill: true,
                                            borderWidth: 2
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        interaction: {
                                            intersect: false
                                        },
                                        scales: {
                                            y: {
                                                suggestedMax: 3,
                                                min: 0,
                                                ticks: {
                                                    stepSize: 50
                                                },
                                                precision: 0,
                                            }
                                        }
                                    }
                                });
                            }
                        });
                }
            }
        }
    </script>
</x-sidebar-layout>