<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="container mx-auto p-4">
        <a href="{{ url('/') }}"
            class="flex items-center mb-2 text-gray-700 hover:text-gray-900 bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg border border-gray-300 transition duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            <span class="font-medium">Kembali</span>
        </a>
        <h1 class="text-3xl font-semibold text-gray-800 mb-6">Settings</h1>
        <div x-data="{ activeTab: '{{ session('activeTab', 'pengaturanfoto') }}' }">
            <!-- Tabs Menu -->
            <div class="flex space-x-4 border-b border-gray-200 mb-6">
                @if(auth()->user() && auth()->user()->role === 'superadmin')
                <button
                    @click="activeTab = 'tambahcabang'"
                    :class="{'border-b-2 border-blue-500 text-blue-500': activeTab === 'tambahcabang'}"
                    class="px-4 py-2 font-medium text-gray-600 hover:text-blue-500 focus:outline-none">
                    Tambah Cabang
                </button>
                <button
                    @click="activeTab = 'daftarcabang'"
                    :class="{'border-b-2 border-blue-500 text-blue-500': activeTab === 'daftarcabang'}"
                    class="px-4 py-2 font-medium text-gray-600 hover:text-blue-500 focus:outline-none">
                    Daftar Cabang
                </button>
                <button
                    @click="activeTab = 'pengaturanakun'"
                    :class="{'border-b-2 border-blue-500 text-blue-500': activeTab === 'pengaturanakun'}"
                    class="px-4 py-2 font-medium text-gray-600 hover:text-blue-500 focus:outline-none">
                    Pengaturan Password
                </button>
                @endif
                <button
                    @click="activeTab = 'pengaturanfoto'"
                    :class="{'border-b-2 border-blue-500 text-blue-500': activeTab === 'pengaturanfoto'}"
                    class="px-4 py-2 font-medium text-gray-600 hover:text-blue-500 focus:outline-none">
                    Profil Saya
                </button>
            </div>

            <!-- Account Settings -->
            @if(auth()->user() && auth()->user()->role === 'superadmin')
            <div x-show="activeTab === 'tambahcabang'" class="max-w-4xl mx-auto mt-10 p-8 bg-white shadow-lg rounded-lg">
                <!-- Header Pengaturan -->
                <h2 class="text-2xl font-bold text-gray-800 border-b pb-4 mb-6">Pengaturan - Tambah Cabang</h2>
                <form action="{{ route('setting.pop') }}" method="post" class="space-y-6">
                    @csrf
                    <!-- Kode POP -->
                    <div class="flex flex-col space-y-2">
                        <label for="kodepop" class="text-lg font-medium text-gray-700">Kode Cabang</label>
                        <input type="text" name="kodepop"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            oninput="this.value = this.value.toUpperCase()">
                        @error('kodepop')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                        @enderror
                        <p class="text-sm text-gray-500">*Kode Cabang sangat penting dan berpengaruh terhadap data yang tersimpan.</p>
                    </div>

                    <!-- Lokasi Kantor -->
                    <div class="flex flex-col space-y-2">
                        <label for="lokasikantor" class="text-lg font-medium text-gray-700">Kode Lokasi Cabang</label>
                        <input type="text" name="lokasikantor"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            oninput="this.value = this.value.toUpperCase()">
                        @error('lokasikantor')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex flex-col space-y-2">
                        <label for="alamatkantor" class="text-lg font-medium text-gray-700">Alamat Cabang</label>
                        <textarea name="alamatkantor" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        @error('alamatkantor')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2 bg-gradient-to-r from-blue-500 to-blue-700 text-white font-medium rounded-lg shadow-lg transform transition hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-400">
                            Simpan Kantor Layanan
                        </button>
                    </div>
                </form>
            </div>


            <!-- Preferences -->
            <div x-show="activeTab === 'daftarcabang'" class="space-y-6" x-cloak>
                <div class="container mx-auto p-4">
                    <h2 class="text-2xl font-semibold mb-4">Daftar Cabang</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border rounded-lg">
                            <thead>
                                <tr class="w-full bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                                    <th class="py-3 px-6 text-left">Kode Cabang</th>
                                    <th class="py-3 px-6 text-left">Lokasi</th>
                                    <th class="py-3 px-6 text-left">Alamat</th>
                                    <th class="py-3 px-6 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 text-sm font-light">
                                @foreach ($kantorlayanan as $item)
                                <tr class="border-b border-gray-200 hover:bg-gray-100">
                                    <td class="py-3 px-6 text-left">{{ $item->pop }}</td>
                                    <td class="py-3 px-6 text-left">{{ $item->lokasi }}</td>
                                    <td class="py-3 px-6 text-left">{{ $item->alamat }}</td>
                                    <td class="py-3 px-6 text-center">
                                        <div class="flex items-center justify-center space-x-4">
                                            <div x-data="{ openModal: false }">
                                                <!-- Tombol Update -->
                                                <a href="javascript:void(0)"
                                                    class="text-yellow-500 hover:text-yellow-700 focus:outline-none"
                                                    title="Update"
                                                    x-on:click="openModal = true">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                        <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                        <path d="M16 5l3 3" />
                                                    </svg>
                                                </a>
                                                <!-- Modal Pop-Up -->
                                                <div x-show="openModal"
                                                    @keydown.escape.window="openModal = false"
                                                    @click.self="openModal = false"
                                                    tabindex="-1"
                                                    aria-hidden="true"
                                                    x-transition:enter="transition-opacity ease-out duration-300"
                                                    x-transition:enter-start="opacity-0"
                                                    x-transition:enter-end="opacity-100"
                                                    x-transition:leave="transition-opacity ease-in duration-200"
                                                    x-transition:leave-start="opacity-100"
                                                    x-transition:leave-end="opacity-0"
                                                    class="fixed inset-0 flex justify-center items-center bg-black bg-opacity-50 z-50">

                                                    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                                                        <!-- Modal Header -->
                                                        <div class="flex justify-between items-center">
                                                            <h3 class="text-xl font-semibold text-gray-700">Update Kantor</h3>
                                                            <button @click="openModal = false" class="text-gray-500 hover:text-gray-700">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                    <path d="M6 18L18 6M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                                </svg>
                                                            </button>
                                                        </div>

                                                        <!-- Form untuk Update Data -->
                                                        <form method="POST" action="{{ route('setting.pop.update', $item->id) }}">
                                                            @csrf
                                                            @method('PUT')

                                                            <div class="mt-4">
                                                                <label for="kepalakantor" class="block text-sm font-medium text-gray-700">Kepala Kantor</label>
                                                                <input type="text" name="kepalakantor" id="kepalakantor" class="w-full border rounded-lg px-3 py-2" value="{{ $item->kepalakantor }}" required>
                                                            </div>

                                                            <div class="mt-4">
                                                                <label for="lokasi" class="block text-sm font-medium text-gray-700">Lokasi</label>
                                                                <input type="text" name="lokasi" id="lokasi" class="w-full border rounded-lg px-3 py-2" value="{{ $item->lokasi }}" required>
                                                            </div>

                                                            <div class="mt-4">
                                                                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                                                                <textarea name="alamat" id="alamat" class="w-full border rounded-lg px-3 py-2" required>{{ $item->alamat }}</textarea>
                                                            </div>

                                                            <div class="mt-4 flex justify-end space-x-4">
                                                                <button type="button" @click="openModal = false" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg">Batal</button>
                                                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Perbarui</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <form action="{{ route('setting.pop.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kantor ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700 focus:outline-none" title="Delete">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-x">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M18 6l-12 12" />
                                                        <path d="M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </form>

                                            <!-- Tombol Kelola User -->
                                            <div x-data="{ openUser: false }">
                                                <button class="text-blue-500 hover:text-blue-700 focus:outline-none" x-on:click="openUser = !openUser" title="Kelola User">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <circle cx="12" cy="12" r="9" />
                                                        <line x1="9" y1="12" x2="15" y2="12" />
                                                        <line x1="12" y1="9" x2="12" y2="15" />
                                                    </svg>
                                                </button>

                                                <!-- Modal Kelola User -->
                                                <div x-show="openUser"
                                                    @keydown.escape.window="openUser = false"
                                                    @click.self="openUser = false"
                                                    tabindex="-1"
                                                    aria-hidden="true"
                                                    class="bg-black bg-opacity-70 fixed inset-0 z-50 flex justify-center items-center w-full h-full"
                                                    x-transition:enter="transition-opacity ease-out duration-300"
                                                    x-transition:enter-start="opacity-0"
                                                    x-transition:enter-end="opacity-100"
                                                    x-transition:leave="transition-opacity ease-in duration-200"
                                                    x-transition:leave-start="opacity-100"
                                                    x-transition:leave-end="opacity-0">

                                                    <div class="relative p-4 w-full max-w-lg max-h-screen overflow-y-auto">
                                                        <!-- Konten Modal -->
                                                        <div class="relative bg-white rounded-lg shadow-lg max-h-full overflow-y-auto">
                                                            <!-- Header Modal -->
                                                            <div class="flex items-center justify-between p-5 border-b border-gray-200 rounded-t">
                                                                <h3 class="text-xl font-semibold text-gray-700">
                                                                    Daftar User - {{ $item->pop }}
                                                                </h3>
                                                                <button type="button" x-on:click="openUser = false" class="text-gray-500 hover:bg-gray-200 hover:text-gray-700 rounded-lg text-sm w-8 h-8 flex justify-center items-center">
                                                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" />
                                                                    </svg>
                                                                </button>
                                                            </div>

                                                            <!-- Body Modal -->
                                                            <div x-data="{ openUser: false }" class="p-6 space-y-6 max-h-[80vh] overflow-y-auto">
                                                                <!-- Tombol Buka Form -->
                                                                <div class="flex justify-between items-center bg-white shadow-md p-4 rounded-lg">
                                                                    <h3 class="text-2xl font-bold text-gray-800">Daftar User</h3>
                                                                    <button
                                                                        x-on:click="openUser = !openUser"
                                                                        class="px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-700 text-white font-medium rounded-lg shadow-lg transform transition hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-400">
                                                                        + Tambah User
                                                                    </button>
                                                                </div>


                                                                <!-- Tabel User -->
                                                                <div class="overflow-auto max-h-60 border rounded-lg bg-gray-100 shadow-lg">
                                                                    <table class="w-full bg-white border rounded-lg">
                                                                        <!-- Header -->
                                                                        <thead class="sticky top-0 bg-gray-900 text-white">
                                                                            <tr class="text-sm uppercase">
                                                                                <th class="py-3 px-6 text-left">Username</th>
                                                                                <th class="py-3 px-6 text-left">Password</th>
                                                                                <th class="py-3 px-6 text-left">Role</th>
                                                                                <th class="py-3 px-6 text-center">Status</th>
                                                                                <th class="py-3 px-6 text-center">Aksi</th>
                                                                            </tr>
                                                                        </thead>

                                                                        <!-- Body -->
                                                                        <tbody class="text-sm text-gray-700 divide-y divide-gray-200">
                                                                            @foreach ($kl_users->where('pop', $item->pop)->groupBy('pop') as $pop => $users)
                                                                            @foreach ($users as $user)
                                                                            <tr class="hover:bg-gray-100 transition">
                                                                                <!-- Username -->
                                                                                <td class="py-3 px-6 font-medium text-gray-900">{{ $user->username }}</td>

                                                                                <!-- Password -->
                                                                                <td class="py-3 px-6" x-data="{ showPassword: false }">
                                                                                    <div class="flex items-center space-x-2">
                                                                                        <!-- Password (Hidden / Shown) -->
                                                                                        <span x-show="!showPassword" class="tracking-widest text-gray-500">
                                                                                            {{ str_repeat('*', strlen($user->password)) }}
                                                                                        </span>
                                                                                        <span x-show="showPassword">{{ $user->password }}</span>

                                                                                        <!-- Toggle Button -->
                                                                                        <button type="button" x-on:click="showPassword = !showPassword" class="focus:outline-none">
                                                                                            <svg x-show="!showPassword" class="h-5 w-5 text-gray-500 hover:text-gray-700 transition" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18M10.585 10.587a2 2 0 0 0 2.829 2.828M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6 1.272-2.12 2.712-3.678 4.32-4.674m2.86-1.146a9.055 9.055 0 0 1 1.82-.18c3.6 0 6.6 2 9 6-.666 1.11-1.379 2.067-2.138 2.87" />
                                                                                            </svg>
                                                                                            <svg x-show="showPassword" class="h-5 w-5 text-gray-500 hover:text-gray-700 transition" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0M21 12c-2.4 4 -5.4 6 -9 6-3.6 0 -6.6 -2 -9 -6 2.4-4 5.4-6 9-6 3.6 0 6.6 2 9 6" />
                                                                                            </svg>
                                                                                        </button>
                                                                                    </div>
                                                                                </td>

                                                                                <!-- Role -->
                                                                                <td class="py-3 px-6 capitalize">{{ $user->role }}</td>

                                                                                <!-- Status -->
                                                                                <td class="py-3 px-6 text-center">


                                                                                    <div class="inline-block px-6 py-2 rounded-md w-auto min-w-[160px]">
                                                                                        <!-- Label Status -->
                                                                                        <span class="block text-sm font-semibold px-3 py-1 rounded-md 
            {{ $user->status === 'Aktif' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                                                                                            {{ $user->status }}
                                                                                        </span>

                                                                                        <!-- Last Active Date -->
                                                                                        <p class="mt-1 text-gray-700 text-sm whitespace-nowrap">Last active: {{ $user->last_login ? $user->last_login->format('d F') : 'Belum login' }}
                                                                                        </p>
                                                                                    </div>
                                                                                </td>

                                                                                <!-- Aksi -->
                                                                                <td class="py-3 px-6 text-center">
                                                                                    <form action="{{ route('destroy.user', ['id' => $user->id, 'username' => $user->username, 'password' => $user->password]) }}"
                                                                                        method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                                                                        @csrf
                                                                                        @method('DELETE')

                                                                                        <button type="submit" class="p-2 bg-red-100 rounded-full hover:bg-red-200 transition">
                                                                                            <svg class="h-6 w-6 text-red-500 hover:text-red-700 transition" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 6l12 12M18 6l-12 12" />
                                                                                            </svg>
                                                                                        </button>
                                                                                    </form>
                                                                                </td>
                                                                            </tr>
                                                                            @endforeach
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>


                                                                <!-- Form Tambah User -->
                                                                <div
                                                                    x-show="openUser"
                                                                    x-cloak
                                                                    x-transition:enter="transition ease-out duration-300"
                                                                    x-transition:enter-start="opacity-0"
                                                                    x-transition:enter-end="opacity-100"
                                                                    x-transition:leave="transition ease-in duration-200"
                                                                    x-transition:leave-start="opacity-100"
                                                                    x-transition:leave-end="opacity-0"
                                                                    class="border rounded-lg bg-white p-4 shadow-md max-h-[80vh] overflow-y-auto">
                                                                    <form method="POST" action="{{ route('add.user') }}" class="bg-white shadow-lg rounded-xl p-6 space-y-4">
                                                                        @csrf
                                                                        <input type="hidden" name="kantor_id" value="{{ $item->pop }}">

                                                                        <h2 class="text-2xl font-bold text-gray-800 text-center">Tambah User</h2>

                                                                        <div class="space-y-4">
                                                                            <!-- Username -->
                                                                            <div>
                                                                                <label class="block text-sm font-semibold text-gray-700">Username</label>
                                                                                <input type="text" name="username" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                                                                @error('username')
                                                                                <span class="text-xs text-red-500">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>

                                                                            <!-- Password -->
                                                                            <div x-data="{ showPassword: false }">
                                                                                <label class="block text-sm font-semibold text-gray-700">Password</label>
                                                                                <div class="relative">
                                                                                    <input :type="showPassword ? 'text' : 'password'" name="password" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                                                                    <button type="button"
                                                                                        x-on:click="showPassword = !showPassword"
                                                                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                                                                        <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off">
                                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                                            <path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" />
                                                                                            <path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" />
                                                                                            <path d="M3 3l18 18" />
                                                                                        </svg>
                                                                                        <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                                                        </svg>
                                                                                    </button>
                                                                                </div>
                                                                                @error('password')
                                                                                <span class="text-xs text-red-500">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>

                                                                            <!-- Konfirmasi Password -->
                                                                            <div x-data="{ showPassword: false }">
                                                                                <label class="block text-sm font-semibold text-gray-700">Konfirmasi Password</label>
                                                                                <div class="relative">
                                                                                    <input :type="showPassword ? 'text' : 'password'" name="password_confirmation" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                                                                    <button type="button"
                                                                                        x-on:click="showPassword = !showPassword"
                                                                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                                                                        <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye-off">
                                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                                            <path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" />
                                                                                            <path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" />
                                                                                            <path d="M3 3l18 18" />
                                                                                        </svg>
                                                                                        <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                                                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                                                                        </svg>
                                                                                    </button>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Role -->
                                                                            <div>
                                                                                <label class="block text-sm font-semibold text-gray-700">Role</label>
                                                                                <select name="role" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                                                                    <option value="admin">Admin</option>
                                                                                    <option value="user">User</option>
                                                                                </select>
                                                                                @error('role')
                                                                                <span class="text-xs text-red-500">{{ $message }}</span>
                                                                                @enderror
                                                                            </div>
                                                                        </div>

                                                                        <!-- Tombol Aksi -->
                                                                        <div class="mt-4 flex justify-end space-x-3">
                                                                            <button x-on:click="openUser = false" type="button" class="px-5 py-2 text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
                                                                                Batal
                                                                            </button>
                                                                            <button type="submit" class="px-5 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                                                                                Tambahkan
                                                                            </button>
                                                                        </div>
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div x-show="activeTab === 'pengaturanakun'" class="space-y-6" x-cloak>
                <div class="container mx-auto p-8">
                    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-lg p-6">
                        <h2 class="text-2xl font-semibold text-gray-700 mb-6">Pengaturan Akun</h2>
                        <!-- Form Ganti Password -->
                        <form action="{{ route('password.update') }}" method="POST" class="space-y-4">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-600">Password Lama</label>
                                <input type="text" id="current_password" name="current_password" class="mt-1 block w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                                @error('current_password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="new_password" class="block text-sm font-medium text-gray-600">Password Baru</label>
                                <input type="text" id="new_password" name="new_password" class="mt-1 block w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                                @error('new_password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="new_password_confirmation" class="block text-sm font-medium text-gray-600">Konfirmasi Password Baru</label>
                                <input type="text" id="new_password_confirmation" name="new_password_confirmation" class="mt-1 block w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                                @error('new_password_confirmation')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-blue-500 to-blue-700 text-white font-medium rounded-lg shadow-lg transform transition hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-400">Ganti Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
            <div x-show="activeTab === 'pengaturanfoto'" class="space-y-6" x-cloak>
                <div class="container mx-auto p-8">
                    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-lg p-6" x-data="{ imagePreview: '{{ auth()->user()->profile_picture_url }}' }">
                        <h2 class="text-2xl font-semibold text-gray-700 mb-6">Pengaturan Akun</h2>
                        @if(auth()->user() && auth()->user()->role === 'superadmin')
                        <div class="mb-16">
                            <!-- Form Ganti Username -->
                            <form action="{{ route('username.update') }}" method="POST" class="space-y-4">
                                @csrf
                                @method('PUT')
                                <div>
                                    <label for="username" class="block text-sm font-medium text-gray-600">Username</label>
                                    <input type="text" id="username" name="username" value="{{ auth()->user()->username }}" class="mt-1 block w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                                </div>
                                <div>
                                    <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-blue-500 to-blue-700 text-white font-medium rounded-lg shadow-lg transform transition hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-400">Ganti Username</button>
                                </div>
                            </form>
                        </div>
                        @endif
                        <!-- Form Ganti Foto Profil -->
                        <form action="{{ route('profile_picture.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4"
                            x-data="{ imagePreview: '{{ $foto_profile ? asset('storage/' . $foto_profile) : null }}', fileSelected: false }">
                            @csrf
                            <!-- Menampilkan Foto Profil yang sudah ada dan Preview Gambar -->
                            <div class="flex justify-center items-center">
                                <div class="relative">
                                    <!-- Gambar Preview -->
                                    <img x-show="imagePreview" :src="imagePreview" class="w-32 h-32 rounded-full object-cover shadow-lg" alt="Foto Profil">

                                    <!-- Jika tidak ada foto, tampilkan ikon default -->
                                    <template x-if="!imagePreview">
                                        <svg class="w-40 h-40 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd" />
                                        </svg>
                                    </template>

                                    <!-- Button untuk memilih gambar -->
                                    <label for="profile_picture" class="absolute bottom-0 right-0 bg-indigo-600 text-white rounded-full w-8 h-8 flex items-center justify-center cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                            <path d="M16 5l3 3" />
                                        </svg>
                                    </label>

                                    <!-- Input file untuk memilih gambar -->
                                    <input type="file" id="profile_picture" name="profile_picture" class="hidden" accept="image/*"
                                        x-on:change="imagePreview = URL.createObjectURL($event.target.files[0]); fileSelected = true;">
                                </div>
                            </div>
                            @error('profile_picture')
                            <div class="flex justify-center">
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            </div>
                            @enderror

                            <!-- Tombol Submit -->
                            <div class="mt-4">
                                <button type="submit"
                                    class="w-full py-3 px-4 bg-gradient-to-r from-blue-500 to-blue-700 text-white font-medium rounded-lg shadow-lg transform transition hover:scale-105 hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-blue-400 
                                            transition disabled:opacity-50 disabled:cursor-not-allowed"
                                    x-bind:disabled="!fileSelected"
                                    x-text="fileSelected ? 'Ganti Foto Profil' : 'Pilih Foto Profil'">
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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


    @if(session('success'))
    <div x-data="{ isOpen: true }" x-init="setTimeout(() => isOpen = false, 3000)">
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
</body>

</html>