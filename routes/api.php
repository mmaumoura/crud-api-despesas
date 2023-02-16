<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\DespesasController;

Route::post('/registrar', [AuthController::class, 'registrar']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/despesas', [DespesasController::class, 'index']);
    Route::post('/adicionar-despesa', [DespesasController::class, 'store']);
    Route::put('/editar-despesa/{id}', [DespesasController::class, 'update']);
    Route::delete('/excluir-despesa/{id}', [DespesasController::class, 'destroy']);
});
