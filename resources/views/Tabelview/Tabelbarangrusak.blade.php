<x-sidebar-layout>
    <div class="container mx-auto px-4 text-roboto">

        <div class="mb-6">
            <h1 class="text-2xl font-semibold font-heading text-gray-500">Data Barang Rusak</h1>
        </div>
        <div x-data="searchApp()" x-init="search(); initializeQrScanner()" class="relative mt-12 bottom-8">
            <div id="reader"
                class="mx-auto hidden mobile:block tablet:block tablet:mb-2
            bg-white border border-gray-300 rounded-lg shadow-lg 
            overflow-hidden relative">
            </div>

            <div x-data="{ openFilter: false }" class="md:hidden -mt-2 mb-2 flex justify-end">
                <button @click="openFilter = !openFilter" class="text-white py-2 px-4 rounded-md">
                    <svg class="w-6 h-6 text-gray-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
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
            </div>
            <div class="overflow-x-auto rounded-t-lg overscroll-x-none transition-shadow duration-200 ease-in-out shadow hover:shadow-2xl hover:shadow-header-3">
                <table class="w-full text-left rtl:text-right font-roboto">
                    <thead class="text-sm mobile:text-xs uppercase whitespace-nowrap bg-header-3 text-center bg-opacity-40 text-gray-600 shadow-inner">
                        <tr>
                            <th scope="col" class="px-1 py-3" x-show="paginatedResults.length > 0">
                                <input type="checkbox"
                                    x-model="allChecked"
                                    @change="toggleAll()"
                                    class="w-4 h-4 cursor-pointer rounded-md mr-2 hover:border-indigo-500 hover:bg-indigo-100 checked:bg-indigo-500 checked:border-indigo-500 checked:text-indigo-500 focus:ring-0 focus:border-0">
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Kode Barang
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
                                Foto
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Kondisi
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Penyebab
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Waktu
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Penginput
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        <template x-for="item in paginatedResults">
                            <tr class="odd:odd-3 even:bg-even-3 whitespace-nowrap border-6 border-b border-gray-300 mobile:text-xs laptop:text-sm hover:bg-gray-200 cursor-pointer transition-colors duration-300 ease-in-out">
                                <td class="px-6 py-3 text-center">
                                    <input type="checkbox"
                                        :value="`${item.id}/${item.nama_barang}/${item.penyebab}/${item.kondisi}`"
                                        :checked="isChecked(`${item.id}/${item.nama_barang}/${item.penyebab}/${item.kondisi}`)"
                                        @change="toggleCheckbox(`${item.id}/${item.nama_barang}/${item.penyebab}/${item.kondisi}`)"
                                        class="w-4 h-4 cursor-pointer rounded-md mr-2 hover:border-indigo-500 hover:bg-indigo-100 checked:bg-indigo-500 checked:border-indigo-500 checked:text-indigo-500 focus:ring-0 focus:border-0">
                                </td>
                                <th scope="row" class="px-6 py-3 font-medium whitespace-nowrap" x-text="item.kode_barang"></th>
                                <td class="px-6 py-3 truncate" x-text="item.kategori"></td>
                                <td class="px-6 py-3 truncate" x-text="item.nama_barang"></td>
                                <td class="px-6 py-3 truncate" x-text="item.seri"></td>
                                <td class="px-6 py-3 truncate" x-text="item.jumlah"></td>
                                <td class="px-6 py-3 truncate">
                                    <!-- Pop Up Lihat Foto -->
                                    <div x-data="{ open: false }">
                                        <button x-on:click="open = ! open" class="no-underline hover:underline w-[70px] text-blue-400">Lihat Foto</button>
                                        <div x-show="open"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0 transform scale-90"
                                            x-transition:enter-end="opacity-100 transform scale-100"
                                            x-transition:leave="transition ease-in duration-200"
                                            x-transition:leave-start="opacity-100 transform scale-100"
                                            x-transition:leave-end="opacity-0 transform scale-90"
                                            tabindex="-1" @keydown.escape.window="open = false" @click.self="open = false" class="fixed inset-0 z-50 flex items-center justify-center">
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
                                <td class="px-6 py-3 truncate" x-text="item.kondisi"></td>
                                <td class="px-6 py-3 truncate" x-text="item.penyebab"></td>
                                <td class="px-6 py-3 truncate" x-text="item.created_at"></td>
                                <td class="px-6 py-3 truncate" x-text="item.input_by"></td>
                                <td class="px-6 py-3 truncate">
                                    <template x-if="item.status === 'rusak_sebelum_penggunaan'">
                                        <div class="flex items-center justify-center border-b pb-2">
                                            <span class="px-4 py-1 bg-red-500 text-white rounded-full">Sebelum Penggunaan</span>
                                        </div>
                                    </template>
                                    <template x-if="item.status === 'rusak_sesudah_penggunaan'">
                                        <div class="flex items-center justify-center">
                                            <span class="px-4 py-1 bg-orange-500 text-white rounded-full">Sesudah Penggunaan</span>
                                        </div>
                                    </template>
                                </td>
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
                        class="flex items-center space-x-6 p-4 w-64 h-10 bg-white shadow-md rounded-md">
                        <div class="flex items-center space-x-2">
                            <input type="checkbox" class="w-5 h-5 cursor-pointer rounded-md mr-2 hover:border-indigo-500 hover:bg-indigo-100 checked:bg-indigo-500 checked:border-indigo-500 checked:text-indigo-500 focus:ring-0 focus:border-0" checked disabled>
                            <span class="text-gray-700" x-text="`${checkedItems.length} Items`"></span>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js" integrity="sha512-r6rDA7W6ZeQhvl8S7yRVQUKVHdexq+GAlNkNNqVC7YyIV+NwqCTJe2hDWCiffTyRNOeGEzRRJ9ifvRm/HCzGYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            function searchApp() {
                return {
                    kategori: '',
                    namabarang: '',
                    seri: '',
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
                        fetch(`/search/barangrusak?kategori=${this.kategori}&namabarang=${this.namabarang}&seri=${this.seri}`)
                            .then(response => response.json())
                            .then(data => {
                                this.results = data;
                            });
                    },

                    toggleAll() {
                        // Periksa apakah semua item dicentang
                        this.checkedItems = this.allChecked ?
                            this.results.map(item => `${item.id}/${item.nama_barang}/${item.penyebab}/${item.kondisi}`) : []; // Kosongkan jika allChecked adalah false

                        // Mengatur tampilan pop-up berdasarkan status allChecked
                        this.showPrintPopup = this.allChecked;
                    },


                    toggleCheckbox(itemValue) {
                        if (this.checkedItems.includes(itemValue)) {
                            this.checkedItems = this.checkedItems.filter(value => value !== itemValue);
                        } else {
                            this.checkedItems.push(itemValue);
                        }
                        // Tampilkan pop-up jika ada item yang dipilih
                        this.showPrintPopup = this.checkedItems.length > 0;
                        // Update status checkbox utama
                        this.allChecked = this.checkedItems.length === this.results.length;
                    },

                    isChecked(itemValue) {
                        return this.checkedItems.includes(itemValue);
                    },

                    deleteSelectedItems() {
                        this.checkedItems.forEach(itemValue => {
                            // Pisahkan itemValue menjadi bagian-bagian individual
                            const [itemId, nama_barang, penyebab, kondisi] = itemValue.split('/');

                            fetch(`/hapus_barang_rusak/${itemId}/${nama_barang}/${penyebab}/${kondisi}`, {
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
                        this.search();
                        location.reload(); // Update hasil pencarian setelah penghapusan
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

                    initScanner() {
                        const savedStatus = JSON.parse(localStorage.getItem('scannerActive'));
                        this.scannerActive = savedStatus || false;

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
                            this.handleEnterKey(event);
                            this.barcode = '';
                        } else {
                            this.barcode += event.key;
                        }
                    },

                    deactivateScanner() {
                        this.scannerActive = false;
                        if (this.captureBarcodeListener) {
                            window.removeEventListener('keydown', this.captureBarcodeListener);
                            this.captureBarcodeListener = null;
                        }
                        localStorage.setItem('scannerActive', JSON.stringify(this.scannerActive));
                    },

                    checkBarcode() {
                        fetch(`/search/barangrusak?id=${this.barcode}`)
                            .then(response => response.json())
                            .then(data => {
                                this.results = data;
                                this.checkedItems = [];
                                this.allChecked = false;
                            });
                    },

                    handleEnterKey(event) {
                        event.preventDefault();
                        this.checkBarcode();
                    },


                    isProcessing: false, // Status pemrosesan

                    // Fungsi untuk menangani hasil scan QR
                    async onScanSuccess(decodedText) {
                        // Cek jika sedang memproses atau barcode kosong
                        if (this.isProcessing || decodedText.trim() === '') {
                            return;
                        }

                        // Set status menjadi sedang memproses
                        this.isProcessing = true;

                        fetch(`/search/barangrusak?id=${decodedText}`)
                            .then(response => response.json())
                            .then(data => {
                                this.results = data;
                                this.checkedItems = [];
                                this.allChecked = false;
                            });

                        // Reset status setelah beberapa detik (misalnya 3 detik)
                        setTimeout(() => {
                            this.isProcessing = false;
                        }, 3000);
                    },

                    // Fungsi untuk menginisialisasi scanner QR
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
                };
            }
        </script>
</x-sidebar-layout>