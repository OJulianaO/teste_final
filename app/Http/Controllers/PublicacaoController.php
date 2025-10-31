<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicacao;
use App\Models\Like;
use App\Models\Deslike;
use App\Models\Empresa;
use Illuminate\Support\Facades\Auth;

class PublicacaoController extends Controller
{
   
    public function index()
    {
        $publicacoes = Publicacao::all();
        $totalLikes = Like::count();
        $totalDislikes = Deslike::count();
        $totalLikesUser = Like::where('user_id', auth()->id() )->count();
        $totalDislikesUser = Deslike::where('user_id', auth()->id())->count();

        return view('index', compact('publicacoes','totalLikes', 'totalDislikes','totalLikesUser','totalDislikesUser'));
    }

    public function like(Publicacao $publicacao)
    {
        $user = auth()->user();
        if ($publicacao->likes()->where('user_id', $user->id)->exists()) {
            $publicacao->likes()->where('user_id', $user->id)->delete();
        } else {
            if ($publicacao->deslikes()->where('user_id', $user->id)->exists()) {
                $publicacao->deslikes()->where('user_id', $user->id)->delete();
            }
            $publicacao->likes()->create(['user_id' => $user->id]);
        }



        return back();
    }

    public function deslike(Publicacao $publicacao)
    {
        $user = auth()->user();
        if ($publicacao->deslikes()->where('user_id', $user->id)->exists()) {
            $publicacao->deslikes()->where('user_id', $user->id)->delete(); // remove deslike
        } else {
            if ($publicacao->likes()->where('user_id', $user->id)->exists()) {
                $publicacao->likes()->where('user_id', $user->id)->delete();
            }
            $publicacao->deslikes()->create(['user_id' => $user->id]);
        }

        return back();
    }

}