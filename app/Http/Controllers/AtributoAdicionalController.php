<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\AtributoAdicional;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\ImageCloudinaryController;

class AtributoAdicionalController extends Controller
{
    use AuthorizesRequests;
    protected $configuracionController;
    protected $imageCloudinaryController;

    public function __construct(ImageCloudinaryController $imageCloudinaryController, ConfiguracionController $configuracionController)
    {
        $this->middleware('permission:atributo_adicional')->only('index');
        $this->configuracionController = $configuracionController;
        $this->imageCloudinaryController = $imageCloudinaryController;
    }

    public function index()
    {
        return view('admin.atributo_adicional.index');
    }

    public function all_select()
    {
        $atributos_adicionales = AtributoAdicional::where('estado', '=', 1)->get();
        return response()->json($atributos_adicionales);
    }

    public function all()
    {
        $atributos_adicionales = AtributoAdicional::all()->map(function ($atributo_adicional) {
            $atributo_adicional->estado = $atributo_adicional->estado == 1 ? true : false;
            return $atributo_adicional;
        });
        return response()->json($atributos_adicionales);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:255|unique:atributo_adicionales,nombre',
            'imagen' => 'file|mimes:jpg,jpeg,png|max:2048', // Validación de imagen
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $url_imagen_cloudinary = null;
        if ($request->hasFile('imagen')) {
            $uploadedImage = $this->imageCloudinaryController->upload($request, 'iconos');
            $url_imagen_cloudinary = $uploadedImage->getData(true)['url'] ?? null;
        }

        try {
            $atributo_adicional = AtributoAdicional::create([
                'nombre' => $request->nombre,
                'ruta_imagen' => $url_imagen_cloudinary,
                'estado' => 0,
            ]);

            return response()->json(['message' => 'Atributo adicional creado exitosamente', 'atributo_adicional' => $atributo_adicional], 201);
        } catch (\Exception $e) {
            Log::error('Error al crear el usuario: ' . $e->getMessage());
            return response()->json(['message' => 'Hubo un error al crear el usuario.'], 500);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('atributo_adicionales', 'nombre')->ignore($request->id)
            ],
            'imagen' => 'file|mimes:jpg,jpeg,png|max:2048', // Validación de imagen
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $url_imagen_cloudinary = null;
        if ($request->hasFile('imagen')) {
            $uploadedImage = $this->imageCloudinaryController->upload($request, 'iconos');
            $url_imagen_cloudinary = $uploadedImage->getData(true)['url'] ?? null;
        }

        try {
            $imagen = AtributoAdicional::where('id', $request->id)->first();
            if ($imagen) {
                try {
                    // $this->googleDriveService->deleteFile($imagen->ruta_imagen);
                } catch (\Exception $e) {
                    Log::error('Error al eliminar la imagen en Google Drive: ' . $e->getMessage());
                }

                $atributo_adicional = AtributoAdicional::where('id', $request->id)->update([
                    'ruta_imagen' => $url_imagen_cloudinary,
                    'estado' => 1,
                ]);
            } else {
                $atributo_adicional = AtributoAdicional::where('id', $request->id)->update([
                    'nombre' => $request->nombre,
                    'estado' => 1,
                ]);
            }

            return response()->json(['message' => 'La categoria de la propiedad se actualizo', 'atributo_adicional' => $atributo_adicional], 201);
        } catch (\Exception $e) {
            Log::error('Error al actualizar el atributo: ' . $e->getMessage());
            return response()->json(['message' => 'Hubo un error al actualizar el atributo.'], 500);
        }
    }

    public function update_status(Request $request, $id)
    {
        $atributo_adicional = AtributoAdicional::findOrFail($id);
        $atributo_adicional->update([
            'estado' => $request->estado
        ]);
        return response()->json(['message' => 'El atributo adicional de la propiedad se actualizó correctamente', 'atributo_adicional' => $atributo_adicional], 201);
    }

    public function eliminar_imagen(Request $request)
    {
        try {
            $publicId = $this->imageCloudinaryController->getPublicIdFromUrl($request->url_imagen_cloudinary);
            $ImagenEliminada = $this->imageCloudinaryController->delete($publicId);
            $atributo_adicional = AtributoAdicional::where('ruta_imagen', $request->url_imagen_cloudinary)->first();
            $atributo_adicional->update([
                'ruta_imagen' => ''
            ]);
            return response()->json(['message' => 'Imagen borrada correctamente', 'success' => $ImagenEliminada], 201);
        } catch (\Exception $e) {
            Log::error('Error al borrar la imagen: ' . $e->getMessage());
            return response()->json(['errors' => 'Hubo un error al borrar la imagen.'], 500);
        }
    }
}
