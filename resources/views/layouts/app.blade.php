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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="grid grid-cols-4 h-screen min-h-screen bg-gray-100">

        <!--COLUNA 01 -->
        <div class="flex flex-col items-center mt-10">
            <img src="{{ asset('img/logo_sabor_do_brasil.png') }}" alt="Logo Sabor do Brasil" class="w-40 h-auto">
            <h1 class="text-3xl font-bold text-orange-600" style="font-family: 'Amatic SC', cursive;">Sabor do Brasil</h1>
            <hr class="border-t border-yellow-600 w-2/3">
            <div class="mt-5 flex gap-10">
                <div class="flex-1 p-5 text-center">Likes</div>
                <div class="flex-1 p-5 text-center">Deslikes</div>
            </div>
        </div>

        <!--COLUNA 02 -->

        <div class="col-span-2 border-x-2 border-yellow-400 flex flex-col items-center mt-10 w-full ">
            <main>
                @yield('content')
            </main>
        </div>

        <!--COLUNA 03 -->

        <div>
            <div class="items-center flex flex-col  mt-10">
                <button command="show-modal" commandfor="dialog" class="bg-[#d97014] hover:bg-[#b85d10] text-white font-semibold py-2 px-4 rounded">Entrar</button>

                <el-dialog>
                    <dialog id="dialog" aria-labelledby="dialog-title" class="fixed inset-0 size-auto max-h-none max-w-none overflow-y-auto bg-transparent backdrop:bg-transparent">
                        <el-dialog-backdrop class="fixed inset-0 bg-gray-900/20 transition-opacity data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in"></el-dialog-backdrop>

                        <div tabindex="0" class="flex min-h-full items-end justify-center p-4 text-center focus:outline-none sm:items-center sm:p-0">
                            <el-dialog-panel class="relative transform overflow-hidden rounded-lg bg-[#ffffff] text-left shadow-xl outline -outline-offset-1 transition-all data-closed:translate-y-4 data-closed:opacity-0 data-enter:duration-300 data-enter:ease-out data-leave:duration-200 data-leave:ease-in sm:my-8 sm:w-full sm:max-w-lg data-closed:sm:translate-y-0 data-closed:sm:scale-95">
                                <div class="bg-[#ffffff] px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mt-3 w-full text-center">
                                            <h3 id="dialog-title" class="text-base font-semibold text-black mb-2">Login</h3>
                                            <div class="mt-2 w-full">
                                                <input type="email" name="email" id="email" class="w-full rounded-md border-gray-300 shadow-sm p-2" placeholder="Digite seu email">

                                                <input type="password" name="senha" id="senha" class="w-full rounded-md border-gray-300 shadow-sm p-2 mt-4" placeholder="Digite sua senha">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex gap-2 p-2">
                                        <button type="button" command="close" commandfor="dialog" class="w-full justify-center rounded-md px-3 py-2 text-sm font-semibold text-black  border border-[#d97014]">Cancelar</button>
                                        <button type="button" command="close" commandfor="dialog" class="w-full justify-center rounded-md bg-[#d97014] px-3 py-2 text-sm font-semibold text-white">Enviar</button>
                                    </div>
                            </el-dialog-panel>
                        </div>
                    </dialog>
                </el-dialog>
            </div>


        </div>
    </div>
    <footer class="bg-orange-600 py-4 text-white justify-item-center px-8 w-full fixed bottom-0 left-0">
        <div class="grid grid-cols-3">
            <div class="col-span-1 w-full flex justify-center">Sabor do Brasil | </div>
            <div class=" w-full flex justify-center gap-20">
                <a href=""><img src="img/Instagram.svg" alt="Facebook" class="h-5 w-5"> </a>
                <a href=""><img src="img/Twitter.svg" alt="Twitter" class="h-5 w-5"> </a>
                <a href=""><img src="img/Whatsapp (1).svg" alt="Instagram" class="h-5 w-5"> </a>
                <a href=""><img src="img/Globe (1).svg" alt="Globe" class="h-5 w-5"> </a>
            </div>
            <div class="col-span-1 w-full flex justify-center">Copyright - 2024
            </div>
        </div>
    </footer>
    </div>
</body>

</html>