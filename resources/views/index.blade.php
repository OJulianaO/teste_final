@extends('layouts.app')

@section('content')
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
            <span>Likes: {{ $publicacao->likes()->count() }} | Dislikes: {{ $publicacao->deslikes()->count() }}</span>
        </div>

        <!-- LIKE/DESLIKE -->
        <div class="flex justify-center space-x-2">
            @auth
                <form method="POST" action="{{ route('publicacoes.like', $publicacao) }}">
                    @csrf
                    <button type="submit" class="p-1 bg-gray-100 rounded hover:bg-gray-200">
                        @php
                            $liked = $publicacao->likes()->where('user_id', auth()->id())->count() > 0;
                        @endphp
                        <img src="{{ asset('img/' . ($liked ? 'flecha_cima_cheia.svg' : 'flecha_cima_vazia.svg')) }}" class="w-6 h-6">
                    </button>
                </form>

                <form method="POST" action="{{ route('publicacoes.deslike', $publicacao) }}">
                    @csrf
                    <button type="submit" class="p-1 bg-gray-100 rounded hover:bg-gray-200">
                    @php
                        $desliked = $publicacao->deslikes()->where('user_id', auth()->id())->count() > 0;
                    @endphp
                    <img src="{{ asset('img/' . ($desliked ? 'flecha_baixo_cheia.svg' : 'flecha_baixo_vazia.svg')) }}" class="w-6 h-6">
                    </button>
                </form>
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
                        <form method="POST" action="{{ route('comentario.destroy', $comentario->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="  bg-white-500  rounded hover:bg-gray-600 text-sm p-1 border " onclick="return confirm('Tem certeza que deseja excluir este comentário?')">
                                <img src="{{ asset('img/lixo.png') }}" alt="Excluir" class="w-3">
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
@endsection