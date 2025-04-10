<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\CategoriaSecundaria;

class CategoriaSecundariaController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:categoria_secundaria')->only('index');
    }

    public function index()
    {
        return view('admin.categoria_secundaria.index');
    }

    public function all_select()
    {
        $categorias_propiedades = CategoriaSecundaria::where('estado', '=', 1)->get();
        return response()->json($categorias_propiedades);
    }

    public function all()
    {
        $categorias_propiedades = CategoriaSecundaria::all()->map(function ($categoria) {
            $categoria->estado = $categoria->estado == 1 ? true : false;
            return $categoria;
        });
        return response()->json($categorias_propiedades);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:categoria_secundarias,nombre',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $categoria_propiedad = CategoriaSecundaria::create([
            'nombre' => $request->nombre,
            'estado' => 0,
        ]);

        return response()->json(['message' => 'Categoria de la propiedad creado exitosamente', 'categoria_propiedad' => $categoria_propiedad], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => [
            'required',
            'string',
            'max:255',
            Rule::unique('categoria_secundarias', 'nombre')->ignore($id),
        ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $categoria_propiedad = CategoriaSecundaria::findOrFail($id);
        $categoria_propiedad->update([
            'nombre' => $request->nombre
        ]);
        return response()->json(['message' => 'La categoria secundaria se actualizo', 'categoria_propiedad' => $categoria_propiedad], 201);
    }

    public function update_status(Request $request, $id)
    {
        $categoria_propiedad = CategoriaSecundaria::findOrFail($id);
        $categoria_propiedad->update([
            'estado' => $request->estado
        ]);
        return response()->json(['message' => 'El estado del categoria secundaria se actualizó correctamente', 'categoria_propiedad' => $categoria_propiedad], 201);
    }
}
