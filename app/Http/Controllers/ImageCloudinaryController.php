<?php

namespace App\Http\Controllers;

use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Cloudinary\Api\Admin\AdminApi;
use Exception;

class ImageCloudinaryController extends Controller
{
    public function uploadPropiedades($imagen)
    {

        $imagePath = $imagen->getRealPath();

        $uploadedImage = Cloudinary::upload($imagePath, [
            'folder' => 'propiedades'
        ]);

        return response()->json([
            'url' => $uploadedImage->getSecurePath()
        ]);
    }

    public function upload(Request $request, $carpeta)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imagePath = $request->file('imagen')->getRealPath();
        $uploadedImage = Cloudinary::upload($imagePath, [
            'folder' => $carpeta
        ]);

        return response()->json([
            'url' => $uploadedImage->getSecurePath()
        ]);
    }

    public function delete($id)
    {
        $deleteResponse = Cloudinary::destroy($id);

        if ($deleteResponse['result'] === 'not found') {
            return response()->json([
                'status' => false,
                'message' => 'Imagen no encontrada en Cloudinary'
            ], 404);
        }

        // Verificar si la imagen aún existe
        if ($this->imagenExisteCloudinary($id)) {
            return response()->json([
                'status' => false,
                'message' => 'La imagen no pudo ser eliminada'
            ], 500);
        }

        return response()->json([
            'status' => true,
            'message' => 'Imagen eliminada correctamente'
        ]);
    }

    public function getPublicIdFromUrl($url)
    {
        $basename = basename($url);
        $publicId = pathinfo($basename, PATHINFO_FILENAME);
        return $publicId;
    }

    public function imagenExisteCloudinary($public_id)
    {
        try {
            $api = new AdminApi();
            $api->asset($public_id);
            return true; // La imagen aún existe
        } catch (Exception $e) {
            return false; // La imagen no existe
        }
    }
}
