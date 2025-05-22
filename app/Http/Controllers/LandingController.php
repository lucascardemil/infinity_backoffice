<?php

namespace App\Http\Controllers;

use App\Models\Propiedad;
use App\Models\User;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class LandingController extends Controller
{
    public function home()
    {
        return view('landing.home');
    }
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255',
            'user_id' => 'required|integer',
            'email' => 'required|email|max:255',
            'telefono' => 'required|string|max:255',
            'mensaje' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $cliente = Cliente::create([
            'user_id' => $request->user_id,
            'nombre' => $request->nombre,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'mensaje' => $request->mensaje,
            'propiedad' => $request->url_propiedad,
            'estado' => 0
        ]);

        $contenido = "Nombre: {$cliente['nombre']}\nEmail: {$cliente['email']}\nTeléfono: {$cliente['telefono']}\nMensaje: {$cliente['mensaje']}\nURL Propiedad: {$request->url_propiedad}\nTítulo Propiedad: {$request->titulo_propiedad}";

        try {
            Mail::raw($contenido, function ($message) {
            $message->to('contacto@inversionesinfinity.cl')
                ->subject('Nuevo mensaje desde el formulario de contacto');
            });
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            Log::error('Error al enviar el correo: ' . $e->getMessage());
        }

        return response()->json(['message' => '¡Gracias por contactarnos! Hemos recibido tu información y nos pondremos en contacto contigo a la brevedad por teléfono o correo electrónico.', 'cliente' => $cliente], 201);
    }

    public function propiedad($titulo = null)
    {
        if (!$titulo) {
            return redirect()->route('landing.home');
        }

        $tituloSinGuiones = str_replace('-', ' ', $titulo);
        $propiedad = Propiedad::with('imagenes', 'tipo_propiedad', 'formato_negocio', 'categoria_secundaria', 'ubicacion', 'users.imagenes')
            ->where('titulo', 'like', '%' . $tituloSinGuiones . '%')
            ->first();

        if (!$propiedad) {
            return redirect()->route('landing.home');
        }

        if ($propiedad->estado === 'no_disponible') {
            return redirect()->route('landing.home')->with('error', 'La propiedad no está disponible.');
        }

        return view('landing.propiedad', compact('propiedad'));
    }

    public function propiedades()
    {
        $propiedades = Propiedad::with('imagenes', 'tipo_propiedad', 'formato_negocio', 'categoria_secundaria', 'ubicacion', 'users.imagenes')
            ->where('estado', 'disponible')
            ->get();
        return response()->json($propiedades, 200);
    }

    public function agentes()
    {
        $agentes = User::select('id', 'name', 'phone', 'email') // Solo seleccionamos estos campos
            ->with(['imagenes', 'propiedades']) // Relación con imágenes
            ->whereHas('roles', function ($query) {
                $query->where('name', 'agente');
            })
            ->get();

        return response()->json($agentes, 200);
    }
}
