<?php

namespace App\Http\Controllers;

use App\HistoricoTarefa;
use App\Projeto;
use App\Situacao;
use App\Tarefa;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TarefaController extends Controller
{
    public function getTarefas(Projeto $projeto)
    {
        $tarefas = $projeto->tarefas()
            ->with('situacao', 'criador', 'atribuido')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $tarefas->getCollection()->transform(function ($tarefa) {
            return [
                'id' => $tarefa->tarefaId,
                'titulo' => $tarefa->titulo,
                'situacao' => $tarefa->situacao->nome,
                'atribuido' => $tarefa->atribuido->nome ?? null,
                'dataCriacao' => $tarefa->created_at->format('d/m/Y H:i'),
            ];
        });

        return $tarefas;
    }

    public function getTarefa(Projeto $projeto, Tarefa $tarefa)
    {
        if ($projeto->projetoId != $tarefa->projetoId) {
            abort(404);
        }

        $tarefa->load(['situacao', 'atribuido', 'criador']);

        $dados = $this->getDados($projeto);

        return [
            'tarefa' => [
                'titulo' => $tarefa->titulo,
                'descricao' => $tarefa->descricao,
                'situacao' => $tarefa->situacao->situacaoId,
                'atribuido' => $tarefa->atribuido->usuarioId ?? null,
                'criador' => $tarefa->criador->nome,
            ],
            'usuarios' => $dados['usuarios'],
            'situacoes' => $dados['situacoes'],
        ];
    }

    public function getDados(Projeto $projeto)
    {
        return [
            'usuarios' => $projeto->usuarios()->orderBy('nome')->get(['usuarios.usuarioId as id', 'nome']),
            'situacoes' => Situacao::get(['situacaoId as id', 'nome']),
        ];
    }

    public function postTarefa(Request $request, Projeto $projeto)
    {
        $tarefa = Tarefa::firstOrNew([
            'tarefaId' => $request->tarefa
        ]);

        if (!isset($request->tarefa)) {
            $tarefa->usuarioCriadorId = Auth::user()->usuarioId;
            $tarefa->projetoId = $projeto->projetoId;
            $tarefa->titulo = $request->titulo;
            $tarefa->descricao = $request->descricao;
        }

        if (isset($request->tarefa) && !$tarefa->wasRecentlyCreated) {
            $historico = $tarefa->historico()->create([
                'usuarioId' => Auth::user()->usuarioId,
                'comentario' => $request->comentario,
            ]);

            if ($tarefa->usuarioId != $request->atribuido) {
                $historico->campos()->create([
                    'nomeCampo' => 'usuarioId',
                    'antes'     => $tarefa->atribuido->nome ?? null,
                    'depois'    => Usuario::find($request->atribuido)->nome ?? null,
                ]);
            }

            if ($tarefa->situacaoId != $request->situacao) {
                $historico->campos()->create([
                    'nomeCampo' => 'situacaoId',
                    'antes'     => $tarefa->situacao->nome,
                    'depois'    => Situacao::find($request->situacao)->nome,
                ]);
            }
        }

        $tarefa->usuarioId = $request->atribuido;
        $tarefa->situacaoId = $request->situacao;

        $tarefa->save();

        return $tarefa->only(['tarefaId', 'titulo', 'descricao']);
    }

    public function getHistorico(Projeto $projeto, Tarefa $tarefa)
    {
        if ($projeto->projetoId != $tarefa->projetoId) {
            abort(404);
        }

        $historico = $tarefa->historico()->with('campos', 'usuario')->orderBy('created_at', 'asc')->get();

        $historico->map(function ($registro) {
            $registro->criacao = $registro->created_at->format('d/m/Y H:i');

            return $registro;
        });

        return [
            'historico' => $historico,
        ];
    }
}
