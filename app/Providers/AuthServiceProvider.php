<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        'App\Models\Api\Despesas' => 'App\Policies\DespesasPolicy',
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
