<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorMessageException;
use App\Projeto;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjetosController extends Controller
{
    public function projetos()
    {
        return Projeto::with('criador')->orderBy('nome')->get()->map(function ($projeto) {
            return [
                'id' => $projeto->projetoId,
                'nome' => $projeto->nome,
                'criador' => $projeto->criador->nome,
            ];
        });
    }

    public function dados(Projeto $projeto)
    {
        $projeto = $projeto->load(['usuarios' => function ($query) {
            $query->select('usuarios.usuarioId as id');
        }])->only(['nome', 'descricao', 'usuarios']);

        $projeto['usuarios'] = $projeto['usuarios']->map->id;

        return [
            'usuarios' => Usuario::where('usuarioId', '<>', Auth::user()->usuarioId)->get(['usuarioId as id', 'nome']),
            'projeto' => $projeto,
        ];
    }

    public function salvar(Request $request)
    {
        $this->validarProjeto($request->all());

        $projeto = Projeto::firstOrNew([
            'projetoId' => $request->projeto
        ]);

        $projeto->nome = $request->nome;
        $projeto->descricao = $request->descricao;

        if (!isset($request->projeto)) {
            $projeto->usuarioId = Auth::user()->usuarioId;
        }

        $projeto->save();

        $projeto->usuarios()->sync($request->usuarios);

        return $projeto->usuarios;
    }

    public function deletar(Projeto $projeto)
    {
        $projeto->usuariosProjeto()->delete();
        $projeto->delete();
    }

    private function validarProjeto($inputs)
    {
        $mensagens = [];

        if (isset($inputs['projeto']) && !Projeto::where('projetoId', $inputs['projeto'])->exists()) {
            $mensagens[] = 'O projeto de edição não existe';
        }

        if (empty($inputs['nome'])) {
            $mensagens['nome'] = 'O campo é obrigatório';
        } else if (!isset($inputs['projeto']) && Projeto::where('nome', $inputs['nome'])->exists()) {
            $mensagens['nome'] = 'Já existe um projeto com este nome';
        }

        if (empty($inputs['descricao'])) {
            $mensagens['descricao'] = 'O campo é obrigatório';
        }

        if (sizeof($mensagens)) {
            throw new ErrorMessageException($mensagens);
        }
    }
}
