<?php

namespace App\Models\Api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Despesas extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'descricao',
        'valor',
        'data'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }
}
