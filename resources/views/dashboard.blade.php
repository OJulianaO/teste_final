<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title','Sabor do Brasil')</title>
  @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">

  <main class="py-8">
    <div class="max-w-7xl mx-auto px-4">
      <div class="grid grid-cols-12 gap-6">

        <!-- COLUNA 1 -->
        <div class="col-span-3 text-center">
          <img class="rounded-full mx-auto w-36 h-36 object-cover" src="{{ asset($usuario->foto) }}" alt="Foto do usuário">
          <h5 class="mt-2 border-b border-black">{{ $usuario->nome }}</h5>
          <div class="mt-4 grid grid-cols-2 gap-4 text-center">
            <div>
              <h3 class="text-xl font-semibold">{{ $totalLikes ?? 0 }}</h3>
              <h6 class="text-sm">Likes</h6>
            </div>
            <div>
              <h3 class="text-xl font-semibold">{{ $totalDislikes ?? 0 }}</h3>
              <h6 class="text-sm">Deslike</h6>
            </div>
          </div> 
        </div>

        <!-- COLUNA 2-->
        <div class="col-span-6 border-x border-black px-4">
          <h5 class="text-center mb-6 text-lg font-bold">Publicações</h5>
          <div class="flex flex-col items-center">
            @foreach($publicacoes as $publicacao)
            <div class="border border-black p-4 mb-6 w-3/4 text-center rounded bg-white shadow">
              <h6 class="font-semibold mb-2">{{$publicacao->titulo_prato}}</h6>
              <img src="{{asset($publicacao->foto)}}" alt="{{$publicacao->titulo_prato}}" class="w-full h-48 object-cover mb-2 rounded">
              <div class="grid grid-cols-2 text-sm mb-2">
                <p class="text-left">{{$publicacao->local}}</p>
                <p class="text-right">{{$publicacao->cidade}}</p>
              </div>
              <div class="text-xs text-gray-500 mb-2">
                Likes: {{ $publicacao->likes }} | Dislikes: {{ $publicacao->dislikes }}
              </div>

              <div class="flex justify-center gap-2 mb-2">
                @auth
                <form method="POST" action="{{ route('like', $publicacao->id) }}">
                  @csrf
                  <button type="submit" class="p-2 bg-gray-100 rounded">
                    @if(session("liked_{$publicacao->id}"))
                    <img src="{{ asset('img/flecha_cima_cheia.svg') }}" alt="like" width="20">
                    @else
                    <img src="{{ asset('img/flecha_cima_vazia.svg') }}" alt="like" width="20">
                    @endif
                  </button>
                </form>

                <form method="POST" action="{{ route('dislike', $publicacao->id) }}">
                  @csrf
                  <button type="submit" class="p-2 bg-gray-100 rounded">
                    @if(session("disliked_{$publicacao->id}"))
                    <img src="{{ asset('img/flecha_baixo_cheia.svg') }}" alt="dislike" width="20">
                    @else
                    <img src="{{ asset('img/flecha_baixo_vazia.svg') }}" alt="dislike" width="20">
                    @endif
                  </button>
                </form>
                @else
                <button class="p-2 bg-gray-100 rounded" disabled>
                  <img src="{{ asset('img/flecha_cima_vazia.svg') }}" alt="like" width="20">
                </button>
                <button class="p-2 bg-gray-100 rounded" disabled>
                  <img src="{{ asset('img/flecha_baixo_vazia.svg') }}" alt="dislike" width="20">
                </button>
                @endauth

                <a href="{{ route('comentarios.toggle', $publicacao->id) }}" class="p-2 bg-gray-100 rounded flex items-center gap-1">
                  <img src="{{ asset('img/chat.svg') }}" alt="chat">
                  <small>({{ $publicacao->comentarios->count() }})</small>
                </a>
              </div>

              @if(session("show_comentarios_{$publicacao->id}"))
              <div class="mt-4 border-t border-gray-300 pt-3 text-left">
                <h6 class="font-semibold mb-2">Comentários:</h6>
                <form method="POST" action="{{ route('comentario.store', $publicacao->id) }}" class="mb-3">
                  @csrf
                  <textarea class="w-full border border-gray-300 rounded p-2 mb-2" name="texto" rows="2" placeholder="Adicione um comentário..." required></textarea>
                  <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">Comentar</button>
                </form>
                @foreach($publicacao->comentarios as $comentario)
                <div class="border-b border-gray-300 pb-2 mb-2">
                  <div class="flex justify-between items-start">
                    <p class="mb-1 text-sm">{{ $comentario->texto }}</p>
                    <div class="flex gap-1">
                      <button class="p-1 border border-blue-500 rounded" data-collapse-target="#editForm{{ $comentario->id }}">
                        <img src="{{ asset('img/lapis_editar.svg') }}" alt="Editar" width="14">
                      </button>
                      <form method="POST" action="{{ route('comentario.destroy', $comentario->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-1 border border-red-500 rounded"
                          onclick="return confirm('Tem certeza que deseja excluir este comentário?')">
                          <img src="{{ asset('img/lixeira_deletar.svg') }}" alt="Excluir" width="14">
                        </button>
                      </form>
                    </div>
                  </div>

                  <div class="hidden mt-2" id="editForm{{ $comentario->id }}">
                    <form method="POST" action="{{ route('comentario.update', $comentario->id) }}">
                      @csrf
                      @method('PUT')
                      <textarea class="w-full border border-gray-300 rounded p-2 mb-2" name="texto" rows="2" required>{{ $comentario->texto }}</textarea>
                      <div class="flex gap-2">
                        <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded text-sm">Salvar</button>
                        <button type="button" class="bg-gray-300 px-3 py-1 rounded text-sm" data-collapse-target="#editForm{{ $comentario->id }}">Cancelar</button>
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

        <!-- COLUNA 3-->
        <div class="col-span-3 text-center">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded-lg text-lg">Sair</button>
          </form>
        </div>

      </div>
    </div>
  </main>

  <!-- RODAPÉ -->
  <footer class="bg-orange-500 text-white w-full mt-10">
    <div class="container mx-auto px-4 py-4">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-center">
        <div class="text-center lg:text-left">
          <p>Sabor do Brasil</p>
        </div>
        <div class="flex justify-center space-x-4">
          <a href=""><img src="{{ asset('img/Instagram.svg') }}" alt="Insta" class="w-6"></a>
          <a href=""><img src="{{ asset('img/Whatsapp.svg') }}" alt="Whatss" class="w-6"></a>
          <a href=""><img src="{{ asset('img/Twitter.svg') }}" alt="Twitter" class="w-6"></a>
          <a href=""><img src="{{ asset('img/Globe.svg') }}" alt="Goggle" class="w-6"></a>
        </div>
        <div class="text-center lg:text-right">
          <p>Copyright - 2024</p>
        </div>
      </div>
    </div>
  </footer>

</body>

</html>