<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Api\Despesas;
use Illuminate\Auth\Access\Response;

class DespesasPolicy
{
    public function __construct()
    {
        //
    }

    public function verDespesas($usuario, $despesas)
    {
        return $usuario->id === $despesa->user_id ? Response::allow() : Response::deny('Você não pode acessar as despesas.');
    }
}
