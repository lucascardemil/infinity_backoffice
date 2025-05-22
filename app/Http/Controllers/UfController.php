<?php

namespace App\Http\Controllers;

use App\Models\Uf;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UFController extends Controller
{
    use AuthorizesRequests;
    
    
    public function __construct()
    {
        $this->middleware('permission:uf')->only('index');
    }

    public function index()
    {
        return view('admin.uf.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        try {
            $uf = UF::first();
            if (!$uf) {
                return response()->json(['message' => 'UF no encontrado'], 404);
            }
            return response()->json($uf, 200);
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
       $uf = UF::first();
        if ($uf) {
            $uf->update([
                'valor_uf' => $request->valor_uf
            ]);
        } else {
            UF::create([
                'valor_uf' => $request->valor_uf
            ]);
        }
        return response()->json(['message' => 'La UF fue actualizada correctamente']);
    }
}
