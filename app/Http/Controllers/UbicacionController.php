<?php

namespace App\Http\Controllers;

use App\Models\Ubicacion;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UbicacionController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:ubicacion')->only('index');
    }

    public function index()
    {
        return view('admin.ubicacion.index');
    }

    public function all_select()
    {
        $ubicaciones = Ubicacion::where('estado', '=', 1)->get()->groupBy('region');
        $result = [];

        foreach ($ubicaciones as $region => $ciudades) {
            $result[] = [
                'region' => $region,
                'ciudades' => $ciudades->map(function ($ciudad) {
                    return [
                        'id' => $ciudad->id,
                        'ciudad' => $ciudad->ciudad,
                        'estado' => $ciudad->estado,
                    ];
                })->toArray(),
            ];
        }

        return response()->json($result);
    }

    public function all()
    {
        $ubicaciones = Ubicacion::all();
        return response()->json($ubicaciones);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'region' => 'required|string|max:255',
            'ciudad' => 'required|string|max:255|unique:ubicaciones,ciudad',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $ubicacion = Ubicacion::create([
            'region' => $request->region,
            'ciudad' => $request->ciudad,
            'estado' => 0,
        ]);

        return response()->json(['message' => 'Region y Ciudad creado exitosamente', 'ubicacion' => $ubicacion], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'region' => [
                'required',
                'string',
                'max:255',
                Rule::unique('ubicaciones', 'region')->ignore($id),
            ]
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $ubicacion = Ubicacion::findOrFail($id);
        $ubicacion->update([
            'region' => $request->region,
            'ciudad' => $request->ciudad,
        ]);
        return response()->json(['message' => 'El region y ciudad se actualizo', 'ubicacion' => $ubicacion], 201);
    }

    public function update_status(Request $request, $id)
    {
        $ubicacion = Ubicacion::findOrFail($id);
        $ubicacion->update([
            'estado' => $request->estado
        ]);
        return response()->json(['message' => 'El estado del region y ciudad se actualizó correctamente', 'ubicacion' => $ubicacion], 201);
    }
}
