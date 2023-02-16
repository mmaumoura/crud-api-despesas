<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Api\Despesas;
use App\Models\User;
use Carbon\Carbon;
use App\Notifications\NotificaUsuario;
use Illuminate\Support\Facades\Notification;
use Auth;

class DespesasController extends Controller
{
    public function index()
    {
        $despesas = User::find(Auth::user()->id)->despesas;
        if(count($despesas) == 0){
            return response()->json('Este usuário não possui permissão para visualizar as despesas!', 401, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        } else{
            return response()->json($despesas, 200);
        }
    }

    public function store(Request $request)
    {   
        $usuario = User::where('id', $request['user_id'])->first();
        if(empty($usuario)){
            return response()->json(['mensagem' => 'Não foi possível localizar o usuário!',], 401,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        $validarDados = $request->validate([
            'descricao' => 'required|string|max:191',
            'valor' => 'required|string|min:0',
            'data' => 'required|date|before_or_equal:today',
        ]);
        $usuarioCreate = Despesas::create([
            'user_id' => $usuario->id,
            'descricao' => $validarDados['descricao'],
            'valor' => $validarDados['valor'],
            'data' => $validarDados['data']
        ]);
        Notification::send($usuario, new NotificaUsuario($usuario));
        return response()->json(['mensagem' => 'Despesa cadastrada com sucesso!'], 200);
    }

    public function update(Request $request, string $id)
    {
        $despesas = Despesas::findOrFail($id);
        if($despesa->user_id != Auth::user()->id){
            return response()->json('Este usuário não possui permissão para editar esta despesa!', 401, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        // foreach($despesas as $despesa){
        //     $this->authorize('verDespesas', $despesa);
        // }
        $usuario = User::where('id', $request['user_id'])->first();
        if(empty($usuario)){
            return response()->json(['mensagem' => 'Não foi possível localizar o usuário!'], 401,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        $validarDados = $request->validate([
            'descricao' => 'required|string|max:191',
            'valor' => 'required|string|min:0',
            'data' => 'required|date|before_or_equal:today',
        ]);
        $despesas->update($request->all());
        return response()->json(['mensagem' => 'Despesa editada com sucesso!'], 200);
    }

    public function destroy(string $id)
    {
        $despesas = Despesas::findOrFail($id);
        if($despesas->user_id != Auth::user()->id){
            return response()->json('Este usuário não possui permissão para editar esta despesa!', 401, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
        // foreach($despesas as $despesa){
        //     $this->authorize('verDespesas', $despesa);
        // }
        $despesas->delete();
        return response()->json(['mensagem' => 'Despesa excluída com sucesso!'], 200);
    }
}
