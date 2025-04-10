<?php

namespace App\Http\Controllers;

use App\Models\FormatoNegocio;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FormatoNegocioController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:formato_negocio')->only('index');
    }

    public function index()
    {
        return view('admin.formato_negocio.index');
    }

    public function all_select()
    {
        $formatos_negocios = FormatoNegocio::where('estado', '=', 1)->get();
        return response()->json($formatos_negocios);
    }

    public function all()
    {
        $formatos_negocios = FormatoNegocio::all();
        return response()->json($formatos_negocios);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:formato_negocios,nombre',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $formato_negocio = FormatoNegocio::create([
            'nombre' => $request->nombre,
            'estado' => 0,
        ]);

        return response()->json(['message' => 'Formato negocio creado exitosamente', 'formato_negocio' => $formato_negocio], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => [
            'required',
            'string',
            'max:255',
            Rule::unique('formato_negocios', 'nombre')->ignore($id),
        ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $formato_negocio = FormatoNegocio::findOrFail($id);
        $formato_negocio->update([
            'nombre' => $request->nombre
        ]);
        return response()->json(['message' => 'El formato negocio se actualizo', 'formato_negocio' => $formato_negocio], 201);
    }

    public function update_status(Request $request, $id)
    {
        $formato_negocio = FormatoNegocio::findOrFail($id);
        $formato_negocio->update([
            'estado' => $request->estado
        ]);
        return response()->json(['message' => 'El estado del formato negocio se actualizó correctamente', 'formato_negocio' => $formato_negocio], 201);
    }
}
