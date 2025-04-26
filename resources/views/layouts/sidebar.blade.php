<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <!-- <script src="https://cdn.jsdelivr.net/npm/@ryangjchandler/alpine-clipboard@2.x.x/dist/alpine-clipboard.js" defer></script> -->
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-body" x-data="{ isSidebarOpen: true }">
    <nav class="bg-[#0F0606] shadow-lg fixed top-0 w-full left-0 z-30">
        <div class="w-full px-4 relative flex justify-end h-16 items-center">
            @if(auth()->user() && auth()->user()->role === 'admin')
            <div x-data="{ open: false }" class="relative inline-block">
                <button type="button" x-on:click="open = ! open" data-dropdown-toggle="notification-dropdown" class="relative p-2 mr-1 text-gray-500 rounded-lg hover:text-white hover:bg-gray-700" title="Notifikasi">
                    <!-- ikon bel -->
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                    </svg>

                    <!-- Angka Notifikasi -->
                    @if($barangKurangCount > 0)
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center w-4 h-4 text-xs font-bold leading-none text-black bg-orange-400 rounded-full">
                        {{ $barangKurangCount }}
                    </span>
                    @endif
                </button>


                <!-- Main modal -->
                <div x-show="open" @keydown.escape.window="open = false" @click.self="open = false" class="w-96 md:w-full fixed -mt-10 md:mt-2 z-50 flex justify-end left-28 md:left-12 md:inset-0"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-4">
                    <div class="w-64 mr-[100px] mobile:mr-[50px] mt-14 z-50 mobile:shadow-lg">
                        <!-- Modal content -->
                        <div class="relative w-full rounded-lg shadow-2xl bg-[#F3F4F6]">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between px-5 py-3 border-b border-gray-200 rounded-t bg-gray-100">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-blue-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-info-circle">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                        <path d="M12 9h.01" />
                                        <path d="M11 12h1v4h1" />
                                    </svg>
                                    Notification
                                </h3>
                            </div>
                            <!-- Modal body -->
                            <div class="p-4 text-sm max-h-64 overflow-y-auto">
                                <div class="max-h-48 overflow-y-auto">
                                    @foreach($barangKurang as $pop => $items)
                                    @foreach($items as $item)
                                    <div class="flex items-start p-3 border-b last:border-none transition-all hover:bg-gray-50">
                                        <img src="{{ asset('storage/' . $item->foto) }}" class="w-10 h-10 rounded-md shadow" alt="">
                                        <div class="ml-4">
                                            <p class="text-gray-800 font-semibold text-sm">{{ $item->nama_barang }} - {{ $item->seri }}</p>
                                            <p class="text-gray-500 text-xs">
                                                Barang tersisa {{ $item->jumlah }}
                                                @if ($item->satuan == 'roll')
                                                roll - {{ $item->hasil }} meter
                                                @elseif ($item->satuan == 'pack')
                                                pack - {{ $item->hasil }} pcs
                                                @else
                                                {{ $item->satuan }}
                                                @endif
                                            </p>
                                            <p class="text-gray-400 text-xs mt-1">{{ $item->waktu }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endforeach

                                </div>
                                @if($barangKurangCount > 0)
                                <a href="{{ route('request_barang') }}" class="flex items-center text-gray-500 hover:underline">Tambah</a>
                                @endif
                                <div x-data="{ open: false }">
                                    <button type="button" x-on:click="open = ! open" class="flex items-center text-gray-500 hover:underline">Notification Settings</button>
                                    <!-- Main modal -->
                                    <div x-show="open" tabindex="-1" x-transition.opacity.duration.300ms aria-hidden="true" class="fixed inset-0 z-50 mt-16 flex justify-center w-full max-h-full bg-black bg-opacity-50">
                                        <div class="fixed w-full max-w-[300px] max-h-full mobile:max-w-[250px] ">
                                            <!-- Modal content -->
                                            <div class="relative rounded-b-lg shadow bg-[#0F0606]">
                                                <!-- Modal header -->
                                                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-600">
                                                    <h3 class="text-lg font-semibold text-gray-900 text-white">
                                                        Notification Settings
                                                    </h3>
                                                    <button type="button" x-on:click="open = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center hover:bg-gray-600 hover:text-white" data-modal-toggle="crud-modal">
                                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                        </svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                </div>
                                                <!-- Modal body -->
                                                <form action="{{ route('notification.update') }}" method="POST" class="p-4 md:p-5">
                                                    @csrf
                                                    <div class="grid gap-4 mb-4 grid-cols-1">
                                                        <div class="col-span-2 sm:col-span-1">
                                                            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 text-white">Roll</label>
                                                            <input type="number" oninput="this.value = this.value.replace(/[^0-9]/g, '');" min="1" name="roll" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-gray-600 border-gray-500 placeholder-gray-400 text-white focus:ring-primary-500 focus:border-primary-500" required="">
                                                        </div>
                                                        <div class="col-span-2 sm:col-span-1">
                                                            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 text-white">Pack</label>
                                                            <input type="number" oninput="this.value = this.value.replace(/[^0-9]/g, '');" min="1" name="pack" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-gray-600 border-gray-500 placeholder-gray-400 text-white focus:ring-primary-500 focus:border-primary-500" required="">
                                                        </div>
                                                        <div class="col-span-2 sm:col-span-1">
                                                            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 text-white">Pcs & Unit</label>
                                                            <input type="number" oninput="this.value = this.value.replace(/[^0-9]/g, '');" min="1" name="unit" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-gray-600 border-gray-500 placeholder-gray-400 text-white focus:ring-primary-500 focus:border-primary-500" required="">
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-800">
                                                        Save
                                                    </button>
                                                </form>
                                                <form action="{{ route('notification.reset') }}" method="GET" class="px-4 md:px-5">
                                                    @csrf
                                                    <!-- Reset Button -->
                                                    <button name="submit" class="text-black inline-flex items-center bg-gray-400 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-600 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                                                        Reset
                                                    </button>
                                                    <p class="text-sm text-gray-400 m-2">
                                                        *Reset ini akan mengubah nilai default notifikasi menjadi <strong>5</strong>.
                                                    </p>
                                                    <br>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if(auth()->user() && auth()->user()->role === 'superadmin')
            <div x-data="{ open: false }" class="relative inline-block">
                <button type="button" x-on:click="open = ! open" data-dropdown-toggle="notification-dropdown" class="relative p-2 mr-8 text-gray-500 rounded-lg hover:text-white hover:bg-gray-700" title="Notifikasi">
                    <!-- ikon bel -->
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                    </svg>

                    <!-- Angka Notifikasi -->
                    @if($data_tergabung_count > 0)
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center w-4 h-4 text-xs font-bold leading-none text-black bg-orange-400 rounded-full">
                        {{ $data_tergabung_count }}
                    </span>
                    @endif
                </button>


                <!-- Main modal -->
                <div x-show="open" @keydown.escape.window="open = false" @click.self="open = false" class="w-96 md:w-full fixed -mt-10 md:mt-2 z-50 flex justify-end left-28 md:left-12 md:inset-0"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-4"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-4">
                    <div class="w-64 mr-[100px] mobile:mr-[50px] mt-14 z-50 mobile:shadow-lg">
                        <!-- Modal content -->
                        <div class="relative w-full rounded-lg shadow-2xl bg-[#F3F4F6]">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between py-2 pl-7 border-b rounded-t border-gray-600">
                                <h3 class="text-lg font-semibold text-gray-900 ">
                                    Notification
                                </h3>
                            </div>
                            <!-- Modal body -->
                            <div class="p-4 md:p-5 text-sm shadow-inner">
                                <div class="max-h-48 overflow-y-auto">
                                    <!-- Menampilkan data menunggu_pengiriman -->
                                    @foreach($data_tergabung as $item)
                                    <ul class="space-y-4 mb-4 pb-2 border-b">
                                        <li class="flex items-start">
                                            <div class="block ml-5">
                                                <div class="w-full p-0 text-gray-700 font-semibold text-[13px]">
                                                    {{ $item->tujuan }} - {{ $item->tujuan_lokasi }}
                                                </div>
                                                <div class="w-full text-gray-400 text-[10px]">{{ $item->status }}</div>
                                                <div class="w-full text-gray-400 text-[10px]">{{ $item->waktu }}</div>
                                            </div>
                                        </li>
                                    </ul>
                                    @endforeach
                                </div>
                                @if($data_tergabung_count > 0)
                                <div class="flex inline-flex space-x-4">
                                    <a href="{{ route('pengiriman_barang.superadmin') }}" class="flex items-center text-gray-500 hover:underline">Update</a>
                                    <a href="{{ route('pengiriman_barang.input.superadmin') }}" class="flex items-center text-gray-500 hover:underline">Input</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if(auth()->user() && auth()->user()->role === 'user')
            <div class="relative inline-block p-2 flex justify-center items-center text-gray-500 rounded-lg h-10 hover:text-gray-900 hover:bg-gray-100 text-gray-400 hover:text-white hover:bg-gray-700" title="Permintaan Akses">
                <a href="javascript:void(0);" onclick="submitRequest()">
                    <svg class="w-7 h-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2" d="M7 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h1m4-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm7.441 1.559a1.907 1.907 0 0 1 0 2.698l-6.069 6.069L10 19l.674-3.372 6.07-6.07a1.907 1.907 0 0 1 2.697 0Z" />
                    </svg>
                </a>
            </div>
            @endif



            @if(auth()->user() && auth()->user()->role === 'admin' && !auth()->user()->request_access)
            <div x-data="{ open: false }">
                <div class="relative inline-block p-2 flex justify-center items-center text-gray-500 rounded-lg h-10 hover:text-gray-900 hover:bg-gray-100 text-gray-400 hover:text-white hover:bg-gray-700" title="Permintaan Akses Admin Pengguna">
                    <button x-on:click="open = ! open">
                        <svg class="w-7 h-7" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2" d="M10 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h2m10 1a3 3 0 0 1-3 3m3-3a3 3 0 0 0-3-3m3 3h1m-4 3a3 3 0 0 1-3-3m3 3v1m-3-4a3 3 0 0 1 3-3m-3 3h-1m4-3v-1m-2.121 1.879-.707-.707m5.656 5.656-.707-.707m-4.242 0-.707.707m5.656-5.656-.707.707M12 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>

                        @if($request_access_count > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center w-4 h-4 text-xs font-bold leading-none text-black bg-orange-400 rounded-full">
                            {{ $request_access_count }}
                        </span>
                        @endif
                    </button>

                    <!-- Main modal -->
                    <div x-show="open"
                        x-transition:enter="transition-opacity ease-out duration-300"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition-opacity ease-in duration-200"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        @keydown.escape.window="open = false"
                        @click.self="open = false"
                        tabindex="-1" aria-hidden="true" class="fixed top-0 right-0 left-0 z-50 flex justify-center w-full h-full bg-black bg-opacity-70">
                        <div class="relative p-4 w-full max-w-md max-h-full mobile:w-64 top-16">
                            <!-- Modal content -->
                            <div class="relative rounded-lg shadow bg-white">
                                <!-- Modal header -->
                                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-600">
                                    @if($request_access->isNotEmpty())
                                    <h3 class="text-lg font-semibold text-gray-900 text-black">
                                        Permintaan Akses Admin Pengguna
                                    </h3>
                                    @elseif($request_access->isEmpty())
                                    <p class="text-center text-gray-500 text-gray-300">Tidak ada pengguna yang meminta akses admin.</p>
                                    @endif
                                    <button type="button" x-on:click="open = false" class="text-gray-400 bg-transparent hover:text-gray-900 rounded-lg text-sm h-8 w-8 ms-auto inline-flex justify-center items-center hover:scale-125 transition-transform duration-200">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                @foreach($request_access as $pop => $users)
                                @foreach($users as $item)
                                <div class="p-4 md:p-5">
                                    <p class="text-[10px] text-gray-500 text-gray-400">Pengguna berikut telah mengajukan permintaan untuk mendapatkan akses admin. Silakan tinjau permintaan ini dan beri persetujuan atau tolak berdasarkan kebutuhan dan kriteria akses.</p>
                                    <ul class="my-4 space-y-3">
                                        <li class="flex items-center justify-between p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow bg-gray-600 hover:bg-gray-500 text-white">
                                            <p class="text-white">{{ $item->username }}</p>

                                            <div class="flex items-center space-x-4">
                                                <label for="toggleThree{{ $item->kl_user_id }}" class="flex items-center cursor-pointer select-none text-dark text-white">
                                                    <div x-data="{ isChecked: {{ $item->role === 'admin' ? 'true' : 'false' }} }" class="relative">
                                                        <input
                                                            type="checkbox"
                                                            :id="'toggleThree' + {{ $item->kl_user_id }}"
                                                            class="peer sr-only"
                                                            x-model="isChecked"
                                                            @change="toggleAccess({{ $item->kl_user_id }}, isChecked)" />

                                                        <div class="block h-6 rounded-full bg-gray-300 bg-dark-200 w-10 peer-checked:bg-blue-500 transition"></div>

                                                        <div
                                                            class="absolute flex items-center justify-center w-4 h-4 transition bg-white rounded-full dot bg-dark-500 left-1 top-1"
                                                            :class="{ 'translate-x-full bg-blue-700': isChecked, 'bg-white': !isChecked }">

                                                            <!-- Icon Aktif (Checkbox diaktifkan) -->
                                                            <template x-if="isChecked">
                                                                <svg width="8" height="6" viewBox="0 0 8 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M7.0915 0.951972L7.0867 0.946075L7.0813 0.940568C6.90076 0.753564 6.61034 0.753146 6.42927 0.939309L3.16201 4.22962L1.58507 2.63469C1.40401 2.44841 1.11351 2.44879 0.932892 2.63584C0.755703 2.81933 0.755703 3.10875 0.932892 3.29224L0.932878 3.29225L0.934851 3.29424L2.58046 4.95832C2.73676 5.11955 2.94983 5.2 3.1473 5.2C3.36196 5.2 3.55963 5.11773 3.71406 4.9584L7.0468 1.60234C7.2436 1.4199 7.2421 1.1339 7.0915 0.951972ZM3.2327 5.30081L3.2317 5.2998C3.23206 5.30015 3.23237 5.30049 3.23269 5.30082L3.2327 5.30081Z" fill="white" stroke="white" stroke-width="0.4" />
                                                                </svg>
                                                            </template>

                                                            <!-- Icon Tidak Aktif (Checkbox tidak diaktifkan) -->
                                                            <template x-if="!isChecked">
                                                                <svg class="w-3 h-3 stroke-current" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                            </template>
                                                        </div>
                                                    </div>
                                                </label>
                                                <form action="{{ route('admin.delete.access', ['id' => $item->kl_user_id]) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="p-1 rounded-full text-red-500 hover:text-red-700 hover:bg-red-200 bg-red-100 transition">
                                                        <svg class="w-3 h-3 stroke-current" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>

                                        </li>
                                    </ul>
                                </div>
                                @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </nav>

    <aside :class="{'w-60': isSidebarOpen, 'w-20': !isSidebarOpen}"
        class="fixed top-0 left-0 z-50 h-screen transition-all duration-300 ease-in-out text-sm flex flex-col justify-between bg-gray-900 overflow-hidden shadow-lg"
        aria-label="Sidebar">
        <div class="h-full px-3 py-2 overflow-y-auto bg-[#0F0606] flex-grow">
            <div class="flex items-center py-2.5 px-2 gap-3 w-full">
                @if ($foto_profile)
                <img src="/storage/{{ $foto_profile }}" alt="Profile Picture" class="w-9 h-9 mobile:w-4.5 mobile:h-4.5 rounded-full object-cover">
                @else
                <svg class="w-9 h-9 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z" clip-rule="evenodd" />
                </svg>
                @endif
                <div class="flex items-center justify-between w-full">
                    <a href="{{ url('/settings') }}"
                        class="flex flex-col transition-all duration-300 ease-in-out"
                        :class="{'opacity-0 scale-95 w-0 overflow-hidden': !isSidebarOpen, 'opacity-100 scale-100 w-auto': isSidebarOpen}">
                        <p class="text-white px-2 whitespace-nowrap capitalize text-[12px] font-semibold">
                            {{ Auth::user()->username }}
                        </p>
                        <p class="px-2 py-0.5 text-[10px] rounded-full w-max shadow-sm font-medium
                            {{ Auth::user()->role == 'admin' ? 'text-red-500' : 
                            (Auth::user()->role == 'superadmin' ? 'text-blue-500' : 'text-gray-500') }}" title="Role">
                            {{ Auth::user()->role == 'admin' ? 'Admin' : (Auth::user()->role == 'superadmin' ? 'Superadmin' : 'User') }}
                        </p>
                    </a>

                    <!-- Ikon Toggle Sidebar -->
                    <svg :class="{'rotate-180': isSidebarOpen}" xmlns="http://www.w3.org/2000/svg"
                        @click="isSidebarOpen = !isSidebarOpen"
                        class="w-6 h-6 text-gray-300 hover:text-white transition-transform duration-300 ease-in-out transform hover:scale-110 active:scale-95 cursor-pointer"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" title="Buka/Tutup Menu">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M5 12l14 0" />
                        <path d="M13 18l6 -6" />
                        <path d="M13 6l6 6" />
                    </svg>
                </div>
            </div>

            <ul class="space-y-2 font-medium">
                @if(auth()->user() && auth()->user()->role !== 'superadmin')
                <li title="Dashboard">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center p-2 rounded-lg text-white 
                        {{ request()->routeIs('dashboard') ? 'border-l-4 border-red-700 bg-gradient-to-r from-red-500' : 'bg-[#0F0606] hover:bg-gray-600' }}">
                        <svg class="w-8 h-8 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z" clip-rule="evenodd" />
                        </svg>
                        <span :class="{'hidden': !isSidebarOpen}" class="ms-3 whitespace-nowrap">Dashboard</span>
                    </a>
                </li>
                <div x-data="{ openDropdown1: false, openDropdown2: false, openDropdown3: false }">
                    @if(auth()->user() && auth()->user()->role === 'admin' && (auth()->user()->request_access === 0 || auth()->user()->request_access === 1))
                    <li class="mb-2" title="Barang Masuk">
                        <div class="rounded-lg text-white">
                            <button @click="openDropdown1 = !openDropdown1; if (!isSidebarOpen) { isSidebarOpen = true;}" class="flex items-center w-full px-2 py-2 rounded-lg {{ request()->routeIs('input_barang_masuk.view') || request()->routeIs('tabel_barang_masuk') ? 'border-l-4 border-red-700 bg-gradient-to-r from-red-500' : 'bg-[#0F0606] hover:bg-gray-600' }}">
                                <svg class="flex-shrink-0 w-10 h-10 mobile:h-8 mobile:w-8 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M5.027 10.9a8.729 8.729 0 0 1 6.422-3.62v-1.2A2.061 2.061 0 0 1 12.61 4.2a1.986 1.986 0 0 1 2.104.23l5.491 4.308a2.11 2.11 0 0 1 .588 2.566 2.109 2.109 0 0 1-.588.734l-5.489 4.308a1.983 1.983 0 0 1-2.104.228 2.065 2.065 0 0 1-1.16-1.876v-.942c-5.33 1.284-6.212 5.251-6.25 5.441a1 1 0 0 1-.923.806h-.06a1.003 1.003 0 0 1-.955-.7A10.221 10.221 0 0 1 5.027 10.9Z" />
                                </svg>
                                <span :class="{'hidden': !isSidebarOpen}" class="ms-1 whitespace-nowrap">Barang Masuk</span>
                                <svg :class="{'rotate-180': openDropdown1}, {'hidden': !isSidebarOpen}" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ms-10 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 15l-7-7-7 7" />
                                </svg>
                            </button>
                            <ul x-show="openDropdown1" @click.away="openDropdown1 = false" class="left-0 top-full mt-2 rounded-md shadow-lg w-full transition-all duration-800 ease-in-out">
                                <li><a href="{{ route('input_barang_masuk.view') }}" @click="isSidebarOpen = false" class="block px-4 py-2 text-white hover:bg-gray-600 rounded-md">Input</a></li>
                                <li><a href="{{ route('tabel_barang_masuk') }}" @click="isSidebarOpen = false" class="block px-4 py-2 text-white hover:bg-gray-600 rounded-md">Data</a></li>
                            </ul>
                        </div>
                    </li>
                    <li title="Permintaan Barang">
                        <a href="{{ route('request_barang') }}"
                            class="flex items-center p-2 rounded-lg text-white 
                        {{ request()->routeIs('request_barang') ? 'border-l-4 border-red-700 bg-gradient-to-r from-red-500' : 'bg-[#0F0606] hover:bg-gray-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler w-9 h-9 mobile:h-7 mobile:w-7 icons-tabler-outline icon-tabler-pointer-question">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15.062 12.506l-.284 -.284l3.113 -2.09a1.2 1.2 0 0 0 -.309 -2.228l-13.582 -3.904l3.904 13.563a1.2 1.2 0 0 0 2.228 .308l2.09 -3.093l1.278 1.278" />
                                <path d="M19 22v.01" />
                                <path d="M19 19a2.003 2.003 0 0 0 .914 -3.782a1.98 1.98 0 0 0 -2.414 .483" />
                            </svg>
                            <span :class="{'hidden': !isSidebarOpen}" class="flex-1 ms-3 whitespace-nowrap">Permintaan Barang</span>
                        </a>
                    </li>
                    @endif
                    <li title="Barang Keluar">
                        <div class="rounded-lg text-white">
                            <button @click="openDropdown2 = !openDropdown2; if (!isSidebarOpen) { isSidebarOpen = true;}" class="flex items-center w-full px-2 py-2 mt-2 rounded-lg {{ request()->routeIs('input_barang_keluar') || request()->routeIs('tabel_barang_keluar') ? 'border-l-4 border-red-700 bg-gradient-to-r from-red-500' : 'bg-[#0F0606] hover:bg-gray-600' }}">
                                <svg class="flex-shrink-0 w-10 h-10 mobile:w-8 mobile:h-8 text-blue-800 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14.502 7.046h-2.5v-.928a2.122 2.122 0 0 0-1.199-1.954 1.827 1.827 0 0 0-1.984.311L3.71 8.965a2.2 2.2 0 0 0 0 3.24L8.82 16.7a1.829 1.829 0 0 0 1.985.31 2.121 2.121 0 0 0 1.199-1.959v-.928h1a2.025 2.025 0 0 1 1.999 2.047V19a1 1 0 0 0 1.275.961 6.59 6.59 0 0 0 4.662-7.22 6.593 6.593 0 0 0-6.437-5.695Z" />
                                </svg>
                                <span :class="{'hidden': !isSidebarOpen}" class="flex-1 ms-3 whitespace-nowrap">Barang Keluar</span>
                                <svg :class="{'rotate-180': openDropdown2}, {'hidden': !isSidebarOpen}" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ms-10 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 15l-7-7-7 7" />
                                </svg>
                            </button>
                            <ul x-show="openDropdown2" @click.away="openDropdown2 = false" class="left-0 top-full mt-2 rounded-md shadow-lg w-full">
                                <li><a href="{{ route('input_barang_keluar') }}" @click="isSidebarOpen = false" class="block px-4 py-2 text-white hover:bg-gray-600 rounded-md text-sm">Input</a></li>
                                <li><a href="{{ route('tabel_barang_keluar') }}" @click="isSidebarOpen = false" class="block px-4 py-2 text-white hover:bg-gray-600 rounded-md text-sm">Data</a></li>
                            </ul>
                        </div>
                    </li>

                    <li title="Barang Rusak">
                        <div class="rounded-lg text-white">
                            <button @click="openDropdown3 = !openDropdown3; if (!isSidebarOpen) { isSidebarOpen = true;}" class="flex items-center w-full px-2 py-2 mt-2 rounded-lg {{ request()->routeIs('input_barang_rusak') || request()->routeIs('tabel_barang_rusak') ? 'border-l-4 border-red-700 bg-gradient-to-r from-red-500' : 'bg-[#0F0606] hover:bg-gray-600' }}">
                                <svg class="flex-shrink-0 w-10 h-10 mobile:w-8 mobile:h-8 text-blue-800 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14.502 7.046h-2.5v-.928a2.122 2.122 0 0 0-1.199-1.954 1.827 1.827 0 0 0-1.984.311L3.71 8.965a2.2 2.2 0 0 0 0 3.24L8.82 16.7a1.829 1.829 0 0 0 1.985.31 2.121 2.121 0 0 0 1.199-1.959v-.928h1a2.025 2.025 0 0 1 1.999 2.047V19a1 1 0 0 0 1.275.961 6.59 6.59 0 0 0 4.662-7.22 6.593 6.593 0 0 0-6.437-5.695Z" />
                                </svg>
                                <span :class="{'hidden': !isSidebarOpen}" class="flex-1 ms-3 whitespace-nowrap">Barang Rusak</span>
                                <svg :class="{'rotate-180': openDropdown3}, {'hidden': !isSidebarOpen}" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ms-10 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 15l-7-7-7 7" />
                                </svg>
                            </button>
                            <ul x-show="openDropdown3" @click.away="openDropdown3 = false" class="left-0 top-full mt-2 rounded-md shadow-lg w-full">
                                <li><a href="{{ route('input_barang_rusak') }}" @click="isSidebarOpen = false" class="block px-4 py-2 text-white hover:bg-gray-600 rounded-md text-sm">Input</a></li>
                                <li><a href="{{ route('tabel_barang_rusak') }}" @click="isSidebarOpen = false" class="block px-4 py-2 text-white hover:bg-gray-600 rounded-md text-sm">Data</a></li>
                            </ul>
                        </div>
                    </li>
                </div>
                <li title="Stok Gudang">
                    <a href="{{ route('tabel_stok_gudang') }}"
                        class="flex items-center p-2 rounded-lg text-white 
                    {{ request()->routeIs('tabel_stok_gudang') ? 'border-l-4 border-red-700 bg-gradient-to-r from-red-500' : 'bg-[#0F0606] hover:bg-gray-600' }}">
                        <svg class="w-8 h-8 mobile:w-7 mobile:h-7 text-blue-800 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 640 512">
                            <path d="M58.9 42.1c3-6.1 9.6-9.6 16.3-8.7L320 64 564.8 33.4c6.7-.8 13.3 2.7 16.3 8.7l41.7 83.4c9 17.9-.6 39.6-19.8 45.1L439.6 217.3c-13.9 4-28.8-1.9-36.2-14.3L320 64 236.6 203c-7.4 12.4-22.3 18.3-36.2 14.3L37.1 170.6c-19.3-5.5-28.8-27.2-19.8-45.1L58.9 42.1zM321.1 128l54.9 91.4c14.9 24.8 44.6 36.6 72.5 28.6L576 211.6v167c0 22-15 41.2-36.4 46.6l-204.1 51c-10.2 2.6-20.9 2.6-31 0l-204.1-51C79 419.7 64 400.5 64 378.5v-167L191.6 248c27.8 8 57.6-3.8 72.5-28.6L318.9 128h2.2z" />
                            <path fill-rule="evenodd" d="M21.707 21.707a1 1 0 0 1-1.414 0l-3.5-3.5a1 1 0 0 1 1.414-1.414l3.5 3.5a1 1 0 0 1 0 1.414Z" clip-rule="evenodd" />
                        </svg>

                        <span :class="{'hidden': !isSidebarOpen}" class="flex-1 ms-3 whitespace-nowrap">Stok Gudang</span>
                    </a>
                </li>
                @endif

                <!-- Super Admin -->
                @if(auth()->user() && auth()->user()->role === 'superadmin' && (auth()->user()->request_access === 0))
                <li>
                    <a href="{{ route('tabel_barang_masuk.superadmin') }}"
                        class="flex items-center p-2 rounded-lg text-white 
                        {{ request()->routeIs('tabel_barang_masuk.superadmin') ? 'border-l-4 border-red-700 bg-gradient-to-r from-red-500' : 'bg-[#0F0606] hover:bg-gray-600' }}">
                        <svg class="w-8 h-8 mobile:w-7 mobile:h-7 text-blue-800 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 640 512">
                            <path d="M58.9 42.1c3-6.1 9.6-9.6 16.3-8.7L320 64 564.8 33.4c6.7-.8 13.3 2.7 16.3 8.7l41.7 83.4c9 17.9-.6 39.6-19.8 45.1L439.6 217.3c-13.9 4-28.8-1.9-36.2-14.3L320 64 236.6 203c-7.4 12.4-22.3 18.3-36.2 14.3L37.1 170.6c-19.3-5.5-28.8-27.2-19.8-45.1L58.9 42.1zM321.1 128l54.9 91.4c14.9 24.8 44.6 36.6 72.5 28.6L576 211.6v167c0 22-15 41.2-36.4 46.6l-204.1 51c-10.2 2.6-20.9 2.6-31 0l-204.1-51C79 419.7 64 400.5 64 378.5v-167L191.6 248c27.8 8 57.6-3.8 72.5-28.6L318.9 128h2.2z" />
                            <path fill-rule="evenodd" d="M21.707 21.707a1 1 0 0 1-1.414 0l-3.5-3.5a1 1 0 0 1 1.414-1.414l3.5 3.5a1 1 0 0 1 0 1.414Z" clip-rule="evenodd" />
                        </svg>
                        <span :class="{'hidden': !isSidebarOpen}" class="flex-1 ms-3 whitespace-nowrap">Stok Gudang</span>
                    </a>
                </li>
                <li x-data="{ openDropdown1: false, openDropdown2: false }" title="Pengiriman Barang">
                    <div class="relative items-center rounded-lg text-white bg-[#0F0606] group">
                        <button @click="openDropdown2 = !openDropdown2; if (!isSidebarOpen) { isSidebarOpen = true;}" class="flex items-center w-full px-2 py-2 rounded-lg {{ request()->routeIs('pengiriman_barang.superadmin') || request()->routeIs('pengiriman_barang.input.superadmin') ? 'border-l-4 border-red-700 bg-gradient-to-r from-red-500' : 'bg-[#0F0606] hover:bg-gray-600' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="flex-shrink-0 w-9 h-9 mobile:h-7 mobile:w-7 text-blue-800 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M15 10l-4 4l6 6l4 -16l-18 7l4 2l2 6l3 -4" />
                            </svg>
                            <span :class="{'hidden': !isSidebarOpen}" class="ms-1 whitespace-nowrap">Pengiriman</span>
                            <svg :class="{'rotate-180': openDropdown2}, {'hidden': !isSidebarOpen}" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ms-10 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 15l-7-7-7 7" />
                            </svg>

                            @if($pengiriman_terlambat_count > 0)
                            <span class="absolute top-0 left-2 transform -translate-x-1/2 -translate-y-1/2 bg-red-600 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center z-10">
                                {{ $pengiriman_terlambat_count }}
                            </span>
                            @endif
                        </button>
                        <ul x-show="openDropdown2" @click.away="openDropdown2 = false" class="left-0 top-full mt-2 rounded-md shadow-lg w-full">
                            <li><a href="{{ route('pengiriman_barang.input.superadmin') }}" @click="isSidebarOpen = false" class="block px-4 py-2 text-white hover:bg-gray-600 rounded-md text-sm">Input</a></li>
                            <li><a href="{{ route('pengiriman_barang.superadmin') }}" @click="isSidebarOpen = false" class="block px-4 py-2 text-white hover:bg-gray-600 rounded-md text-sm">Data</a></li>
                        </ul>
                    </div>
                </li>
                <li class="relative" title="Permintaan Barang">
                    <a href="{{ route('permintaan_barang.superadmin') }}"
                        class="flex items-center p-2 rounded-lg text-white 
        {{ request()->routeIs('permintaan_barang.superadmin') ? 'border-l-4 border-red-700 bg-gradient-to-r from-red-500' : 'bg-[#0F0606] hover:bg-gray-600' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler w-9 h-9 mobile:h-7 mobile:w-7 icons-tabler-outline icon-tabler-pointer-question">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M15.062 12.506l-.284 -.284l3.113 -2.09a1.2 1.2 0 0 0 -.309 -2.228l-13.582 -3.904l3.904 13.563a1.2 1.2 0 0 0 2.228 .308l2.09 -3.093l1.278 1.278" />
                            <path d="M19 22v.01" />
                            <path d="M19 19a2.003 2.003 0 0 0 .914 -3.782a1.98 1.98 0 0 0 -2.414 .483" />
                        </svg>
                        <span :class="{'hidden': !isSidebarOpen}" class="flex-1 ms-3 whitespace-nowrap">Permintaan Barang</span>
                        <!-- Notifikasi Badge -->
                        @if($request_barang_count > 0)
                        <span class="absolute top-0 left-2 transform -translate-x-1/2 -translate-y-1/2 bg-yellow-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">
                            {{ $request_barang_count }}
                        </span>
                        @endif
                    </a>
                </li>
                @endif
            </ul>
            <a href="{{ route('setting') }}" class="flex items-center p-2 rounded-lg text-white" title="Pengaturan">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 mobile:h-7 mobile:w-7 text-blue-800 text-white icon icon-tabler icons-tabler-outline icon-tabler-settings">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                    <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                </svg>
                <span :class="{'hidden': !isSidebarOpen}" class="flex-1 ms-3 whitespace-nowrap">Pengaturan</span>
            </a>
            <div class="flex items-center p-2 rounded-lg text-white" title="Logout">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="flex items-center w-full">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8 mobile:h-7 mobile:w-7 text-blue-800 text-white icon icon-tabler icons-tabler-outline icon-tabler-logout-2">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2" />
                            <path d="M15 12h-12l3 -3" />
                            <path d="M6 15l-3 -3" />
                        </svg>
                        <span :class="{'hidden': !isSidebarOpen}" class="flex-1 ms-3 whitespace-nowrap">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>
    <div :class="{'ml-60': isSidebarOpen, 'ml-20': !isSidebarOpen}" class="flex-1 p-4 mt-16 z-50 transition-all duration-300 ease-in-out translate-x-0">
        <div>
            {{ $slot }}
        </div>
    </div>

    @if(session('success_notification'))
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
                    {{ session('success_notification') }}
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
    <script>
        function toggleAccess(userId, isChecked) {
            const url = isChecked ?
                `/admin/approve-access/${userId}` :
                `/admin/delete-access/${userId}`;

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Pastikan ini di-render di Blade
                    },
                    body: JSON.stringify({
                        role: isChecked ? 'admin' : 'user'
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Role berhasil diperbarui');
                    } else {
                        console.error('Gagal memperbarui role');
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function submitRequest() {
            fetch('/request-access', {
                    method: 'GET', // Use GET if your endpoint handles it
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // This is generally not required for GET requests
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json(); // Parse JSON response
                })
                .then(data => {
                    const message = data.message; // Ambil pesan dari response
                    const alertType = data.alert_type; // Ambil tipe alert dari response

                    const alertBox = document.createElement('div');

                    // Styling alert
                    alertBox.style.position = 'fixed';
                    alertBox.style.top = '56px';
                    alertBox.style.right = '20px';
                    alertBox.style.padding = '12px 20px';
                    alertBox.style.borderRadius = '8px';
                    alertBox.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.2)';
                    alertBox.style.zIndex = '1000';
                    alertBox.style.opacity = '0';
                    alertBox.style.transform = 'translateY(-10px)';
                    alertBox.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';

                    // Pilih warna berdasarkan tipe alert
                    if (alertType === 'warning') {
                        alertBox.style.backgroundColor = '#FFC107'; // Kuning (Warning)
                        alertBox.style.color = 'black';
                    } else if (alertType === 'success') {
                        alertBox.style.backgroundColor = '#4CAF50'; // Hijau (Success)
                        alertBox.style.color = 'white';
                    }

                    alertBox.innerText = message;

                    document.body.appendChild(alertBox);
                    setTimeout(() => {
                        alertBox.style.opacity = '1';
                        alertBox.style.transform = 'translateY(0)';
                    }, 100);

                    setTimeout(() => {
                        alertBox.style.opacity = '0';
                        alertBox.style.transform = 'translateY(-10px)';
                        setTimeout(() => {
                            alertBox.remove();
                        }, 500);
                    }, 3000);
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>

</html>