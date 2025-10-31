<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublicacaoController;
use App\Http\Controllers\ComentarioController;
use App\Models\Publicacao;

Route::get('/', [PublicacaoController::class, 'index']);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    
    
    Route::post('publicacoes/{publicacao}/like', [PublicacaoController::class, 'like'])->name('publicacoes.like');
    Route::post('publicacoes/{publicacao}/deslike', [PublicacaoController::class, 'deslike'])->name('publicacoes.deslike');
    
    Route::post('/comentario/{publicacaoId}', [ComentarioController::class, 'store'])->name('comentario.store');
    Route::put('/comentario/{id}', [ComentarioController::class, 'update'])->name('comentario.update');
    Route::delete('/comentario/{id}', [ComentarioController::class, 'destroy'])->name('comentario.destroy');
    Route::get('/comentarios/toggle/{publicacaoId}', [ComentarioController::class, 'toggleComentarios'])->name('comentarios.toggle');
    


});

Route::get('/publicacoes', [PublicacaoController::class, 'index'])->name('publicacoes.index');

require __DIR__.'/auth.php';