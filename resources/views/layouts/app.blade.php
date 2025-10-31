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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindplus/elements@1" type="module"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white text-gray-900">

    <main class="min-h-screen">

        <!-- LOGIN -->
        <div id="loginModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 items-center justify-items-center">
            <div class="bg-white rounded-lg shadow-lg w-96 mx-2">
                <div class="flex justify-between items-center px-4 py-2 border-b border-gray-300">
                    <h5 class="text-lg font-semibold">Login</h5>
                    <button type="button" class="text-gray-500 hover:text-gray-700"
                        onclick="document.getElementById('loginModal').classList.add('hidden')">&times;</button>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="px-4 py-4">
                        @if($errors->any())
                        <div class="bg-red-100 text-red-700 px-3 py-2 rounded mb-3">
                            {{ $errors->first() }}
                        </div>
                        @endif
                        <div class="mb-3">
                            <x-input-label for="nickname" :value="__('Nickname')" />
                            <x-text-input id="nickname" class="block mt-1 w-full" type="text" name="nickname" :value="old('nickname')" required autofocus autocomplete="username" />
                        </div>
                        <div class="mb-3">
                            <x-input-label for="password" :value="__('Password')" />

                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                        </div>
                    </div>
                    <div class="flex justify-end px-4 py-3 border-t border-gray-300 space-x-2">
                        <button type="button" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400"
                            onclick="document.getElementById('loginModal').classList.add('hidden')">Fechar</button>
                        <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600">Entrar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="container mx-auto px-4 py-6">
            <div class="grid grid-cols-4 gap-6">

                <!-- COLUNA 1 -->
                <div class="flex flex-col items-center space-y-4">
                    @guest
                    <img class="rounded mx-auto" src="{{asset('img/logo_sabor_do_brasil.png')}}" alt="logo">
                    <h5 class="text-center border-b border-black w-full pb-1">Sabor do Brasil</h5>
                    @endguest
                    @auth
                    <img class="rounded-full w-24 h-24 object-cover" src="{{Auth::user()->foto}}" alt="logo">
                    <h5 class="text-center border-b border-black w-full pb-1">{{Auth::user()->nome}}</h5>
                    @endauth
                    <div class="grid grid-cols-2 gap-4 w-full text-center">
                        <div>
                            @auth
                            <h3>{{ $totalLikesUser ?? 0 }}</h3>
                            @endauth
                            @guest
                            <h3>{{ $totalLikes ?? 0 }}</h3>
                            @endguest
                            <h6>Likes</h6>
                        </div>
                        <div>
                            @auth
                            <h3>{{ $totalDislikesUser ?? 0 }}</h3>
                            @endauth
                            @guest
                            <h3>{{ $totalDislikes ?? 0 }}</h3>
                            @endguest
                            <h6>Deslikes</h6>
                        </div>
                    </div>
                </div>

                <!-- CCOLUNA 2 -->
                <div class="border-l border-r col-span-2 border-black px-4 py-6 space-y-6">
                    <h5 class="text-center text-lg font-semibold mb-4">Publicações</h5>
                    @yield('content')
                </div>

                <!-- COLUNA 3 -->
                <div class="flex flex-col items-center justify-start">
                    @guest
                    <button type="button"
                        class="px-6 py-3 bg-orange-500 text-white rounded-lg hover:bg-red-700 text-lg"
                        onclick="document.getElementById('loginModal').classList.remove('hidden')">
                        Entrar
                    </button>
                    @endguest
                    @auth
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-3 bg-orange-500 text-white rounded-lg hover:bg-red-700 text-lg">
                            Sair
                        </button>
                    </form>
                    @endauth
                </div>

            </div>
        </div>

    </main>

    <!-- RODAPÉ -->
    <footer class="bg-[#d97014] text-white px-8 py-8  grid grid-cols-5 items-center">
        <div class="mb-4 text-left">
            <p class="text-2xl font-bold text-[#ffffff]">Sabor do Brasil</p>
        </div>
        <div class="flex justify-center pt-1.5 gap-20 col-span-3">
            <div class="flex justify-center gap-20">
                <a href="">
                    <img src="img/Instagram.svg" alt="Instagram" class="h-7 w-7">
                </a>
                <a href="">
                    <img src="img/Twitter.svg" alt="Twitter" class="h-7 w-7">
                </a>
                <a href="">
                    <img src="img/Whatsapp.svg" alt="Whatsapp" class="h-7 w-7">
                </a>
                <a href="">
                    <img src="img/Globe.svg" alt="Globe" class="h-7 w-7">
                </a>
            </div>
        </div>
        <div class="justify-end text-right pt-1.5 gap-2">
            <p class="text-2xl font-bold text-white">Copyright-2024</p>
        </div>

    </footer>

</body>

</html>