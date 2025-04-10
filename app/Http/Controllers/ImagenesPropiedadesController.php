<?php

namespace App\Http\Controllers;

use App\Models\ImagePropiedad;
use Illuminate\Http\Request;
use App\Http\Controllers\ImageCloudinaryController;

class ImagenesPropiedadesController extends Controller
{
    protected $imageCloudinaryController;

    public function __construct(ImageCloudinaryController $imageCloudinaryController)
    {
        $this->imageCloudinaryController = $imageCloudinaryController;
    }

    public function delete_imagen(Request $request)
    {
        $id_imagen = $request->id;
        $nombre_imagen = $this->imageCloudinaryController->getPublicIdFromUrl($request->ruta_imagen);

        $response = $this->imageCloudinaryController->delete('propiedades/' .$nombre_imagen);
        $responseData = $response->getData(true);

        if ($responseData['status'] === true) {
            ImagePropiedad::destroy($id_imagen);
            return response()->json([
                'status' => true,
                'message' => 'Imagen eliminada correctamente'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'No se pudo eliminar la imagen'
        ]);
    }

    public function update_imagen_principal(Request $request)
    {
        foreach ($request->imagenes as $index => $imagen) {
            $imagen_propiedad = ImagePropiedad::find($imagen['id']);

            if (!$imagen_propiedad) {
                return response()->json([
                    'status' => false,
                    'message' => 'Imagen no encontrada'
                ]);
            }

            if($imagen['principal'] === true){
                $imagen_propiedad->update(['principal' => 1]);
            }else{
                $imagen_propiedad->update(['principal' => 0]);
            }
        }
    }
}
