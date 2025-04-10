<?php

namespace App\Http\Controllers;

use App\Models\Configuracion;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ConfiguracionController extends Controller
{
    use AuthorizesRequests;
    protected $googleMapApiKey;

    public function __construct()
    {
        $this->middleware('permission:configuraciones')->only('index');
        $this->googleMapApiKey = env('GOOGLE_MAPS_API_KEY');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $configuracion = Configuracion::first();
        if ($configuracion) {
            return response()->json($configuracion);
        }

        return response()->json([
            'googleMapApiKey' => $this->googleMapApiKey
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.configuraciones.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $configuracion = Configuracion::first();
        if ($configuracion) {
            $configuracion->update([
                'api_google_maps' => $request->configuraciones['google_maps_api'],
            ]);
        } else {
            Configuracion::create([
                'api_google_maps' => $request->configuraciones['google_maps_api'],
            ]);
        }
        return response()->json(['message' => 'Configuración actualizada correctamente']);
    }
}
