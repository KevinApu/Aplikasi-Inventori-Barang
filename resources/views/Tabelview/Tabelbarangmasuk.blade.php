<x-sidebar-layout>
    <div class="container mx-auto px-4 max-w-full">

        <div class="mb-6">
            <h1 class="text-2xl font-semibold font-heading text-gray-500">Data Barang Masuk</h1>
        </div>

        <div x-data="searchApp()" x-init="search(); initializeQrScanner()" class="relative mt-12 bottom-8">
            <div id="reader"
                class="mx-auto hidden mobile:block tablet:block tablet:mb-2
            bg-white border border-gray-300 rounded-lg shadow-lg 
            overflow-hidden relative">
            </div>

            <div x-data="{ openFilter: false }" class="md:hidden -mt-2 mb-2 flex justify-end">
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
                        <div class="relative" x-data="{ selectedYear: null }">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 mobile:pl-1 pointer-events-none">
                                <svg class="w-4 h-4 mobile:w-2 mobile:h-2 mb-2 mobile:mb-3 text-gray-500 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>

                            <select x-model="tahun" @change="search()" class="block w-full rounded-md pl-10 mobile:pl-5 bg-body text-sm mobile:text-[10px] text-gray-900 border-0 focus:ring-0 focus:border-b focus:border-zinc-700" required>
                                <option value="" class="bg-gray-400 hover:bg-gray-300" selected>Pilih Tahun...</option>
                                <template x-for="year in Array.from({ length: 10 }, (_, i) => new Date().getFullYear() - i)" :key="year">
                                    <option :value="year" x-text="year"></option>
                                </template>
                            </select>
                        </div>
                        <div class="relative" x-data="{ bulan: null }">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 mobile:pl-1 pointer-events-none">
                                <svg class="w-4 h-4 mobile:w-2 mobile:h-2 mb-2 mobile:mb-3 text-gray-500 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>

                            <select x-model="bulan" @change="search()" class="block w-full pl-10 mobile:pl-5 bg-body text-sm mobile:text-[10px] rounded-md text-gray-900 border-0 focus:ring-0 focus:border-b focus:border-zinc-700" required>
                                <option value="" class="bg-gray-400 hover:bg-gray-300" selected>Pilih Bulan...</option>
                                <template x-for="(month, index) in ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']" :key="index">
                                    <option :value="index + 1" x-text="month"></option>
                                </template>
                            </select>
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
                <div>
                    <a href="{{ route('view.laporan') }}" class="block py-1 mobile:py-2 transform transition-transform duration-200 hover:scale-110" title="Print Laporan">
                        <svg class="w-6 h-6 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M16.444 18H19a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h2.556M17 11V5a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v6h10ZM7 15h10v4a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-4Z" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="hidden md:flex justify-start h-12">
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
                    <input type="search" x-model="namabarang" @input="search()" class="block w-full ps-10 mobile:ps-4 bg-body text-sm mobile:text-[10px] text-gray-900 border-0 focus:ring-0 focus:border-b focus:border-zinc-700" placeholder="Nama barang..." required />
                </div>
                <div class="relative" x-data="{ selectedYear: null }">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 mobile:pl-1 pointer-events-none">
                        <svg class="w-4 h-4 mobile:w-2 mobile:h-2 mb-2 mobile:mb-3 text-gray-500 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>

                    <select x-model="tahun" @change="search()" class="block w-full pl-10 mobile:pl-5 bg-body text-sm mobile:text-[10px] text-gray-900 border-0 focus:ring-0 focus:border-b focus:border-zinc-700" required>
                        <option value="" class="bg-gray-400 hover:bg-gray-300" selected>Pilih Tahun...</option>
                        <template x-for="year in Array.from({ length: 10 }, (_, i) => new Date().getFullYear() - i)" :key="year">
                            <option :value="year" x-text="year"></option>
                        </template>
                    </select>
                </div>
                <div class="relative" x-data="{ bulan: null }">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 mobile:pl-1 pointer-events-none">
                        <svg class="w-4 h-4 mobile:w-2 mobile:h-2 mb-2 mobile:mb-3 text-gray-500 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>

                    <select x-model="bulan" @change="search()" class="block w-full pl-10 mobile:pl-5 bg-body text-sm mobile:text-[10px] rounded-r-md text-gray-900 border-0 focus:ring-0 focus:border-b focus:border-zinc-700" required>
                        <option value="" class="bg-gray-400 hover:bg-gray-300" selected>Pilih Bulan...</option>
                        <template x-for="(month, index) in ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']" :key="index">
                            <option :value="index + 1" x-text="month"></option>
                        </template>
                    </select>
                </div>
                <div class="flex justify-between">
                    <button @click="resetFilter()" class="hidden md:block bg-gray-500 text-white py-1 px-2 ml-2 h-9 text-xs rounded-md hover:bg-gray-600" title="Reset Filter">
                        Reset
                    </button>
                </div>
                <div class="relative mobile:hidden tablet:hidden">
                    <div class="flex items-center">
                        <div class="flex items-center ml-2 space-x-4" title="Tombol Scanner">
                            <!-- Toggle Button -->
                            <button
                                @click.prevent="toggleScanner; showNotification()"
                                :class="scannerActive ? 'bg-green-500' : 'bg-orange-500'"
                                class="relative inline-flex items-center justify-center w-16 h-9 rounded-full transition-all duration-300 focus:outline-none">

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


                    <!-- Modal Notifikasi -->
                    <div
                        x-show="notificationVisible"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-90"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-90"
                        @click.away="notificationVisible = false"
                        class="fixed inset-0 flex items-center justify-center z-50">
                        <div class="bg-white border border-yellow-400 p-6 rounded-lg shadow-md w-11/12 max-w-xs text-center relative">
                            <!-- Header -->
                            <h2 class="text-lg font-semibold text-gray-800 mb-3">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-yellow-400 rounded-full text-white mr-2">
                                    ⚠️
                                </span>
                                Perhatian!
                            </h2>
                            <!-- Isi Pesan -->
                            <p class="text-gray-700 text-sm mb-4">
                                Pastikan Anda hanya menggunakan <span class="font-semibold text-gray-800">barcode yang dibuat melalui website ini</span>.
                                Barcode bawaan pada kemasan barang mungkin tidak dapat diproses oleh sistem.
                            </p>
                            <!-- Tombol -->
                            <button
                                @click="notificationVisible = false"
                                type="button"
                                class="bg-yellow-400 text-white text-sm font-semibold px-4 py-2 rounded-md hover:bg-yellow-500 transition duration-300 focus:outline-none transform hover:scale-105">
                                Mengerti
                            </button>
                        </div>
                    </div>
                </div>
                <div class="relative">
                    <a href="{{ route('view.laporan') }}" class="ml-2 block py-1 mobile:py-2 transform transition-transform duration-200 hover:scale-110" title="Print Laporan">
                        <svg class="w-8 h-8 mobile:w-4 mobile:h-4 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linejoin="round" stroke-width="2" d="M16.444 18H19a1 1 0 0 0 1-1v-5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h2.556M17 11V5a1 1 0 0 0-1-1H8a1 1 0 0 0-1 1v6h10ZM7 15h10v4a1 1 0 0 1-1 1H8a1 1 0 0 1-1-1v-4Z" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto shadow-md rounded-t-lg overscroll-x-none transition-shadow duration-900 ease-in-out shadow hover:shadow-2xl hover:shadow-header-1">
                <table class="w-full text-left rtl:text-right font-roboto">
                    <thead class="text-sm mobile:text-xs uppercase whitespace-nowrap bg-header-1 text-center bg-opacity-30 text-gray-500 shadow-inner">
                        <tr>
                            <th scope="col" class="px-1 py-3" x-show="paginatedResults.length > 0">
                                <input type="checkbox"
                                    x-model="allChecked"
                                    @change="toggleAll()"
                                    class="w-4 h-4 cursor-pointer rounded-md mr-2 hover:border-indigo-500 hover:bg-indigo-100 checked:bg-indigo-500 checked:border-indigo-500 checked:text-indigo-500 focus:ring-0 focus:border-0">
                            </th>
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
                            <th scope="col" class="px-6 py-3">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="item in paginatedResults" :key="item.id">
                            <tr class="odd:odd-1 even:bg-even-1 whitespace-nowrap border-6 border-b border-gray-300 mobile:text-xs laptop:text-sm hover:bg-gray-200 cursor-pointer transition-colors duration-300 ease-in-out">
                                <td class="px-6 py-3 text-center">
                                    <input type="checkbox" :value="item.id" :checked="isChecked(item.id)" @change="toggleCheckbox(item.id)"
                                        class="w-4 h-4  cursor-pointer rounded-md mr-2 hover:border-indigo-500 hover:bg-indigo-100 checked:bg-indigo-500 checked:border-indigo-500 checked:text-indigo-500 focus:ring-0 focus:border-0">
                                </td>
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
                                            <div class="relative w-full max-w-[300px] mobile:max-w-[200px] rounded-lg bg-zinc-700 shadow-[0px_50px_60px_20px_rgba(0,0,0,0.3)]">
                                                <!-- Modal header -->
                                                <div class="flex items-center p-1 justify-between border-b rounded-t border-gray-600">
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
                                <td class="px-14 py-3">
                                    <div class="flex space-x-2">
                                        <!-- Pop Up Update -->
                                        <div x-data="{ open: false }">
                                            <button class="text-blue-500 hover:text-blue-700 border border-blue-500 p-1 rounded" x-on:click="open = ! open">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m6 0a6 6 0 11-6-6 6 6 0 016 6z" />
                                                </svg>
                                            </button>

                                            <!-- Form Update -->
                                            <div x-show="open" @keydown.escape.window="open = false" @click.self="open = false" tabindex="-1" aria-hidden="true" class="bg-black bg-opacity-70 fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full"
                                                x-transition:enter="transition-opacity ease-out duration-300"
                                                x-transition:enter-start="opacity-0"
                                                x-transition:enter-end="opacity-100"
                                                x-transition:leave="transition-opacity ease-in duration-200"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0">
                                                <div class="relative p-4 w-full max-w-md max-h-full">
                                                    <!-- Modal content -->
                                                    <div class="relative bg-white rounded-lg shadow">
                                                        <!-- Modal header -->
                                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-300">
                                                            <h3 class="text-lg font-semibold text-gray-900">
                                                                Edit Product
                                                            </h3>

                                                            <!-- Button Close -->
                                                            <button type="button" x-on:click="open = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                                </svg>
                                                            </button>
                                                        </div>


                                                        <!-- Modal body -->
                                                        <form class="p-4 md:p-5" method="POST" x-bind:action="`/update_barang_masuk/${item.id}`" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="grid gap-4 mb-4 grid-cols-2">
                                                                <div class="col-span-2">
                                                                    <label class="block mb-2 text-sm font-medium text-gray-700">Nama Barang</label>
                                                                    <input type="text" name="namabarang" x-model="item.nama_barang" class="border-0 focus:ring-0 border-b bg-transparent w-full text-gray-900" required="">
                                                                </div>
                                                                <div class="col-span-2 sm:col-span-1">
                                                                    <label class="block mb-2 text-sm font-medium text-gray-700">Kode Barang</label>
                                                                    <input type="text" name="kodebarang" x-model="item.kode_barang" class="border-0 focus:ring-0 border-b bg-transparent w-full text-gray-900" required="">
                                                                </div>
                                                                <div class="col-span-2 sm:col-span-1">
                                                                    <label class="block mb-2 text-sm font-medium text-gray-700">Seri</label>
                                                                    <input type="text" name="seri" x-model="item.seri" class="border-0 focus:ring-0 border-b bg-transparent w-full text-gray-900" required="">
                                                                </div>
                                                                <div class="col-span-2 sm:col-span-1">
                                                                    <label class="block mb-2 text-sm font-medium text-gray-700">Lokasi</label>
                                                                    <input type="text" name="lokasi" x-model="item.lokasi" class="border-0 focus:ring-0 border-b bg-transparent w-full text-gray-900 text-gray-900" required="">
                                                                </div>
                                                                <div class="col-span-2 sm:col-span-1">
                                                                    <label class="block mb-2 text-sm font-medium text-gray-700">Keterangan</label>
                                                                    <textarea type="text" name="keterangan" x-model="item.keterangan" class="border-0 focus:ring-0 border-b bg-transparent w-full text-gray-900"></textarea>
                                                                </div>
                                                                <div class="col-span-2">
                                                                    <label class="block mb-2 text-sm font-medium text-gray-700">Foto (opsional)</label>
                                                                    <input class="border-0 focus:ring-0 border-b bg-transparent w-full p-2 text-gray-900" name="foto" type="file">
                                                                </div>
                                                            </div>
                                                            <!-- Button -->
                                                            <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-800">
                                                                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                                                </svg>
                                                                Update
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Form Update -->


                                        <!-- Pop up tambah stok -->
                                        <div x-data="{ open: false }">
                                            <button class="text-blue-500 hover:text-blue-700 border border-blue-500 p-1 rounded" x-on:click="open = ! open">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                                </svg>
                                            </button>

                                            <!-- Form Update -->
                                            <div x-show="open" @keydown.escape.window="open = false" @click.self="open = false" tabindex="-1" aria-hidden="true" class="fixed top-0 right-0 left-0 z-50 flex justify-center w-full h-full bg-black bg-opacity-70"
                                                x-transition:enter="transition-opacity ease-out duration-300"
                                                x-transition:enter-start="opacity-0"
                                                x-transition:enter-end="opacity-100"
                                                x-transition:leave="transition-opacity ease-in duration-200"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0">
                                                <div class="relative p-4 w-full max-w-md max-h-full">
                                                    <!-- Modal content -->
                                                    <div class="relative rounded-lg shadow bg-white">
                                                        <!-- Modal header -->
                                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-300">
                                                            <h3 class="text-lg font-semibold text-gray-900">
                                                                Add Stock
                                                            </h3>
                                                            <!-- Button Close -->
                                                            <button type="button" x-on:click="open = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <form class="p-4 md:p-5" method="POST" x-bind:action="`/penambahan_stok/${item.id}`">
                                                            @csrf
                                                            <div class="grid gap-4 mb-4 grid-cols-2">
                                                                <div class="col-span-2">
                                                                    <input type="number" name="jumlah" oninput="this.value = this.value.replace(/[^0-9]/g, '');" min="1" class="border-0 focus:ring-0 border-b bg-transparent w-full text-gray-900" required="">
                                                                </div>
                                                            </div>

                                                            <!-- Button -->
                                                            <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-800">
                                                                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                                                </svg>
                                                                Add
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Pop up tambah stok -->
                                        <!-- Pop up Barang Rusak -->
                                        <div x-data="{ open: false }">
                                            <button x-on:click="open = ! open" x-show="item.satuan !== 'roll' && item.satuan !== 'pack'">
                                                <svg class="h-8 w-8 text-red-500 border border-red-500 p-1 rounded" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2" />
                                                    <line x1="12" y1="8" x2="12" y2="12" />
                                                    <line x1="12" y1="16" x2="12.01" y2="16" />
                                                </svg>
                                            </button>

                                            <!-- Main modal -->
                                            <div x-show="open" @keydown.escape.window="open = false" @click.self="open = false" tabindex="-1" aria-hidden="true" class="fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-full bg-black bg-opacity-70"
                                                x-transition:enter="transition-opacity ease-out duration-300"
                                                x-transition:enter-start="opacity-0"
                                                x-transition:enter-end="opacity-100"
                                                x-transition:leave="transition-opacity ease-in duration-200"
                                                x-transition:leave-start="opacity-100"
                                                x-transition:leave-end="opacity-0">
                                                <div class="relative p-4 w-full max-w-md max-h-full">
                                                    <!-- Modal content -->
                                                    <div class="relative bg-white rounded-lg shadow">
                                                        <!-- Modal header -->
                                                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-300">
                                                            <h3 class="text-lg font-semibold text-gray-900">
                                                                Infromasi Kerusakan
                                                            </h3>
                                                            <button type="button" x-on:click="open = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <!-- Modal body -->
                                                        <form class="p-4 md:p-5" method="POST" x-bind:action="`/input_barang_rusak/${item.id}`" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="grid gap-4 mb-4 grid-cols-2">
                                                                <div class="col-span-2">
                                                                    <label class="block mb-2 text-sm font-medium text-gray-900">Kondisi Barang</label>
                                                                    <textarea name="kondisi" rows="1" class="border-0 focus:ring-0 border-b bg-transparent w-full text-gray-900" placeholder="Kondisi Barang" required=""></textarea>
                                                                </div>
                                                                <div class="col-span-2">
                                                                    <label class="block mb-2 text-sm font-medium text-gray-900">Penyebeb Kerusakan</label>
                                                                    <textarea name="penyebab" rows="1" class="border-0 focus:ring-0 border-b bg-transparent w-full text-gray-900" placeholder="Penyebeb Kerusakan" required=""></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-span-2 sm:col-span-1">
                                                                <label for="jumlah" class="block mb-2 text-sm font-medium text-gray-900">Jumlah</label>
                                                                <input type="number"
                                                                    name="jumlah"
                                                                    class="border-0 focus:ring-0 border-b bg-transparent w-full text-gray-900"
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');" min="1"
                                                                    x-bind:max="item.jumlah" required="" />
                                                            </div>
                                                            <div class="col-span-2 sm:col-span-1">
                                                                <label class="block mb-2 mt-4 text-sm font-medium text-gray-900">Foto</label>
                                                                <input type="file" name="foto" class="border-0 focus:ring-0 border-b bg-transparent w-full text-gray-900 p-2" required="">
                                                            </div>
                                                            <button type="submit" class="mt-4 text-white inline-flex items-center font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-blue-600 hover:bg-blue-700">
                                                                <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                                                </svg>
                                                                Add
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Pop up Barang Rusak -->
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
                <div class="absolute z-50 flex justify-end left-auto right-16 mobile:right-8 bottom-0">
                    <!-- Modal Pop-up -->
                    <div x-show="showPrintPopup" x-cloak
                        x-transition:enter="transition transform duration-300"
                        x-transition:enter-start="translate-y-full scale-50 opacity-0"
                        x-transition:enter-end="translate-y-0 scale-100 opacity-100"
                        x-transition:leave="transition transform duration-300"
                        x-transition:leave-start="translate-y-0 scale-100 opacity-100"
                        x-transition:leave-end="translate-y-full scale-50 opacity-0"
                        class="flex items-center space-x-6 p-4 w-[25rem] mobile:w-[15rem] h-10 bg-white shadow-md rounded-md">
                        <div class="flex items-center space-x-2 mobile:space-x-1 mobile:w-full">
                            <input type="checkbox" class="w-5 h-5 mobile:w-4 mobile:h-4 cursor-pointer rounded-md mr-2 checked:bg-indigo-500 focus:ring-0 focus:border-0" checked disabled>
                            <span class="text-gray-700" x-text="`${checkedItems.length} Items`"></span>
                        </div>
                        <div x-data="{ isLoading: false }">
                            <!-- Tombol untuk memulai proses -->
                            <div class="flex items-center space-x-2 cursor-pointer hover:scale-110 duration-300" @click="startPrint" title="Print Barcode">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2V10a2 2 0 012-2h16a2 2 0 012 2v6a2 2 0 01-2 2h-2M6 14h0M10 14h0M14 14h0M14 18h6v4H4v-4h2" />
                                </svg>
                                <span class="text-gray-700 mobile:hidden">Print Qr Code</span>
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
                        <div class="flex items-center space-x-2 cursor-pointer hover:scale-110 duration-300" @click="deleteSelectedItems" title="Remove Items">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7L5 7M10 11V17M14 11V17M7 7L7 19A2 2 0 009 21H15A2 2 0 0017 19V7M9 7V4A2 2 0 0111 2H13A2 2 0 0115 4V7" />
                            </svg>
                            <span class="text-gray-700 mobile:hidden">Remove</span>
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

    @if (session('success_update'))
    <!-- Main modal -->
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
                    {{ session('success_update') }}
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
    @if (session('success_addstock'))
    <!-- Main modal -->
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
                    {{ session('success_addstock') }}
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
    @if (session('success_rusak'))
    <!-- Main modal -->
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
    @if (session('success_hapus'))
    <!-- Main modal -->
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
                    {{ session('success_hapus') }}
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js" integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function searchApp() {
            return {
                kategori: '',
                namabarang: '',
                seri: '',
                tahun: '',
                bulan: '',
                results: [],
                currentPage: 1,
                perPage: 10,
                defaultPerPage: 10,
                checkedItems: [],
                showPrintPopup: false,
                allChecked: false,
                barcode: '',
                scannerActive: false,
                scannerActive: JSON.parse(localStorage.getItem('scannerActive')) || false,
                notificationVisible: false,
                isProcessing: false,

                get totalPages() {
                    return this.perPage ? Math.ceil(this.results.length / this.perPage) : 1;
                },

                get paginatedResults() {
                    if (!this.perPage) return this.results;
                    const start = (this.currentPage - 1) * this.perPage;
                    const end = start + this.perPage;
                    return this.results.slice(start, end);
                },

                search() {
                    // Ambil data dari server
                    fetch(`/search/barangmasuk?kategori=${this.kategori}&namabarang=${this.namabarang}&seri=${this.seri}&tahun=${this.tahun}&bulan=${this.bulan}`)
                        .then(response => response.json())
                        .then(data => {
                            this.results = data;
                            this.checkedItems = []; // Reset checkedItems setiap kali pencarian baru
                            this.allChecked = false; // Reset status checkbox utama
                        });
                },




                toggleAll() {
                    // Update checkedItems hanya dengan satu loop
                    this.checkedItems = this.allChecked ? this.results.map(item => item.id) : [];

                    // Tampilkan pop-up jika ada item yang dipilih
                    this.showPrintPopup = this.checkedItems.length > 0;
                    this.showPrintPopup = this.allChecked;
                },



                toggleCheckbox(id) {
                    if (this.checkedItems.includes(id)) {
                        this.checkedItems = this.checkedItems.filter(item => item !== id);
                    } else {
                        this.checkedItems.push(id);
                    }
                    // Tampilkan pop-up jika ada item yang dipilih
                    this.showPrintPopup = this.checkedItems.length > 0;
                    // Update status checkbox utama
                    this.allChecked = this.checkedItems.length === this.results.length;
                },

                isChecked(id) {
                    return this.checkedItems.includes(id);
                },

                deleteSelectedItems() {
                    this.checkedItems.forEach(itemId => {
                        fetch(`/tabel_barang_masuk.delete/${itemId}`, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        }).then(response => {
                            if (response.ok) {
                                console.log(`Item ${itemId} berhasil dihapus.`);
                            } else {
                                console.error(`Gagal menghapus item ${itemId}.`);
                            }
                        });
                    });
                    this.checkedItems = []; // Kosongkan setelah dihapus
                    this.showPrintPopup = false; // Sembunyikan pop-up setelah menghapus
                    this.search(); // Update hasil pencarian setelah penghapusan
                    location.reload();
                },


                startPrint() {
                    this.isLoading = true;
                    // Aktifkan loading

                    // Simulasi fetch API
                    fetch('/submitprint', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                itemIds: this.checkedItems
                            })
                        })
                        .then(response => {
                            if (response.ok) {
                                console.log('Data berhasil dikirim');
                                window.location.href = "{{ route('barcode') }}";
                            } else {
                                console.error('Gagal mengirim data');
                            }
                        })
                        .catch(error => console.error('Error:', error))
                        .finally(() => {
                            this.isLoading = false; // Matikan loading
                        });
                },

                resetFilter() {
                    this.kategori = '';
                    this.namabarang = '';
                    this.seri = '';
                    this.tahun = '';
                    this.bulan = '';
                    this.search(); // Panggil search untuk update tampilan setelah reset
                },

                applyFilter() {
                    this.search(); // Lakukan pencarian dengan filter
                    this.openFilter = false; // Tutup pop-up filter setelah submit
                },
                initScanner() {
                    // Ambil status scanner dari Local Storage, jika ada
                    const savedStatus = JSON.parse(localStorage.getItem('scannerActive'));
                    this.scannerActive = savedStatus || false; // Set scannerActive berdasarkan status tersimpan

                    if (this.scannerActive) {
                        this.activateScanner();
                    }
                },

                toggleScanner() {
                    if (this.scannerActive) {
                        this.deactivateScanner();
                    } else {
                        this.activateScanner();
                    }
                },

                showNotification() {
                    if (!this.scannerActive) {
                        this.notificationVisible = true;
                    }
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
                        this.handleEnterKey(event); // Panggil fungsi handleEnterKey saat Enter ditekan
                        this.barcode = '';
                    } else {
                        // Tambahkan karakter ke barcode setiap kali tombol ditekan
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

                // Fungsi untuk memeriksa barcode dari server
                checkBarcode() {
                    fetch(`/search/barangmasuk?id=${this.barcode}`)
                        .then(response => response.json())
                        .then(data => {
                            this.results = data;
                            this.checkedItems = []; // Reset checkedItems setiap kali pencarian baru
                            this.allChecked = false; // Reset status checkbox utama
                        });
                },

                // Fungsi ini akan dijalankan ketika tombol Enter ditekan
                handleEnterKey(event) {
                    event.preventDefault(); // Mencegah form submit
                    this.checkBarcode(); // Panggil fungsi checkBarcode untuk mencari barcode
                },

                async onScanSuccess(decodedText) {
                    // Cek jika sedang memproses atau barcode kosong
                    if (this.isProcessing || decodedText.trim() === '') {
                        return;
                    }

                    // Set status menjadi sedang memproses
                    this.isProcessing = true;

                    fetch(`/search/barangmasuk?id=${decodedText}`)
                        .then(response => response.json())
                        .then(data => {
                            this.results = data;
                            this.checkedItems = [];
                            this.allChecked = false;
                        });

                    setTimeout(() => {
                        this.isProcessing = false;
                    }, 3000);
                },

                initializeQrScanner() {
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
                    html5QrcodeScanner.render(this.onScanSuccess.bind(this));
                }
            }
        };
    </script>
</x-sidebar-layout>