<?php

namespace App\Http\Controllers;

use App\Projeto;
use App\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsuarioProjetoController extends Controller
{
    public function getUsuariosProjetos(Projeto $projeto)
    {
        $usuarios = $projeto->usuarios()->orderBy('nome')->paginate(10);

        $usuarios->getCollection()->transform(function ($usuario) use ($projeto) {
            if ($usuario->usuarioId == $projeto->usuarioId) {
                $usuario->criador = true;
            }

            $usuario->dataPermissao = Carbon::parse($usuario->dataPermissao)->format('d/m/Y H:i');

            return $usuario;
        });

        return $usuarios;
    }

    public function getUsuariosProjetoLookup(Request $request, Projeto $projeto)
    {
        $query = Usuario::whereDoesntHave('projetos', function ($query) use ($projeto) {
            $query->where('projetos.projetoId', '=', $projeto->projetoId);
        })->orderBy('nome');

        if ($request->nome) {
            $query->where(function ($query) use ($request) {
                $query->where(DB::raw('nome'), 'like', '%' . mb_strtolower($request->nome) . '%');
                $query->orWhere(DB::raw('username'), 'like', '%' . mb_strtolower($request->nome) . '%');
            });
        }

        return $query->paginate(10);
    }

    public function postUsuarioProjeto(Request $request, Projeto $projeto)
    {
        if (!$projeto->usuarios()->where('usuarios.usuarioId', '=', $request->usuario)->exists()) {
            return $projeto->usuariosProjeto()->create([
                'usuarioId' => $request->usuario,
            ]);
        }
    }

    public function deleteUsuarioProjeto(Projeto $projeto, Usuario $usuario)
    {
        if ($projeto->usuarios()->where('usuarios.usuarioId', '=', $usuario->usuarioId)->exists()) {
            if ($projeto->usuarioId == $usuario->usuarioId) {
                abort(403);
            }

            return $projeto->usuariosProjeto()->where('usuarioId', '=', $usuario->usuarioId)->delete();
        }

        abort(404);
    }
}
