<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['publicacao_id', 'user_id', 'updated_at', 'created_at'];

    public function publicacao()
    {
        return $this->belongsTo(Publicacao::class, 'publicacao_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}