<x-sidebar-layout>
    <div x-data="{ open: @if(session('error')) true @else false @endif }" x-show="open" @keydown.escape.window="open = false"
        class="fixed z-50 inset-0 flex items-center justify-center bg-black bg-opacity-30">
        <div class="relative p-4 sm:ml-64 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow bg-zinc-800 bg-opacity-50">
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-white w-12 h-12 text-sky-200" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 text-white">Produk sudah ditambahkan!</h3>
                    <button @click="open = false" type="button"
                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Yes
                    </button>
                    <a href="#order" @click="open = false">
                        <button type="button"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-blue-900 focus:outline-none bg-white rounded-lg border border-sky-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 focus:ring-gray-700 bg-gray-800 text-gray-400 border-gray-600 hover:text-white hover:bg-gray-700">
                            Buka List
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="container mx-auto px-4">
        <div class="mb-4">
            <h1 class="text-2xl font-semibold font-heading text-gray-500">Input Barang Keluar</h1>
        </div>

        <div id="reader"
            class="mx-auto hidden mobile:block tablet:block tablet:mb-2
            bg-white border border-gray-300 rounded-lg shadow-lg 
            overflow-hidden relative">
        </div>


        <div x-data="searchApp()" class="relative mt-16 bottom-8">
            <div x-data="{ openFilter: false }" class="md:hidden -mt-6 mb-2 flex justify-end">
                <button @click="openFilter = !openFilter" class="text-white py-2 px-2 rounded-md">
                    <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-width="2" d="M18.796 4H5.204a1 1 0 0 0-.753 1.659l5.302 6.058a1 1 0 0 1 .247.659v4.874a.5.5 0 0 0 .2.4l3 2.25a.5.5 0 0 0 .8-.4v-7.124a1 1 0 0 1 .247-.659l5.302-6.059c.566-.646.106-1.658-.753-1.658Z" />
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
                            <input type="search" x-model="kategori" @input="search()" class="block w-full ps-10 mobile:ps-4 text-sm mobile:text-[10px] bg-body text-gray-900 border-0 rounded-md focus:ring-0 focus:border-b focus:border-zinc-700" placeholder="Kategori..." required />
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
                    <input type="search" x-model="kategori" @keyup="search()" class="block w-full ps-10 bg-body text-sm text-gray-900 border-0 focus:ring-0 focus:border-b focus:border-zinc-700" placeholder="Kategori..." required />
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 mb-2 text-gray-500 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" x-model="namabarang" @keyup="search()" class="block w-full ps-10 bg-body text-sm text-gray-900 border-0 focus:ring-0 focus:border-b focus:border-zinc-700" placeholder="Nama barang..." required />
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 mb-2 text-gray-500 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" x-model="seri" @keyup="search()" class="block w-full ps-10 bg-body text-sm text-gray-900 border-0 focus:ring-0 focus:border-b focus:border-zinc-700" placeholder="Seri ..." required />
                </div>
                <div class="flex justify-between">
                    <button @click="resetFilter()" class="hidden md:block bg-gray-500 text-white py-1 px-2 ml-2 h-9 text-xs rounded-md hover:bg-gray-600" title="Reset Filter">
                        Reset
                    </button>
                </div>
                <div class="flex items-center relative ml-2 mobile:hidden tablet:hidden" x-data="barcodeScannerApp()" x-init="initScanner()">
                    <div class="flex items-center space-x-4" title="Tombol Scanner">
                        <!-- Toggle Button -->
                        <button
                            @click.prevent="toggleScanner"
                            :class="scannerActive ? 'bg-green-500' : 'bg-orange-500'"
                            class="relative inline-flex items-center justify-center w-16 h-9 mb-3 rounded-full transition-all duration-300 focus:outline-none">

                            <span
                                :class="scannerActive ? 'translate-x-8 bg-white' : 'translate-x-2 bg-gray-200'"
                                class="absolute left-0 w-6 h-6 rounded-full transform transition-transform duration-300 shadow-md flex items-center justify-center">

                                <!-- Ikon berdasarkan status scanner -->
                                <template x-if="scannerActive">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="w-4 h-4 text-gray-800">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7v-1a2 2 0 0 1 2 -2h2" />
                                        <path d="M4 17v1a2 2 0 0 0 2 2h2" />
                                        <path d="M16 4h2a2 2 0 0 1 2 2v1" />
                                        <path d="M16 20h2a2 2 0 0 0 2 -2v-1" />
                                        <path d="M5 12l14 0" />
                                    </svg>
                                </template>

                                <template x-if="!scannerActive">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="w-4 h-4 text-gray-800">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7v-1c0 -.552 .224 -1.052 .586 -1.414" />
                                        <path d="M4 17v1a2 2 0 0 0 2 2h2" />
                                        <path d="M16 4h2a2 2 0 0 1 2 2v1" />
                                        <path d="M16 20h2c.551 0 1.05 -.223 1.412 -.584" />
                                        <path d="M5 11h1v2h-1z" />
                                        <path d="M10 11v2" />
                                        <path d="M15 11v.01" />
                                        <path d="M19 11v2" />
                                        <path d="M3 3l18 18" />
                                    </svg>
                                </template>
                            </span>

                            <!-- Menghilangkan teks yang tidak diperlukan -->
                            <span class="sr-only" x-text="scannerActive ? 'Matikan Scanner' : 'Aktifkan Scanner'"></span>
                        </button>
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
                }" class="overflow-x-auto shadow-md rounded-t-lg overscroll-none transition-shadow duration-200 ease-in-out shadow hover:shadow-2xl hover:shadow-header-2">
                <table class="w-full text-left rtl:text-right font-roboto">
                    <thead class="text-sm mobile:text-xs uppercase whitespace-nowrap bg-header-2 bg-opacity-40 text-center text-gray-500 shadow-inner">
                        <tr>
                            <th scope="col" class="px-6 py-4">
                                Kode
                            </th>
                            <th scope="col" class="px-6 py-4">
                                Kategori
                            </th>
                            <th scope="col" class="px-6 py-4">
                                Nama Barang
                            </th>
                            <th scope="col" class="px-6 py-4">
                                Seri
                            </th>
                            <th scope="col" class="px-6 py-4">
                                Jumlah
                            </th>
                            <th scope="col" class="px-6 py-4">
                                Foto
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="item in results" :key="item.id">
                            <tr class="odd:bg-odd-2 even:bg-even-2 whitespace-nowrap border-6 border-b border-gray-300 mobile:text-xs laptop:text-sm hover:bg-gray-200 cursor-pointer transition-colors duration-300 ease-in-out">
                                <td class="px-6 py-4 truncate" x-text="item.kode_barang"></td>
                                <td class="px-6 py-4 truncate" x-text="item.kategori"></td>
                                <td class="px-6 py-4 truncate" x-text="item.nama_barang"></td>
                                <td class="px-6 py-4 truncate" x-text="item.seri"></td>
                                <td class="px-6 py-4 truncate">
                                    <span>
                                        <template x-if="item.satuan === 'roll'">
                                            <span x-text="item.hasil + ' meter'"></span>
                                        </template>
                                        <template x-if="item.satuan === 'pack'">
                                            <span x-text="item.hasil + ' pcs'"></span>
                                        </template>
                                        <template x-if="item.satuan !== 'roll' && item.satuan !== 'pack'">
                                            <span x-text="item.jumlah"></span>
                                        </template>
                                    </span>
                                </td>
                                <td class="px-6 py-4 truncate">
                                    <div x-data="{ open: false }">
                                        <button x-on:click="open = ! open" class="no-underline hover:underline w-[70px] text-blue-400">Lihat Foto</button>
                                        <div x-show="open" x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0 transform scale-90"
                                            x-transition:enter-end="opacity-100 transform scale-100"
                                            x-transition:leave="transition ease-in duration-200"
                                            x-transition:leave-start="opacity-100 transform scale-100"
                                            x-transition:leave-end="opacity-0 transform scale-90"
                                            tabindex="-1" @keydown.escape.window="open = false" @click.self="open = false" class="fixed inset-0 z-50 flex items-center justify-center w-full h-screen">
                                            <div class="relative w-full max-w-[300px] max-h-full rounded-lg bg-zinc-700 shadow-[0px_50px_60px_20px_rgba(0,0,0,0.3)]">
                                                <div class="flex items-center justify-between p-2 border-b rounded-t border-gray-600">
                                                    <button type="button" x-on:click="open = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center hover:bg-gray-600 hover:text-white">
                                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="md:p-4 w-full flex items-center justify-center shadow">
                                                    <img :src="`/storage/${item.foto}`" width="200" height="100">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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


        @php
        $item = $order->first(fn($item) => $item->username === Auth::user()->username);
        @endphp

        @if ($item)
        <form id="order" action="{{ route('barangkeluar.store') }}" method="POST" enctype="multipart/form-data" class="w-full mx-auto mt-16 bg-white p-6 rounded-lg shadow-md">
            @csrf

            <h2 class="text-3xl font-bold text-gray-800 border-b pb-4 mb-6">Order</h2>

            <div class="grid lg:grid-cols-2 gap-8">
                <!-- Ringkasan Pesanan -->
                <div>
                    <h3 class="text-xl font-semibold mb-4">Ringkasan Pesanan</h3>
                    <div class="space-y-4">
                        @foreach ($order as $item)
                        <div class="flex items-center gap-4 p-4 border rounded-lg shadow-sm bg-gray-50">
                            <img class="h-24 w-24 rounded-md border object-cover" src="{{ asset('storage/' . $item->foto) }}" />
                            <div class="flex flex-col flex-1">
                                <span class="font-medium text-gray-800">{{$item->nama_barang}} - {{$item->seri}}</span>
                                <span class="text-sm text-gray-500">Stok: {{$item->stok}}</span>
                                <span class="text-gray-600 font-bold">{{$item->lokasi}}</span>
                                <div class="mt-2 flex items-center space-x-2">
                                    <span class="text-gray-600">Jumlah:</span>
                                    @if ($item->satuan === 'unit' || $item->satuan === 'pcs')
                                    <span class="text-gray-800 font-semibold">1</span>
                                    <input type="hidden" name="jumlah[{{ $item->id }}]" value="1" />
                                    @else
                                    <input type="number" name="jumlah[{{ $item->id }}]" value="1" min="1" max="{{ $item->stok }}" class="w-16 text-center border rounded-md py-1" />
                                    @endif
                                </div>
                            </div>
                            <a href="{{ url('/hapus_order/' . $item->qr_code) }}" class="text-red-500 hover:text-red-700">
                                &#10005;
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Konfirmasi Proses -->
                <div class="p-6 bg-gray-50 rounded-lg shadow-sm">
                    <h3 class="text-xl font-semibold mb-4">Konfirmasi Proses</h3>
                    <p class="text-sm text-gray-600 mb-4">Pastikan untuk mengisi informasi dengan benar.</p>

                    <label class="block font-medium text-sm mb-1">Nama Customer</label>
                    <div class="flex gap-2">
                        <input type="text" placeholder="ID" name="ID" class="w-1/3 border rounded-md px-3 py-2" />
                        <input type="text" placeholder="Nama Customer" name="namacustomer" class="w-2/3 border rounded-md px-3 py-2" />
                    </div>

                    <label class="block font-medium text-sm mt-4 mb-1">Alamat</label>
                    <input type="text" name="lokasi" class="w-full border rounded-md px-3 py-2" placeholder="Alamat lengkap" />

                    <label class="block font-medium text-sm mt-4 mb-1">Keterangan (opsional)</label>
                    <textarea name="keterangan" rows="3" class="w-full border rounded-md px-3 py-2" placeholder="Tambahkan catatan jika perlu..."></textarea>

                    <button type="submit" class="mt-6 w-full bg-zinc-900 hover:bg-zinc-700 text-white font-semibold py-3 rounded-md transition">Place Order</button>
                </div>
            </div>
        </form>
    </div>
    @endif

    @if (session('success'))
    <div x-data="{ isOpen: true }" x-init="setTimeout(() => isOpen = false, 2000)">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js" integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function searchApp() {
            return {
                kategori: '',
                namabarang: '',
                seri: '',
                results: [],
                search() {
                    // Jika pencarian kosong, kosongkan hasil
                    if (this.kategori === '' && this.namabarang === '' && this.seri === '') {
                        this.results = [];
                        return;
                    }

                    // Ambil data dari server berdasarkan input pencarian
                    fetch(`/search/barangmasuk?kategori=${this.kategori}&namabarang=${this.namabarang}&seri=${this.seri}`)
                        .then(response => response.json())
                        .then(data => {
                            this.results = data;
                        });
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

        function quantityInput(maxQuantity, satuan) {
            return {
                quantity: 1, // Default starting quantity is 1
                maxQuantity: maxQuantity, // Max quantity is 1 for unit and pcs

                increment() {
                    if (this.quantity < this.maxQuantity) {
                        this.quantity++;
                    }
                },
                decrement() {
                    if (this.quantity > 0) {
                        this.quantity--;
                    }
                }
            };
        }


        function barcodeScannerApp() {
            return {
                barcode: '',
                scannerActive: false,
                scannerActive: JSON.parse(localStorage.getItem('scannerActive')) || false,
                captureBarcodeListener: null,


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

                // Fungsi untuk mengaktifkan scanner
                activateScanner() {
                    this.scannerActive = true;
                    this.barcode = '';
                    this.captureBarcodeListener = (event) => this.captureBarcode(event);
                    window.addEventListener('keydown', this.captureBarcodeListener);
                    localStorage.setItem('scannerActive', JSON.stringify(this.scannerActive));
                },

                // Fungsi untuk menangkap input barcode
                captureBarcode(event) {
                    if (this.scannerActive === false) return; // Jika scanner tidak aktif, hentikan
                    if (event.key === 'Enter') {
                        this.submitForm();
                        this.barcode = '';
                    } else {
                        // Tambahkan karakter ke barcode setiap kali tombol ditekan
                        this.barcode += event.key;
                        console.log(this.barcode);
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

                // Fungsi untuk mengirim form dengan fetch
                async submitForm() {
                    try {
                        const response = await fetch(`/order/${this.barcode}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });

                        if (response.ok) {
                            location.reload();
                        } else {
                            alert('Barcode tidak terdaftar dalam sistem.'); // Tetap arahkan walau error
                        }
                    } catch (error) {
                        alert('Terjadi kesalahan pada jaringan atau server.');
                        location.href = "{{ route('input_barang_keluar') }}";
                    }
                }
            }
        }




        // Variabel untuk mencegah scanning berulang
        let isProcessing = false;

        async function onScanSuccess(decodedText) {
            // Cek jika sedang memproses atau barcode kosong
            if (isProcessing || decodedText.trim() === '') {
                return;
            }

            // Set status menjadi sedang memproses
            isProcessing = true;

            try {
                // Kirim hasil barcode ke server menggunakan fetch
                const response = await fetch(`/order/${decodedText}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

                if (response.ok) {
                    // Jika berhasil, arahkan ke route input_barang_keluar
                    location.href = "{{ route('input_barang_keluar') }}";
                } else {
                    console.log(response);
                }
            } catch (error) {
                console.log(error);
            }

            // Reset status setelah beberapa detik (misalnya 3 detik)
            setTimeout(() => {
                isProcessing = false;
            }, 3000);
        }

        let qrboxSize;

        if (window.innerWidth < 640) { // Mobile
            qrboxSize = {
                width: 130,
                height: 130
            };
        } else if (window.innerWidth < 1024) { // Tablet
            qrboxSize = {
                width: 250,
                height: 250
            };
        }

        const html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 60,
                qrbox: qrboxSize,
                supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA],
            }
        );
        // Render scanner dengan fungsi onScanSuccess
        html5QrcodeScanner.render(onScanSuccess);
    </script>
</x-sidebar-layout>