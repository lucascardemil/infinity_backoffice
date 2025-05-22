<?php

namespace App\Http\Controllers;

use App\Models\ImagePropiedad;
use App\Models\Propiedad;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Http\Controllers\ConfiguracionController;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ImageCloudinaryController;
use App\Http\Controllers\Auth\LoginController;

class PropiedadController extends Controller
{
    use AuthorizesRequests;
    protected $configuracionController;
    protected $imageCloudinaryController;
    protected $loginController;

    public function __construct(ImageCloudinaryController $imageCloudinaryController, ConfiguracionController $configuracionController, LoginController $loginController)
    {
        $this->middleware('permission:propiedad')->only('index');
        $this->configuracionController = $configuracionController;
        $this->imageCloudinaryController = $imageCloudinaryController;
        $this->loginController = $loginController;
    }

    public function index()
    {
        return view('admin.propiedad.index');
    }

    public function all()
    {
        $user = auth()->user(); // Obtener al usuario autenticado
        $userId = $user->id ?? null;
        $userRole = $user->roles->first()->name ?? null; // Obtener el nombre del rol del usuario

        // Verificar permisos de acceso según el rol
        if (!in_array($userRole, ['administrador', 'agente'])) {
            return response()->json(['message' => 'No tiene permisos para acceder a esta información'], 403);
        }

        // Crear la consulta base
        $query = Propiedad::with('imagenes');

        // Si el rol es 'agente', filtramos por el user_id del agente
        if ($userRole === 'agente') {
            $query->where('user_id', $userId);
        }

        // Obtener las propiedades
        $propiedades = $query->get();

        // Configurar los botones según el rol
        $botones = [
            'editar' => true,
            'eliminar' => $userRole === 'administrador', // Solo el administrador puede eliminar
            'ver' => true,
        ];

        // Devolver la respuesta con las propiedades y los botones
        return response()->json([
            'propiedades' => $propiedades,
            'botones' => $botones,
        ], 200);
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'tipo_propiedad_id' => 'required|integer',
            'formato_negocio_id' => 'required|integer',
            'valor_pesos' => 'required|string',
            'ubicacion_id' => 'required|integer',
            'm2_superficie' => 'required|numeric',
            'm2_construido' => 'required|numeric',
            'pisos' => 'required|integer',
            'dormitorios' => 'required|integer',
            'banos' => 'required|integer',
            'categoria_secundaria_id' => 'integer',
            'descripcion' => 'required|string',
            'direccion' => 'required|string',
            'imagenes' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $user = $this->loginController->getAuthenticatedUser();

        $propiedad = Propiedad::create([
            'user_id' => $user->original['id'] ?? null,
            'titulo' => $request->titulo,
            'tipo_propiedad_id' => $request->tipo_propiedad_id,
            'formato_negocio_id' => $request->formato_negocio_id,
            'valor_uf' => $request->valor_uf,
            'cantidad' => $request->cantidad,
            'tipo_valor' => $request->tipo_valor,
            'valor_pesos' => str_replace('.', '', $request->valor_pesos),
            'ubicacion_id' => $request->ubicacion_id,
            'm2_superficie' => $request->m2_superficie,
            'm2_construido' => $request->m2_construido,
            'pisos' => $request->pisos,
            'dormitorios' => $request->dormitorios,
            'banos' => $request->banos,
            'categoria_secundaria_id' => $request->categoria_secundaria_id,
            'atributos_adicionales' => $request->atributos_adicionales ?? '',
            'descripcion' => $request->descripcion,
            'direccion' => $request->direccion,
            'estado' => $request->estado_propiedad === 'null' ? 'no_disponible' : $request->estado_propiedad,
        ]);

        if ($request->has('imagenes')) {
            $imagenes = $request->imagenes;

            foreach ($imagenes as $index => $imagen) {
                $uploadedImage = $this->imageCloudinaryController->uploadPropiedades($imagen['archivo']);
                $url_imagen_cloudinary = $uploadedImage->getData(true)['url'] ?? null;

                ImagePropiedad::create([
                    'propiedad_id' => $propiedad->id,
                    'principal' => $imagen['principal'] == 'true' ? 1 : 0,
                    'posicion' => $index,
                    'ruta_imagen' => $url_imagen_cloudinary,
                    'estado' => 0,
                ]);
            }
        }

        return response()->json(['message' => 'La propiedad se creado exitosamente', 'propiedad' => $propiedad], 201);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'tipo_propiedad_id' => 'required|integer',
            'formato_negocio_id' => 'required|integer',
            'valor_pesos' => 'required|string',
            'ubicacion_id' => 'required|integer',
            'm2_superficie' => 'required|numeric',
            'm2_construido' => 'required|numeric',
            'pisos' => 'required|integer',
            'dormitorios' => 'required|integer',
            'banos' => 'required|integer',
            'categoria_secundaria_id' => 'integer',
            'atributos_adicionales' => 'required|string',
            'descripcion' => 'required|string',
            'direccion' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $propiedad = Propiedad::findOrFail($request->id);
        $propiedad->update([
            'titulo' => $request->titulo,
            'tipo_propiedad_id' => $request->tipo_propiedad_id,
            'formato_negocio_id' => $request->formato_negocio_id,
            'valor_uf' => $request->valor_uf,
            'cantidad' => $request->cantidad,
            'tipo_valor' => $request->tipo_valor,
            'valor_pesos' => str_replace('.', '', $request->valor_pesos),
            'ubicacion_id' => $request->ubicacion_id,
            'm2_superficie' => $request->m2_superficie,
            'm2_construido' => $request->m2_construido,
            'pisos' => $request->pisos,
            'dormitorios' => $request->dormitorios,
            'banos' => $request->banos,
            'categoria_secundaria_id' => $request->categoria_secundaria_id,
            'atributos_adicionales' => $request->atributos_adicionales,
            'descripcion' => $request->descripcion,
            'direccion' => $request->direccion,
            'estado' => $request->estado_propiedad === 'null' ? 'no_disponible' : $request->estado_propiedad,
        ]);

        if ($request->has('imagenes')) {
            $imagenes = $request->imagenes;

            foreach ($imagenes as $index => $imagen) {
                $uploadedImage = $this->imageCloudinaryController->uploadPropiedades($imagen['archivo']);
                $url_imagen_cloudinary = $uploadedImage->getData(true)['url'] ?? null;

                ImagePropiedad::create([
                    'propiedad_id' => $propiedad->id,
                    'principal' => $imagen['principal'] == 'true' ? 1 : 0,
                    'posicion' => $index,
                    'ruta_imagen' => $url_imagen_cloudinary,
                    'estado' => 0,
                ]);
            }
        }

        return response()->json(['message' => 'La propiedad se actualizo correctamente', 'propiedad' => $propiedad], 201);
    }

    public function delete($id)
    {
        $propiedad = Propiedad::findOrFail($id);
        $imagenes = ImagePropiedad::where('propiedad_id', $id)->get();

        foreach ($imagenes as $imagen) {
            $nombre_imagen = $this->imageCloudinaryController->getPublicIdFromUrl($imagen->ruta_imagen);
            $this->imageCloudinaryController->delete('propiedades/' . $nombre_imagen);
            $imagen->delete();
        }

        $propiedad->delete();

        return response()->json(['message' => 'La propiedad se elimino correctamente'], 200);
    }
}
