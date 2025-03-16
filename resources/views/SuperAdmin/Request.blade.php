<x-sidebar-layout>
    <!-- Header -->
    <header class="bg-zinc-900 text-white p-4">
        <h1 class="text-2xl font-semibold">Permintaan Barang</h1>
        <p class="text-sm">Menampilkan Permintaan Barang dari Admin Cabang</p>
    </header>
    <!-- Container -->
    <div class="container mx-auto my-6 p-4 bg-white rounded shadow font-roboto">

        <!-- Title -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Permintaan Barang</h2>
            <p class="text-gray-600">Daftar permintaan barang yang diinputkan oleh admin Cabang.</p>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto bg-white shadow-2xl ring-1 ring-gray-300 rounded-lg p-4" x-data="requestHandler()">
            <table class="w-full border-collapse bg-gray-50 rounded-lg">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="py-3 px-4 text-left">Kode Cabang</th>
                        <th class="py-3 px-4 text-left">Tanggal Permintaan</th>
                        <th class="py-3 px-4 text-left">Status</th>
                        <th class="py-3 px-4 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @php
                    $groupedRequests = $daftarpermintaan->groupBy('pop');
                    @endphp

                    @foreach ($groupedRequests as $kantorLayanan => $requests)

                    @php
                    $requestIds = $requests->pluck('id')->toArray();
                    $requestIdsJson = json_encode($requestIds);
                    $lokasi = optional($requests->first()->KLModel)->lokasi;
                    @endphp
                    <tr class="bg-white hover:bg-gray-100">
                        <td class="py-3 px-4 text-gray-800 font-medium">{{ $lokasi }}</td>
                        <td class="py-3 px-4 text-gray-600">{{ $requests->first()->created_at }}</td>
                        <td class="py-3 px-4">
                            <span class="px-3 py-1 text-sm text-white rounded-full 
                        @if($requests->first()->status == 'Pending') bg-yellow-500
                        @elseif($requests->first()->status == 'Setujui') bg-green-500
                        @elseif($requests->first()->status == 'Tolak') bg-red-500
                       @elseif($requests->first()->status == 'Menunggu Dikirim' || $requests->first()->status == 'Sedang Dikirim') bg-blue-500 @endif">
                                {{ $requests->first()->status }}
                            </span>
                        </td>
                        <td class="py-3 px-4 flex space-x-2">
                            <!-- Tombol Detail -->
                            <button @click="toggleDetails({{ $requests->first()->id }})"
                                class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-4 py-2 rounded-lg shadow-md transition-transform transform hover:scale-105">
                                Detail
                            </button>

                            <!-- Tombol Setujui -->
                            <button @click="setujuiSemua({{ $requestIdsJson }})"
                                :disabled="['Setujui', 'Menunggu Dikirim', 'Sedang Dikirim'].includes('{{ $requests->first()->status }}')"
                                :class="['text-white text-sm px-4 py-2 rounded-lg shadow-md transition-transform transform',
            ['Setujui', 'Menunggu Dikirim', 'Sedang Dikirim'].includes('{{ $requests->first()->status }}') ? 'bg-gray-400 cursor-not-allowed opacity-50' : 'bg-green-500 hover:bg-green-600 hover:scale-105']">
                                Setujui
                            </button>

                            <!-- Tombol Tolak -->
                            <button @click="openModal('Tolak', {{ $requestIdsJson }})"
                                :disabled="['Tolak', 'Menunggu Dikirim', 'Sedang Dikirim'].includes('{{ $requests->first()->status }}')"
                                :class="['text-white text-sm px-4 py-2 rounded-lg shadow-md transition-transform transform',
            ['Tolak', 'Menunggu Dikirim', 'Sedang Dikirim'].includes('{{ $requests->first()->status }}') ? 'bg-gray-400 cursor-not-allowed opacity-50' : 'bg-red-500 hover:bg-red-600 hover:scale-105']">
                                Tolak
                            </button>
                        </td>
                    </tr>

                    <!-- Sub-row for displaying item details -->
                    <tr x-show="activeDetails === {{ $requests->first()->id }}" x-cloak
                        x-transition:enter="transition transform ease-out duration-500"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition transform ease-in duration-300"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-4">
                        <td colspan="4" class="bg-gray-100 p-4 shadow-lg">
                            <table class="w-full border bg-white rounded-lg">
                                <thead class="bg-gray-200">
                                    <tr>
                                        <th class="py-2 px-4 text-left">Nama Barang</th>
                                        <th class="py-2 px-4 text-left">Seri</th>
                                        <th class="py-2 px-4 text-left">Jumlah</th>
                                        <th class="py-2 px-4 text-left">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requests as $request)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="py-2 px-4 text-gray-700">{{ $request->nama_barang }}</td>
                                        <td class="py-2 px-4 text-gray-700">{{ $request->seri }}</td>
                                        <td class="py-2 px-4 text-gray-700">{{ $request->jumlah }}</td>
                                        <td class="py-2 px-4 text-gray-700">{{ $request->keterangan ?? '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Modal untuk input keterangan status -->
            <div x-show="isModalOpen" x-cloak class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-lg shadow-md w-1/3">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4" x-text="modalAction + ' Permintaan'"></h2>
                    <p class="text-sm text-gray-600 mb-4">Masukkan keterangan status untuk tindakan "<span x-text="modalAction"></span>".</p>

                    <!-- Input keterangan status -->
                    <textarea x-model="statusNote" class="w-full p-2 border rounded-md focus:ring-2 focus:ring-blue-400" rows="3" placeholder="Masukkan keterangan..."></textarea>

                    <div class="mt-4 flex justify-end space-x-2">
                        <button @click="isModalOpen = false" class="bg-gray-500 hover:bg-gray-600 text-white py-1 px-3 rounded-lg">Batal</button>
                        <button @click="submitStatus()" class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded-lg">Kirim</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <script>
        // Fungsi untuk Setujui Semua ID
        function setujuiSemua(ids) {
            fetch(`/requestbarang/setujui/multiple`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Token CSRF
                    },
                    body: JSON.stringify({
                        ids: ids
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message); // Menampilkan pesan jika status berhasil diperbarui
                    location.reload(); // Mengambil ulang data atau melakukan reload halaman
                })
                .catch(error => console.error('Error:', error));
        }

        function requestHandler() {
            return {
                activeDetails: null,
                isModalOpen: false,
                modalAction: '',
                requestIds: [],
                statusNote: '',
                toggleDetails(id) {
                    this.activeDetails = this.activeDetails === id ? null : id;
                },
                openModal(action, ids) {
                    if (action === 'Tolak') {
                        this.isModalOpen = true;
                        this.modalAction = action;
                        this.requestIds = ids;
                    }
                },
                submitStatus() {
                    fetch('/requestbarang/tolak/multiple', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                ids: this.requestIds,
                                statusNote: this.statusNote
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.message);
                            location.reload();
                        })
                        .catch(error => console.error('Error:', error));

                    this.isModalOpen = false;
                    this.statusNote = '';
                }
            }
        }
    </script>
    </script>


</x-sidebar-layout>