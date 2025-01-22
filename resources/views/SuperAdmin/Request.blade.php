<x-sidebar-layout>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Header -->
    <header class="bg-zinc-900 text-white p-4">
        <h1 class="text-2xl font-semibold">Permintaan Barang</h1>
        <p class="text-sm">Menampilkan Permintaan Barang dari Admin Kantor Layanan</p>
    </header>
    <!-- Container -->
    <div class="container mx-auto my-6 p-4 bg-white rounded shadow font-roboto">

        <!-- Title -->
        <div class="mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Permintaan Barang</h2>
            <p class="text-gray-600">Daftar permintaan barang yang diinputkan oleh admin kantor layanan.</p>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto" x-data="requestHandler()">
            <table class="min-w-full bg-white mobile:text-sm border">
                <thead>
                    <tr>
                        <th class="md:py-2 px-4 mobile:px-2 border-b-2 border-gray-200 text-left text-gray-600 font-semibold">Kantor</th>
                        <th class="md:py-2 px-4 mobile:px-2 border-b-2 border-gray-200 text-left text-gray-600 font-semibold">Tanggal Permintaan</th>
                        <th class="md:py-2 px-4 mobile:px-2 border-b-2 border-gray-200 text-left text-gray-600 font-semibold">Status</th>
                        <th class="md:py-2 px-4 mobile:px-2 border-b-2 border-gray-200 text-left text-gray-600 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $groupedRequests = $daftarpermintaan->groupBy('pop');
                    @endphp

                    <!-- Example Request Rows -->
                    @foreach ($groupedRequests as $kantorLayanan => $requests)
                    @php
                    $requestIds = $requests->pluck('id')->toArray();
                    $requestIdsJson = json_encode($requestIds);
                    @endphp
                    <!-- Menampilkan Kantor Layanan pada Baris Utama -->
                    <tr>
                        <td class="md:py-2 px-4 mobile:px-2 border-b text-gray-700">{{ $kantorLayanan }}</td>
                        <td class="md:py-2 px-4 mobile:px-2 border-b text-gray-700">{{ $requests->first()->created_at }}</td>
                        <td class="md:py-2 px-4 mobile:px-2 border-b font-semibold">
                            <span
                                class="inline-block px-3 py-1 mobile:text-[10px] text-white rounded-full 
    @if($requests->first()->status == 'Pending')
        bg-yellow-500
    @elseif($requests->first()->status == 'Setujui')
        bg-green-500
    @elseif($requests->first()->status == 'Tolak')
        bg-red-500
    @elseif($requests->first()->status == 'Dikirim')
        bg-blue-500
    @endif">
                                {{ $requests->first()->status }}
                            </span>

                        </td>
                        <td class="md:py-1 px-3 mobile:px-1 mobile:text-[10px] border-b">
                            <!-- Tombol Detail -->
                            <button
                                @click="toggleDetails({{ $requests->first()->id }})"
                                class="bg-blue-500 hover:bg-blue-700 text-white py-1 px-3 mobile:mb-1 rounded">
                                Detail
                            </button>
                            <!-- Tombol Setujui -->
                            <button
                                @click="setujuiSemua({{ $requestIdsJson }})"
                                :disabled="['Setujui', 'Dikirim'].includes('{{ $requests->first()->status }}')"
                                :class="{
        'bg-green-500 hover:bg-green-700 text-white py-1 px-3 rounded': !['Setujui', 'Dikirim'].includes('{{ $requests->first()->status }}'),
        'opacity-50 py-2 px-4 rounded cursor-not-allowed': ['Setujui', 'Dikirim'].includes('{{ $requests->first()->status }}')
    }">
                                Setujui
                            </button>


                            <!-- Tombol Tolak -->
                            <button
                                @click="openModal('Tolak', {{ $requestIdsJson }})"
                                :disabled="['Tolak', 'Dikirim'].includes('{{ $requests->first()->status }}')"
                                :class="{
        'bg-red-500 hover:bg-red-700 text-white py-1 px-3 rounded': !['Tolak', 'Dikirim'].includes('{{ $requests->first()->status }}'),
        'opacity-50 py-2 px-4 rounded cursor-not-allowed': ['Tolak', 'Dikirim'].includes('{{ $requests->first()->status }}')
    }">
                                Tolak
                            </button>

                        </td>
                    </tr>

                    <!-- Sub-row for displaying item details when clicked -->
                    <tr x-show="activeDetails === {{ $requests->first()->id }}" x-cloak
                        x-transition:enter="transition transform ease-out duration-500"
                        x-transition:enter-start="opacity-0 translate-y-4"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition transform ease-in duration-300"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 translate-y-4">
                        <td colspan="4" class="bg-gray-50">
                            <table class="min-w-full mobile:text-xs bg-gray-100 border">
                                <thead>
                                    <tr>
                                        <th class="py-1 px-4 mobile:px-2 border-b border-gray-200 text-left text-gray-600 font-semibold">Nama Barang</th>
                                        <th class="py-1 px-4 mobile:px-2 border-b border-gray-200 text-left text-gray-600 font-semibold">Seri</th>
                                        <th class="py-1 px-4 mobile:px-2 border-b border-gray-200 text-left text-gray-600 font-semibold">Jumlah</th>
                                        <th class="py-1 px-4 mobile:px-2 border-b border-gray-200 text-left text-gray-600 font-semibold">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requests as $request)
                                    <tr>
                                        <td class="py-1 px-4 mobile:px-2 border-b text-gray-700">{{ $request->nama_barang }}</td>
                                        <td class="py-1 px-4 mobile:px-2 border-b text-gray-700">{{ $request->seri }}</td>
                                        <td class="py-1 px-4 mobile:px-2 border-b text-gray-700">{{ $request->jumlah }}</td>
                                        <td class="py-1 px-4 mobile:px-2 border-b text-gray-700">{{ $request->keterangan }}</td>
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
                <div class="bg-white p-6 rounded shadow-md w-1/3">
                    <h2 class="text-xl mb-4" x-text="modalAction + ' Permintaan'"></h2>
                    <p class="text-sm mb-4">Masukkan keterangan status untuk tindakan "<span x-text="modalAction"></span>" ini.</p>

                    <!-- Input keterangan status -->
                    <textarea x-model="statusNote" class="w-full p-2 border rounded" rows="3" placeholder="Masukkan keterangan..."></textarea>

                    <div class="mt-4 flex justify-end space-x-2">
                        <button @click="isModalOpen = false" class="bg-gray-500 hover:bg-gray-600 text-white py-1 px-3 rounded">Batal</button>
                        <button @click="submitStatus()" class="bg-green-500 hover:bg-green-600 text-white py-1 px-3 rounded">Kirim</button>
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