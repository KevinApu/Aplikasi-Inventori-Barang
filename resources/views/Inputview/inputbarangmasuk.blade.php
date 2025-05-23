<x-sidebar-layout>
    <h1 class="text-2xl font-semibold font-heading text-gray-500">Input Barang Masuk</h1>
    <hr class="my-2">



    <form action="{{ route('input_barang_masuk') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="overflow-x-auto grid grid-cols-1 md:grid-cols-2 gap-0 bg-zinc-100 rounded-md mx-2 items-start">
            <!--  ==================================================================================================================================== -->
            <main class="grid mobile:grid-cols-1 px-6 mobile:px-1 tablet:px-3 py-4">
                <div class="flex px-6 space-x-6">
                    <div x-data="{kodebarang: '{{ old('kodebarang') }}',error: @error('kodebarang') true @else false @enderror }" class="w-full mobile:max-w-[80px] tablet:max-w-lg">
                        <input
                            x-model="kodebarang"
                            @input="error = kode.trim() === ''"
                            class="w-32 mobile:w-full mobile:h-[30px] tablet:w-full border-0 focus:ring-0 border-b bg-transparent"
                            :class="{'border-red-500 placeholder-red-500': error, 'border-gray-300 placeholder-gray-500': !error}"
                            type="text"
                            name="kodebarang"
                            placeholder="Kode">
                        @error('kodebarang')
                        <p class="text-red-500 text-[10px]">{{$message}}</p>
                        @enderror
                    </div>

                    <div x-data="{ seri: '{{ old('seri') }}', error: @error('seri') true @else false @enderror}">
                        <input
                            x-model="seri"
                            @input="error = seri.trim() === ''"
                            class="form-input laptop:w-[350px] w-full border-0 focus:ring-0 border-b bg-transparent -pr-10"
                            :class="{'border-red-500 placeholder-red-500': error, 'border-gray-300 placeholder-gray-500': !error}"
                            type="text"
                            name="seri"
                            placeholder="Seri (Isi '-' jika kosong)">
                    </div>
                </div>
            </main>
            <!--  ==================================================================================================================================== -->
            <!--  ==================================================================================================================================== -->
            <main class="flex-1 rounded-md px-4 tablet:px-3 py-0 laptop:py-4 tablet:py-3 scale-95">
                <form action=""></form>
                <div x-data="{ isNewItem: {{ session('isNewItem') ? 'true' : 'false' }} }">
                    <div class="flex space-x-6">
                        <select class="form-input h-10 w-48 mobile:w-32 tablet:w-40 border-0 focus:ring-0 border-b bg-transparent"
                            name="kategori" x-model="kategori" x-on:change="isNewItem = ($event.target.value === 'new')">
                            <option value="" class="bg-gray-400 hover:bg-gray-300" selected>Pilih Ketegori...</option>
                            @foreach ($kategoris as $kategori)
                            <option value="{{ $kategori->kategori }}">
                                {{ $kategori->kategori }}
                            </option>
                            @endforeach
                            <option value="new" class="text-blue-700">New Item...</option>
                        </select>
                        <!-- Input untuk item baru -->
                        <form action="{{ route('kategori.baru') }}" method="POST">
                            @csrf
                            <div x-show="isNewItem" x-transition>
                                <input type="text" name="kategori_baru" x-model="kategori_baru"
                                    class="form-input h-10 laptop:w-48 w-full border-0 focus:ring-0 border-b bg-transparent" />

                                <button type="submit" x-on:click="kategori_baru = ''; isNewItem = false">
                                    <svg class="w-5 h-5 text-zinc-700" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                        </form>
                    </div>
                </div>
                @error('kategori')
                <p class="text-red-500 text-sm mt-1">Pastikan Anda sudah menambahkan Item Baru ke dropdown.</p>
                @enderror



                <div x-data="{
                    searchQuery: '',
                    filteredItems: @js($nama_barang),
                    isNewItem: false,
                    isOpen: false,
                    namabarang_baru: ''
                }">
                    <div class="flex space-x-6 mt-2 relative">
                        <!-- Input pencarian -->
                        <input
                            type="text"
                            name="namabarang"
                            class="form-input h-10 w-48 mobile:w-32 tablet:w-40 border-0 focus:ring-0 border-b bg-transparent"
                            placeholder="Pilih Nama Barang..."
                            x-model="searchQuery"
                            x-on:focus="isOpen = true"
                            x-on:blur="setTimeout(() => isOpen = false, 200)"
                            x-on:input="filteredItems = @js($nama_barang).filter(item => item.nama_barang.toLowerCase().includes(searchQuery.toLowerCase()))" />


                        <!-- Dropdown hasil pencarian -->
                        <div x-show="isOpen" class="absolute z-10 bg-white shadow-lg mt-12 w-48 border border-gray-300 max-h-52 overflow-y-auto" x-transition>
                            <ul>
                                <template x-for="namabarang in filteredItems" :key="namabarang.nama_barang">
                                    <li>
                                        <a
                                            href="#"
                                            x-text="namabarang.nama_barang"
                                            class="block p-2 hover:bg-gray-200"
                                            @click.prevent="searchQuery = namabarang.nama_barang; isNewItem = false; isOpen = false"></a>
                                    </li>
                                </template>
                                <li>
                                    <a href="#" class="block p-2 text-blue-700 hover:bg-gray-200"
                                        @click.prevent="searchQuery = ''; isNewItem = true; isOpen = false">
                                        New Item...
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Form untuk item baru -->
                        <form action="{{ route('namabarang.baru') }}" method="POST" class="flex items-center space-x-2" x-show="isNewItem" x-transition>
                            @csrf
                            <input type="text" name="namabarang_baru" x-model="namabarang_baru"
                                class="form-input h-10 laptop:w-48 w-full border-0 focus:ring-0 border-b bg-transparent"
                                placeholder="Nama Barang Baru..." required />

                            <button type="submit">
                                <svg class="w-5 h-5 text-zinc-700" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
                @error('namabarang')
                <p class="text-red-500 text-sm mt-1">Pastikan Anda sudah menambahkan Item Baru ke dropdown.</p>
                @enderror



                <div x-data="{ selected: '', showRasio: false, placeholder: '', rasioRequired: false, satuan: '' }">
                    <div class="flex space-x-6 mt-2">
                        <select
                            class="form-input h-10 w-48 border-0 focus:ring-0 border-b bg-transparent"
                            name="satuan"
                            x-model="selected"
                            @change="showRasio = (selected === 'Roll' || selected === 'Meter' || selected === 'Pack'); 
                            placeholder = selected === 'Roll' ? 'Per Roll berapa meter?' : 
                            selected === 'Pack' ? 'Per Pack berapa Pcs?' : 
                            selected === 'Meter' ? 'Per Pcs berapa meter?' : '';
                            rasioRequired = showRasio">
                            <option value="Pcs">Pcs</option>
                            <option value="Roll">Roll</option>
                            <option value="Pack">Pack</option>
                            <option value="Unit">Unit</option>
                        </select>

                        <!-- Input untuk rasio jika Roll, Pack, atau Meter dipilih -->
                        <div x-show="showRasio" class="flex-1">
                            <input type="number" name="rasio"
                                class="form-input h-10 w-full mobile:max-w-md tablet:max-w-lg border-0 focus:ring-0 border-b bg-transparent"
                                :placeholder="placeholder" inputmode="numeric" pattern="[0-9]*"
                                @input="this.value = this.value.replace(/[^0-9]/g, '')"
                                :required="rasioRequired">
                        </div>
                    </div>
                </div>
                <div x-data="{ today: (new Date()).toISOString().split('T')[0], selectedDate: (new Date()).toISOString().split('T')[0] }" class="mt-4">
                    <label for="tglmasuk" class="block text-sm font-medium text-gray-700">Tanggal Masuk</label>
                    <input type="date" :value="today" x-model="selectedDate" name="tglmasuk" id="tglmasuk" class="mt-1 w-52 px-3 py-2 border rounded-lg shadow-md bg-white text-gray-700 transition duration-200 ease-in-out hover:bg-gray-50 cursor-pointer" />
                </div>
            </main>
            <main class="flex-1 px-6 mobile:px-1 tablet:px-3 py-0 pb-6 mobile:pb-1 md:-mt-40">
                <div class="flex px-6 space-x-6">
                    <div x-data="{lokasi: '{{ old('lokasi') }}', error: @error('lokasi') true @else false @enderror }">
                        <input
                            x-model="lokasi"
                            @input="error = lokasi.trim() === ''"
                            class="w-full mobile:w-full tablet:w-full border-0 focus:ring-0 border-b bg-transparent"
                            :class="{'border-red-500 placeholder-red-500': error, 'border-gray-300 placeholder-gray-500': !error}"
                            type="text"
                            name="lokasi"
                            placeholder="Lokasi">
                    </div>
                    <div>
                        <input
                            type="text"
                            name="jumlah"
                            id="jumlah"
                            placeholder="Jumlah"
                            class="block form-input w-48 mobile:w-full tablet:w-full border-0 focus:ring-0 border-b bg-transparent {{ $errors->has('jumlah') ? 'border-red-500 placeholder-red-500' : 'border-gray-300 placeholder-gray-500' }}"
                            oninput="
        this.value = this.value.replace(/[^0-9]/g, ''); // hanya angka 0-9
        if (this.value.length > 4) {
            this.value = this.value.slice(0, 4); // maksimal 4 digit
        }
    "
                            maxlength="4"
                            inputmode="numeric"
                            value="{{ old('jumlah') }}" />

                        @error('jumlah')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="mobile:grid mobile:grid-row tablet:grid tablet:grid-row flex px-6 justify-end space-x-6 mb-2">
                    <textarea name="keterangan" x-model="keterangan" rows="8" class="block form-input w-full mobile:max-w-md tablet:max-w-lg border-0 focus:ring-0 border-b bg-transparent text-sm " placeholder="Keterangan (opsional)"></textarea>

                    <div x-data="{ photo: null, isDragging: false }" class="bg-transparent rounded-lg mt-6 ml-2">
                        <input type="file" name="foto" @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = e => photo = e.target.result; reader.readAsDataURL(file); }" accept="image/*"
                            class="hidden" x-ref="fileInput">
                        <div @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false" @drop.prevent="isDragging = false; const file = $event.dataTransfer.files[0]; if (file) { const reader = new FileReader(); reader.onload = e => photo = e.target.result; reader.readAsDataURL(file); $refs.fileInput.files = $event.dataTransfer.files; }"
                            :class="{'border-indigo-500': isDragging, 'border-gray-300': !isDragging}"
                            class="border-2 border-dashed border-gray-300 rounded-lg p-4 flex flex-col items-center justify-center cursor-pointer"
                            @click="$refs.fileInput.click()">

                            <template x-if="!photo">
                                <div class="flex flex-col items-center">
                                    <p class="text-gray-600 text-sm font-medium transition-opacity duration-300 ease-in-out">Drag & drop a photo here or click to select</p>
                                    <div class="w-32 h-32 flex items-center justify-center mt-2 animate-bounce">
                                        <img src="/img/Animasi Photo.png" alt="Animation" class="w-24 h-24 transition-opacity duration-300 ease-in-out">
                                    </div>
                                </div>
                            </template>

                            <img :src="photo" alt="Preview" class="w-40 h-40 rounded-lg shadow-md mx-auto mt-2" x-show="photo">
                        </div>
                        @error('foto')
                        <p class="text-red-500 text-sm mt-1">{{$message}}</p>
                        @enderror
                    </div>

                </div>
                <button type="submit" class="px-8 py-2 mb-2 mobile:ml-2 w-32 bg-[#4B0082] text-white rounded-md hover:bg-indigo-700 transition-colors duration-200 ease-in-out">Simpan</button>
            </main>
            <!--  ==================================================================================================================================== -->
        </div>
    </form>


    @if (session('success') && session('barang'))
    <div x-data="{ isOpen: true }" x-init="setTimeout(() => isOpen = false, 2000)">
        <div
            x-show="isOpen"
            @keydown.escape.window="isOpen = false"
            @click.self="isOpen = false"
            tabindex="-1"
            aria-hidden="true"
            class="fixed inset-0 z-50 flex items-center justify-center w-full h-screen bg-black bg-opacity-30 overflow-y-auto overflow-x-hidden"
            x-transition:enter="transition-opacity duration-300 ease-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-300 ease-in"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">

            <div
                @click.stop
                class="bg-white rounded-xl shadow-lg p-4 text-center w-72 transition-transform"
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

                <!-- Product Info -->
                <div class="bg-zinc-300 bg-opacity-40 p-2.5 rounded-lg mb-4 flex items-center shadow mt-2">
                    <img src="{{ asset('storage/' . session('barang')['foto']) }}" alt="foto"
                        class="h-10 w-10 rounded mr-4 border-violet-500 shadow">
                    <div>
                        <h3 class="text-[15px] px-1 font-semibold">{{ session('barang')['nama'] }}</h3>
                        <p class="text-[11px] text-gray-700">{{ session('barang')['spesifikasi'] }}</p>
                    </div>
                </div>

                <!-- Success Message -->
                <p class="text-center mb-4 text-black-300 text-[13px]">{{ session('success') }}</p>

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

</x-sidebar-layout>