<x-sidebar-layout>
    <!-- Header -->
    <header class="bg-zinc-900 text-white p-4">
        <h1 class="text-2xl font-semibold">Permintaan Barang</h1>
        <p class="text-sm">Formulir permintaan barang untuk dikirimkan ke SuperAdmin</p>
    </header>

    <!-- Container -->
    <div class="container mx-auto my-6 p-6 mobile:my-3 mobile:p-3 bg-white rounded shadow text-sm mobile:text-[10px]">


        <div x-data="{
        activeTab: {{ $riwayat ? "'status'" : "'permintaan'" }},
        riwayat: {{ $riwayat ? 'true' : 'false' }}
    }">
            <!-- Tabs Menu -->
            <div class="flex space-x-4 border-b border-gray-200 mb-6">
                <button
                    @click="activeTab = 'permintaan'"
                    :class="{
        'border-b-2 border-blue-500 text-blue-500': activeTab === 'permintaan',
        'opacity-50 cursor-not-allowed': {{ $riwayat ? 'true' : 'false' }}
    }"
                    class="px-4 py-2 font-medium text-gray-600 hover:text-blue-500 focus:outline-none"
                    x-show="!{{ $riwayat ? 'true' : 'false' }}">
                    Permintaan Barang
                </button>

                <button
                    @click="activeTab = 'status'"
                    :class="{'border-b-2 border-blue-500 text-blue-500': activeTab === 'status'}"
                    class="px-4 py-2 font-medium text-gray-600 hover:text-blue-500 focus:outline-none">
                    Status Permintaan
                </button>
                <button
                    @click="activeTab = 'status_pengiriman'"
                    :class="{'border-b-2 border-blue-500 text-blue-500': activeTab === 'status_pengiriman'}"
                    class="px-4 py-2 font-medium text-gray-600 hover:text-blue-500 focus:outline-none">
                    Status Pengiriman
                </button>
            </div>

            <!-- Account Settings -->
            <div x-show="activeTab === 'permintaan'" class="space-y-6">
                <h2 class="text-xl mobile:text-sm font-semibold text-gray-800 mb-4">Form Permintaan Barang</h2>
                <form action="{{ route('request_barang.post') }}" method="post" class="space-y-6">
                    @csrf
                    <div id="items" class="space-y-4">
                        @foreach($barangKurang as $pop => $items)
                        @foreach($items as $item)
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-gray-100 p-4 rounded-lg shadow-sm item-row">
                            <div>
                                <label for="nama_barang" class="block text-gray-700 font-medium">Nama Barang</label>
                                <input type="text" name="nama_barang[]" value="{{ $item['nama_barang'] }}" placeholder="Nama Barang" class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-blue-300" required>
                            </div>
                            <div>
                                <label for="seri" class="block text-gray-700 font-medium">Seri</label>
                                <input type="text" name="seri[]" value="{{ $item['seri'] }}" placeholder="Seri" class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-blue-300" required>
                            </div>
                            <div>
                                <label for="jumlah" class="block text-gray-700 font-medium">Jumlah</label>
                                <input type="number" name="jumlah[]" value="{{ $item['jumlah'] }}" placeholder="Jumlah" class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-blue-300" min="1" required>
                            </div>
                            <div>
                                <label for="keterangan" class="block text-gray-700 font-medium">Keterangan</label>
                                <input type="text" name="keterangan[]" value="{{ $item['keterangan'] }}" placeholder="Keterangan (opsional)" class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-blue-300">
                            </div>
                        </div>
                        @endforeach
                        @endforeach
                    </div>

                    <div class="flex justify-between items-center">
                        <button type="button" id="addItemButton" class="bg-green-500 hover:bg-green-600 text-white py-2 px-5 rounded-lg shadow-md border border-green-600 transition-transform transform hover:scale-105 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Tambah Barang
                        </button>
                    </div>

                    <div class="flex justify-end mt-4">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-3 px-8 text-lg rounded-lg shadow-md border border-blue-700 transition-transform transform hover:scale-105 flex items-center gap-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Kirim Permintaan
                        </button>
                    </div>


                </form>

            </div>

            <!-- Preferences -->
            <div x-show="activeTab === 'status'" class="space-y-6" x-cloak>
                <div class="container mt-10">
                    @if($result)
                    <table class="min-w-full border-collapse border bg-white">
                        <thead>
                            <tr>
                                <th class="border border-gray-200 px-4 py-2 mobile:px-2 mobile:py-1 text-left">Nama Barang</th>
                                <th class="border border-gray-200 px-4 py-2 mobile:px-2 mobile:py-1 text-left">Seri</th>
                                <th class="border border-gray-200 px-1 py-2 mobile:px-2 mobile:py-1 text-left">Jumlah</th>
                                <th class="border border-gray-200 px-4 py-2 mobile:px-2 mobile:py-1 text-left">Ket. Barang</th>
                                <th class="border border-gray-200 px-4 py-2 mobile:px-2 mobile:py-1 text-left">Status</th>
                                @if ($result->contains(fn($request) => !empty($request->ket_status)))
                                <th class="border border-gray-200 px-4 py-2 mobile:px-2 mobile:py-1 text-left">Ket. Status</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($result as $request)
                            <tr>
                                <td class="border border-gray-200 px-4 py-2 mobile:px-2 mobile:py-1">{{ $request->nama_barang }}</td>
                                <td class="border border-gray-200 px-4 py-2 mobile:px-2 mobile:py-1">{{ $request->seri }}</td>
                                <td class="border border-gray-200 px-1 py-2 mobile:px-2 mobile:py-1">{{ $request->jumlah }}</td>
                                <td class="border border-gray-200 px-4 py-2 mobile:px-2 mobile:py-1">{{ $request->catatan }}</td>
                                <td class="border border-gray-200 px-4 py-2 mobile:px-2 mobile:py-1">
                                    @php
                                    $statusColors = [
                                    'Pending' => 'bg-yellow-500',
                                    'Setujui' => 'bg-green-500',
                                    'Tolak' => 'bg-red-500',
                                    'Menunggu Pengiriman' => 'bg-blue-500',
                                    'Sedang Dikirim' => 'bg-purple-500',
                                    ];
                                    $statusClass = $statusColors[$request->status] ?? 'bg-gray-500';
                                    @endphp

                                    <span class="inline-block text-center px-3 md:py-1 mobile:px-1 text-white rounded-md mobile:text-[7px] {{ $statusClass }}">
                                        {{ $request->status }}
                                    </span>
                                </td>
                                @if ($result->contains(fn($request) => !empty($request->ket_status)))
                                <td class="border border-gray-200 px-4 py-2">
                                    <span
                                        class="
                                        @if($request->status == 'Pending')
                                            text-yellow-500
                                        @elseif($request->status == 'Setujui')
                                            text-green-500
                                        @elseif($request->status == 'Tolak')
                                            text-red-500
                                        @endif">
                                        {{ $request->ket_status }}
                                    </span>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="text-center">
                        <p class="text-gray-600">Tidak ada riwayat permintaan barang.</p>
                    </div>
                    @endif
                </div>
            </div>

            <div x-show="activeTab === 'status_pengiriman'" class="space-y-6" x-cloak>
                @if($riwayat)
                <div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg mt-10">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Status Pengiriman Barang</h2>
                    <div class="flex items-center justify-between mb-6">
                        <!-- Step 2: Diproses -->
                        <div class="flex items-center flex-col text-center">
                            <div class="w-10 h-10 flex items-center justify-center bg-green-500 text-white rounded-full font-semibold">
                                <span>1</span>
                            </div>
                            <span class="text-gray-700 mt-2">Diproses</span>
                            <span class="text-sm mobile:text-[10px] text-gray-500">{{ $riwayat->formatted_created_at}}</span>
                        </div>

                        <!-- Line -->
                        <div class="h-1 flex-1 bg-blue-300"></div>

                        <!-- Step 3: Dalam Pengiriman -->
                        <div class="flex items-center flex-col text-center">
                            <div class="w-10 h-10 flex items-center justify-center bg-blue-500 text-white rounded-full font-semibold">
                                <span>2</span>
                            </div>
                            <span class="text-gray-700 mt-2">Dalam Pengiriman</span>
                            <span class="text-sm mobile:text-[10px] text-gray-500">
                                {{ $riwayat->formatted_updated_at ?? 'Menunggu penjemputan' }}
                            </span>
                        </div>

                        <div class="h-1 flex-1 bg-gray-300"></div>

                        <div class="flex items-center flex-col text-center">
                            <div class="w-10 h-10 flex items-center justify-center bg-gray-300 text-gray-600 rounded-full font-semibold">
                                <span>3</span>
                            </div>
                            <span class="text-gray-700 mt-2">Sampai Tujuan</span>
                            <span class="text-sm mobile:text-[10px] text-gray-500">
                                {{ $riwayat->formatted_tanggal_estimasi ?? 'Estimasi Belum Tersedia' }}
                            </span>
                        </div>
                    </div>

                    <!-- Detail Pengiriman -->
                    <table class="min-w-full table-auto bg-gray-50 border-separate border-spacing-2 border border-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 md:py-2 mobile:px-2 text-left">Nama Barang</th>
                                <th class="px-4 md:py-2 mobile:px-2 text-left">Seri</th>
                                <th class="px-4 md:py-2 mobile:px-2 text-left">Jumlah</th>
                                @if($result->where('rasio', '!=', null)->isNotEmpty())
                                <th class="px-4 md:py-2 mobile:px-2 text-left">Satuan</th>
                                @endif
                                <th class="px-4 md:py-2 mobile:px-2 text-left">Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($result as $item)
                            <tr>
                                <td class="px-4 py-2"> {{ $item->nama_barang}}</td>
                                <td class="px-4 py-2">{{ $item->seri}}</td>
                                <td class="px-4 py-2">{{ $item->jumlah}} {{ $item->satuan}}</td>
                                @if($item->rasio !== null)
                                <td class="px-4 py-2">{{ $item->rasio}}</td>
                                @endif
                                <td class="px-4 py-2">{{ $item->catatan ?? '-'}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Timeline Riwayat Pengiriman -->
                    <div class="mt-6">
                        <h3 class="text-lg mobile:text-sm font-semibold text-gray-800 mb-4">Riwayat Pengiriman</h3>
                        <div class="space-y-6">
                            <!-- Step 1: Barang Diproses -->
                            <div class="p-4 bg-white rounded-lg shadow-md border border-gray-200">
                                <div class="flex items-start space-x-4">
                                    <div class="w-8 h-8 mobile:w-4 mobile:h-4 p-2 bg-green-500 text-white rounded-full flex items-center justify-center font-semibold">1</div>
                                    <div class="flex-1">
                                        <p class="text-gray-700 font-medium">Barang diproses untuk pengiriman</p>
                                        <p class="text-sm mobile:text-[10px] text-gray-500">{{ $riwayat->formatted_created_at}}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Barang Dalam Perjalanan -->
                            @if($riwayat->status === "Sedang Dikirim" && $riwayat->resi !== null)
                            <div class="p-4 bg-white rounded-lg shadow-md border border-gray-200">
                                <div class="flex items-start space-x-4">
                                    <div class="w-8 h-8 mobile:w-4 mobile:h-4 p-2 bg-blue-500 text-white rounded-full flex items-center justify-center font-semibold">2</div>
                                    <div class="flex-1">
                                        <p class="text-gray-700 font-medium">Barang dalam perjalanan</p>
                                        <p class="text-sm mobile:text-[10px] text-gray-500 mb-2">{{ $riwayat->formatted_updated_at}}</p>
                                        <div class="bg-gray-50 p-3 border border-dashed border-blue-300 rounded-lg flex items-center justify-between">
                                            <div>
                                                <p class="text-sm mobile:text-[10px] text-gray-600 font-semibold">Nomor Resi</p>
                                                <p class="text-lg mobile:text-[smpx] text-blue-600 font-bold" id="resiText">{{ $riwayat->resi }}</p>
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
                            @endif

                            <!-- Step 3: Estimasi Sampai -->
                            @if($riwayat->status === "Sedang Dikirim" && $riwayat->resi !== null)
                            <div class="p-4 bg-white rounded-lg shadow-md border border-gray-200">
                                <div class="flex items-start space-x-4">
                                    <div class="w-8 h-8 mobile:w-4 mobile:h-4 p-2 bg-gray-300 text-gray-500 rounded-full flex items-center justify-center font-semibold">3</div>
                                    <div class="flex-1">
                                        <p class="text-gray-700 font-medium">Estimasi sampai di Lokasi tujuan</p>
                                        <p class="text-sm mobile:text-[10px] text-gray-500">{{ $riwayat->formatted_tanggal_estimasi}}</p>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @else
                <div class="text-center">
                    <p class="text-gray-600">Tidak ada riwayat permintaan barang.</p>
                </div>
                @endif

                <div x-data="{ open: false, showCheck: false }">
                    <!-- Tombol Terima Barang -->
                    @if($result->where('status', 'Sedang Dikirim')->where('status','!=', 'Dibatalkan')->isNotEmpty())
                    <button
                        @click="showCheck = true; setTimeout(() => { open = true; showCheck = false; }, 1000);"
                        class="px-6 py-3 bg-gradient-to-r from-green-500 to-teal-600 text-white font-semibold rounded-lg shadow-lg hover:from-green-600 hover:to-teal-700 focus:ring-4 focus:ring-green-300">
                        Terima Barang
                    </button>
                    @endif

                    <!-- Animasi Centang -->
                    <div
                        x-show="showCheck"
                        x-transition:enter="ease-out duration-500"
                        x-transition:enter-start="opacity-0 scale-90"
                        x-transition:enter-end="opacity-100 scale-100"
                        x-cloak
                        class="fixed inset-0 flex items-center justify-center z-60">
                        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-green-600 animate-pulse animate-bounce" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l5 5l10 -10" />
                            </svg>
                        </div>
                    </div>
                    <!-- Modal Verifikasi Barang -->
                    <div
                        x-show="open"
                        x-cloak
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-30 transition-opacity">
                        <div
                            class="bg-white w-full max-w-lg p-6 rounded-lg shadow-xl transform transition-all scale-95"
                            x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0 scale-90"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-90">
                            <!-- Header -->
                            <div class="flex justify-between items-center border-b pb-3">
                                <h3 class="text-lg font-semibold text-gray-800">Verifikasi Penerimaan Barang</h3>
                            </div>

                            <!-- Konten Modal -->
                            <div class="mt-4">
                                <p class="text-gray-600">Barang telah diterima dengan rincian sebagai berikut:</p>

                                <!-- Tabel Barang -->
                                <table class="min-w-full mt-4 table-auto text-gray-800">
                                    <thead>
                                        <tr>
                                            <th class="px-4 py-2 text-left">Nama Barang</th>
                                            <th class="px-4 py-2 text-left">Seri</th>
                                            <th class="px-4 py-2 text-left">Jumlah</th>
                                            @if($result->where('rasio', '!=', null)->isNotEmpty())
                                            <th class="px-4 py-2 text-left">Satuan</th>
                                            @endif
                                            <th class="px-4 py-2 text-left">Catatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($result as $item)
                                        <tr>
                                            <td class="px-4 py-2"> {{ $item->nama_barang}}</td>
                                            <td class="px-4 py-2">{{ $item->seri}}</td>
                                            <td class="px-4 py-2">{{ $item->jumlah}} {{ $item->satuan}}</td>
                                            @if($item->rasio !== null)
                                            <td class="px-4 py-2">{{ $item->rasio}}</td>
                                            @endif
                                            <td class="px-4 py-2">{{ $item->catatan ?? '-'}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="mt-6 flex justify-end space-x-3">
                                <form action="{{ route('terima_barang') }}" method="POST">
                                    @csrf
                                    <button
                                        @click="open = false"
                                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400">
                                        Selesai
                                    </button>
                                </form>
                                <a href="{{ route('view.print.suratjalan') }}"
                                    @click="printReport()"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                                    Cetak Surat
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


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




    <!-- JavaScript for adding/removing items -->
    <script>
        document.getElementById('addItemButton').addEventListener('click', function() {
            const itemTemplate = `
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 bg-gray-100 p-4 rounded-lg item-row shadow-sm item-row">
                    <div>
                        <label for="nama_barang" class="block text-gray-700 font-medium">Nama Barang</label>
                        <input type="text" name="nama_barang[]" placeholder="Nama Barang" class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-blue-300" required>
                    </div>
                    <div>
                        <label for="seri" class="block text-gray-700 font-medium">Seri</label>
                        <input type="text" name="seri[]" placeholder="Seri" class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-blue-300" required>
                    </div>
                    <div>
                        <label for="jumlah" class="block text-gray-700 font-medium">Jumlah</label>
                        <input type="number" name="jumlah[]" placeholder="Jumlah" class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-blue-300" min="1" required>
                    </div>
                    <div>
                        <label for="keterangan" class="block text-gray-700 font-medium">Keterangan</label>
                        <input type="text" name="keterangan[]" placeholder="Keterangan (opsional)" class="w-full border border-gray-300 p-2 rounded focus:ring focus:ring-blue-300">
                    </div>
                </div>
                <button type="button" class="remove-item flex items-center gap-2 px-3 py-1.5 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 hover:text-red-700 transition-transform transform hover:scale-105 shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>Hapus</span>
                </button>
            </div>`;
            document.getElementById('items').insertAdjacentHTML('beforeend', itemTemplate);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-item')) {
                e.target.parentElement.remove();
            }
        });
    </script>
</x-sidebar-layout>