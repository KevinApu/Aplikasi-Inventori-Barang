<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="flex items-center justify-center min-h-screen bg-zinc-50 px-4 font-roboto text-sm">
        <div class="relative flex flex-col m-6 space-y-8 bg-white shadow-2xl rounded-2xl md:flex-row md:space-y-0 w-full md:w-[600px] transform transition-transform duration-500 hover:scale-[1.01] hover:shadow-neutral-400">
            <div class="flex flex-col justify-center p-8 md:p-14 bg-white rounded-2xl">
                <h1 class="mb-3 text-4xl font-bold font-roboto">Login</h1>
                <form id="main-form" action="{{ route('login') }}" method="post" class="space-y-1 rounded-lg" x-data="{ open: {{ session('show_popup') ? 'true' : 'false' }}, pop: '' }">
                    @csrf
                    <!-- Input Username dan Password -->
                    <div>
                        <div class="mt-8 mb-4">
                            <input type="text" placeholder="Username" class="w-full p-2 border-0 focus:ring-0 border-b bg-transparent placeholder:text-gray-400 placeholder:text-sm" name="username" value="{{ old('username') }}" />
                            @error('username_error')
                            <p class="text-red-500 text-[10px]">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div>
                        <div class="mt-4">
                            <input type="password" placeholder="Password" id="password" class="w-full p-2 border-0 focus:ring-0 border-b bg-transparent placeholder:text-gray-400 placeholder:text-sm" name="password" value="{{ old('password') }}" />
                            @error('password_error')
                            <p class="text-red-500 text-[10px]">{{$message}}</p>
                            @enderror
                        </div>
                        <div class="flex mt-2 items-center">
                            <input type="checkbox" id="togglePassword" class="w-3 h-3 right-2 top-4 rounded-md text-sm">
                            <label for="togglePassword" class="text-sm text-gray-500 ml-2">tampilkan password</label>
                        </div>
                    </div>

                    <!-- Input Hidden untuk 'pop' dengan x-bind:value -->
                    <input type="hidden" name="pop" x-bind:value="pop" />

                    <div>
                        <button class="w-full p-2 rounded-lg mb-6 mt-6 bg-[#0F0606] text-white rounded-md hover:bg-neutral-700 transition-colors duration-200 ease-in-out" type="submit">Login</button>
                    </div>
                </form>
            </div>
            <script>
                const togglePassword = document.getElementById('togglePassword');
                const passwordField = document.getElementById('password');

                togglePassword.addEventListener('click', function() {
                    // Toggle antara tipe 'password' dan 'text'
                    const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordField.setAttribute('type', type);
                });
            </script>

            <div class="relative hidden md:block w-full md:w-[400px]">
                <!-- Gambar -->
                <img src="/img/logistics.png"
                    alt="img"
                    class="w-full h-full rounded-r-2xl object-cover" />

                <!-- Overlay Gradasi dari putih ke transparan -->
                <div class="absolute inset-0 bg-gradient-to-r from-white from-8% to-transparent to-60% rounded-r-2xl"></div>
            </div>
        </div>
    </div>
</body>

</html>