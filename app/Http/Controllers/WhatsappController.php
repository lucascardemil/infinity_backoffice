<?php

namespace App\Http\Controllers;

use App\Models\Whatsapp;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class WhatsappController extends Controller
{
    use AuthorizesRequests;
    
    
    public function __construct()
    {
        $this->middleware('permission:whatsapp')->only('index');
    }

    public function index()
    {
        return view('admin.whatsapp.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        try {
            $whatsapp = Whatsapp::first();
            if (!$whatsapp) {
                return response()->json(['message' => 'Whatsapp no encontrado'], 200);
            }
            return response()->json($whatsapp, 200);
        } catch (\Exception $e) {
            // Captura cualquier error inesperado
            return response()->json(['message' => 'Server Error', 'error' => $e->getMessage()], 500);
        }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $whatsapp = Whatsapp::first();
        if ($whatsapp) {
            $whatsapp->update([
                'numero' => $request->numero,
                'mensaje' => $request->mensaje,
                'estado' => $request->estado
            ]);
        } else {
            Whatsapp::create([
                'numero' => $request->numero,
                'mensaje' => $request->mensaje,
                'estado' => $request->estado
            ]);
        }
        return response()->json(['message' => 'El Whatsapp fue actualizada correctamente']);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $whatsapp = Whatsapp::findOrFail($id);
            $whatsapp->update([
            'estado' => $request->estado
            ]);
            $mensaje = $request->estado == 1 ? 'Whatsapp habilitado' : 'Whatsapp deshabilitado';
            return response()->json(['message' => $mensaje], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Server Error', 'error' => $e->getMessage()], 500);
        }
    }
}
