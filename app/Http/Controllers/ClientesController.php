<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Auth\LoginController;

class ClientesController extends Controller
{
    use AuthorizesRequests;
    protected $loginController;

    public function __construct(LoginController $loginController)
    {
        $this->middleware('permission:clientes')->only('index');
        $this->loginController = $loginController;
    }

    public function index()
    {
        return view('admin.clientes.index');
    }


    public function all()
    {
        $user = auth()->user(); // Obtener al usuario autenticado
        $userId = $user->id ?? null;
        $userRole = $user->roles->first()->name ?? null; // Obtener el nombre del rol del usuario

        if (!in_array($userRole, ['administrador', 'agente'])) {
            return response()->json(['message' => 'No tiene permisos para acceder a esta información'], 403);
        }

        $query = Cliente::query();
        if ($userRole === 'agente') {
            $query->where('user_id', $userId);
        }

        $clientes = $query->get();

        return response()->json($clientes, 200);
    }

    public function update_status(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->update([
            'estado' => $request->estado
        ]);
        return response()->json(['message' => 'El estado del cliente se actualizó correctamente', 'cliente' => $cliente], 201);
    }

}
