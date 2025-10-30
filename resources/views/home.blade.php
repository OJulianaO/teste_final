<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Sabor do Brasil')</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-white text-gray-900">

    <main class="min-h-screen">

        <!-- LOGIN -->
        <div id="loginModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-50 items-center justify-center">
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
                            <input placeholder="Nome" type="text" name="nome" id="nome"
                                value="{{ old('nome') }}"
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500"
                                required>
                        </div>
                        <div class="mb-3">
                            <input placeholder="Senha" type="password" name="senha" id="senha"
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500"
                                required>
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
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- COLUNA 1 -->
                <div class="flex flex-col items-center space-y-4">
                    <img class="rounded mx-auto" src="{{asset('img/logo_sabor_do_brasil.png')}}" alt="logo">
                    <h5 class="text-center border-b border-black w-full pb-1">Sabor do Brasil</h5>
                    <div class="grid grid-cols-2 gap-4 w-full text-center">
                        <div>
                            <h3>{{ $totalLikes ?? 0 }}</h3>
                            <h6>Likes</h6>
                        </div>
                        <div>
                            <h3>{{ $totalDislikes ?? 0 }}</h3>
                            <h6>Deslikes</h6>
                        </div>
                    </div>
                </div>

                <!-- CCOLUNA 2 -->
                <div class="border-l border-r border-black px-4 py-6 space-y-6">
                    <h5 class="text-center text-lg font-semibold mb-4">Publicações</h5>
                    <div class="flex flex-col items-center space-y-4">
                        @foreach($publicacoes as $publicacao)
                        <div class="border border-black rounded p-4 w-3/4 text-center space-y-2">
                            <h6 class="font-medium">{{$publicacao->titulo_prato}}</h6>
                            <img src="{{asset($publicacao->foto)}}" alt="{{$publicacao->titulo_prato}}"
                                class="w-full h-48 object-cover rounded mb-2">
                            <div class="grid grid-cols-2 text-left text-sm">
                                <p>{{$publicacao->local}}</p>
                                <p class="text-right">{{$publicacao->cidade}}</p>
                            </div>
                            <div class="text-xs text-gray-600 mb-2">
                                Likes: {{ $publicacao->likes }} | Dislikes: {{ $publicacao->dislikes }}
                            </div>

                            <!-- LIKE/DESLIKE -->
                            <div class="flex justify-center space-x-2">
                                @auth
                                <form method="POST" action="{{ route('like', $publicacao->id) }}">
                                    @csrf
                                    <button type="submit" class="p-1 bg-gray-100 rounded hover:bg-gray-200">
                                        @if(session("liked_{$publicacao->id}"))
                                        <img src="{{ asset('img/flecha_cima_cheia.svg') }}" alt="like" class="w-5">
                                        @else
                                        <img src="{{ asset('img/flecha_cima_vazia.svg') }}" alt="like" class="w-5">
                                        @endif
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('dislike', $publicacao->id) }}">
                                    @csrf
                                    <button type="submit" class="p-1 bg-gray-100 rounded hover:bg-gray-200">
                                        @if(session("disliked_{$publicacao->id}"))
                                        <img src="{{ asset('img/flecha_baixo_cheia.svg') }}" alt="dislike" class="w-5">
                                        @else
                                        <img src="{{ asset('img/flecha_baixo_vazia.svg') }}" alt="dislike" class="w-5">
                                        @endif
                                    </button>
                                </form>
                                @else
                                <button class="p-1 bg-gray-100 rounded w-10" disabled>
                                    <img src="{{ asset('img/flecha_cima_vazia.svg') }}" alt="like" class="w-5">
                                </button>
                                <button class="p-1 bg-gray-100 rounded w-10" disabled>
                                    <img src="{{ asset('img/flecha_baixo_vazia.svg') }}" alt="dislike" class="w-5">
                                </button>
                                @endauth
                                <a href="{{ route('comentarios.toggle', $publicacao->id) }}"
                                    class="flex items-center space-x-1 px-2 py-1 bg-gray-100 rounded hover:bg-gray-200">
                                    <img src="{{ asset('img/chat.svg') }}" alt="chat" class="w-4">
                                    <small>({{ $publicacao->comentarios->count() }})</small>
                                </a>
                            </div>

                            <!-- COMENTÁRIO -->
                            @if(session("show_comentarios_{$publicacao->id}"))
                            <div class="mt-4 border-t pt-3 space-y-3">
                                <h6 class="font-medium">Comentários:</h6>

                                <form method="POST" action="{{ route('comentario.store', $publicacao->id) }}" class="space-y-2">
                                    @csrf
                                    <textarea class="w-full border border-gray-300 rounded px-2 py-1" name="texto" rows="2" placeholder="Adicione um comentário..." required></textarea>
                                    <button type="submit" class="px-3 py-1 bg-orange-500 text-white rounded hover:bg-orange-600 text-sm">+ Comentar</button>
                                </form>

                                @foreach($publicacao->comentarios as $comentario)
                                <div class="border-b pb-2 mb-2">
                                    <div class="flex justify-between items-start">
                                        <p class="text-sm">{{ $comentario->texto }}</p>
                                        <div class="flex space-x-1">
                                            <button type="button"
                                                class="p-1 border border-gray-300 rounded" 
                                                data-toggle="collapse"
                                                data-target="#editForm{{ $comentario->id }}">
                                                <img src="{{ asset('img/lapis_editar.svg') }}" alt="Editar" class="w-3">
                                            </button>
                                            <form method="POST" action="{{ route('comentario.destroy', $comentario->id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="  bg-red-500 text-white rounded hover:bg-red-600 text-sm p-1 border " onclick="return confirm('Tem certeza que deseja excluir este comentário?')">
                                                    <img src="{{ asset('img/lixeira_deletar.svg') }}" alt="Excluir" class="w-3">
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="hidden mt-2" id="editForm{{ $comentario->id }}">
                                        <form method="POST" action="{{ route('comentario.update', $comentario->id) }}" class="space-y-2">
                                            @csrf
                                            @method('PUT')
                                            <textarea class="w-full border border-gray-300 rounded px-2 py-1" name="texto" rows="2" required>{{ $comentario->texto }}</textarea>
                                            <div class="flex space-x-2">
                                                <button type="submit" class="px-3 py-1 bg-orange-500 text-white rounded hover:bg-orange-600 text-sm">Salvar</button>
                                                <button type="button" class="px-3 py-1 bg-gray-300 rounded hover:bg-gray-400 text-sm"
                                                    onclick="document.getElementById('editForm{{ $comentario->id }}').classList.add('hidden')">
                                                    Cancelar
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- COLUNA 3 -->
                <div class="flex flex-col items-center justify-start">
                    <button type="button"
                        class="px-6 py-3 bg-orange-500 text-white rounded-lg hover:bg-red-700 text-lg"
                        onclick="document.getElementById('loginModal').classList.remove('hidden')">
                        Entrar
                    </button>
                </div>

            </div>
        </div>

    </main>

    <!-- RODAPÉ -->
    <footer class="bg-[#d97014] text-white px-8 py-8 flex items-center">

        <div class="container grid grid-cols-3">

            <div class="mb-4 text-left">
                <p class="text-2xl font-bold text-[#ffffff]">Sabor do Brasil</p>
            </div>

            <div class="flex justify-center pt-1.5 gap-20">
                <div class="flex justify-center pt-1.5 gap-20">
                    <a href="">
                        <img src="img\Instagram.svg" alt="Instagram" class="h-7 w-7">
                    </a>
                    <a href="">
                        <img src="img\Twitter.svg" alt="Twitter" class="h-7 w-7">
                    </a>
                    <a href="">
                        <img src="img\Whatsapp.svg" alt="Whatsapp" class="h-7 w-7">
                    </a>
                    <a href="">
                        <img src="img\Globe.svg" alt="Globe" class="h-7 w-7">
                    </a>
                </div>
            </div>

            <div class="flex justify-end pt-1.5 gap-2">
                <p class="text-2xl font-bold text-white">Copyright-2024</p>
            </div>
        </div>
    </footer>
</body>

</html>