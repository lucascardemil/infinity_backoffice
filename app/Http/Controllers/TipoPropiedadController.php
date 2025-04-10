<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\TipoPropiedad;

class TipoPropiedadController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:tipo_propiedad')->only('index');
    }

    public function index()
    {
        return view('admin.tipo_propiedad.index');
    }

    public function all_select()
    {
        $tipos_propiedades = TipoPropiedad::where('estado', '=', 1)->get();
        return response()->json($tipos_propiedades);
    }

    public function all()
    {
        $tipos_propiedades = TipoPropiedad::all();
        return response()->json($tipos_propiedades);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:tipos_propiedades,nombre',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $tipo_propiedad = TipoPropiedad::create([
            'nombre' => $request->nombre,
            'estado' => 0,
        ]);

        return response()->json(['message' => 'Tipo propiedad creado exitosamente', 'tipo_propiedad' => $tipo_propiedad], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => [
            'required',
            'string',
            'max:255',
            Rule::unique('tipos_propiedades', 'nombre')->ignore($id),
        ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $tipo_propiedad = TipoPropiedad::findOrFail($id);
        $tipo_propiedad->update([
            'nombre' => $request->nombre
        ]);
        return response()->json(['message' => 'El tipo propiedad se actualizo', 'tipo_propiedad' => $tipo_propiedad], 201);
    }

    public function update_status(Request $request, $id)
    {
        $tipo_propiedad = TipoPropiedad::findOrFail($id);
        $tipo_propiedad->update([
            'estado' => $request->estado
        ]);
        return response()->json(['message' => 'El estado del tipo propiedad se actualizó correctamente', 'tipo_propiedad' => $tipo_propiedad], 201);
    }
}
