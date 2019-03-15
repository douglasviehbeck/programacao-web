<?php

namespace App\Http\Controllers;

use App\Exceptions\ErrorMessageException;
use App\Projeto;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjetosController extends Controller
{
    public function projetos()
    {
        return Projeto::with('criador')->get()->map(function ($projeto) {
            return [
                'id' => $projeto->projetoId,
                'nome' => $projeto->nome,
                'criador' => $projeto->criador->nome,
            ];
        });
    }

    public function usuariosPossiveis()
    {
        return Usuario::where('usuarioId', '<>', Auth::user()->usuarioId)->get(['usuarioId as id', 'nome']);
    }

    public function salvar(Request $request)
    {
        $this->validarProjeto($request->all());

        Projeto::create([
            'nome' => $request->nome,
            'descricao' => $request->descricao,
            'usuarioId' => Auth::user()->usuarioId,
        ]);
    }

    private function validarProjeto($inputs)
    {
        $mensagens = [];

        if (empty($inputs['nome'])) {
            $mensagens['nome'] = 'O campo é obrigatório';
        } else if (Projeto::where('nome', $inputs['nome'])->exists()) {
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
