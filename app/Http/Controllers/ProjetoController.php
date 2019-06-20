<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorMessageException;
use App\Projeto;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjetoController extends Controller
{
    public function getProjetos()
    {
        $projetos = Projeto::with('criador')
            ->where('usuarioId', '=', Auth::user()->usuarioId)
            ->orWhereHas('usuarios', function ($query) {
                $query->where('usuarios.usuarioId', '=', Auth::user()->usuarioId);
            })
            ->orderBy('nome')->paginate(10);

        $projetos->getCollection()->transform(function ($projeto) {
            return [
                'id' => $projeto->projetoId,
                'nome' => $projeto->nome,
                'criador' => $projeto->criador->nome,
            ];
        });

        return $projetos;
    }

    public function getProjeto(Projeto $projeto)
    {
        return [
            'projeto' => $projeto->only(['nome', 'descricao']),
        ];
    }

    public function postProjeto(Request $request)
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

        if ($projeto->wasRecentlyCreated) {
            $projeto->usuarios()->attach(Auth::user());
        }

        return $projeto->only(['projetoId', 'nome', 'descricao']);
    }

    public function deleteProjeto(Projeto $projeto)
    {
        $projeto->usuariosProjeto()->delete();
        $projeto->delete();

        return ['success' => true];
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
