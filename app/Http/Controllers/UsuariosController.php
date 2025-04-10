<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use App\Models\ImagenUser;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\ImageCloudinaryController;

class UsuariosController extends Controller
{
    use AuthorizesRequests;
    protected $configuracionController;
    protected $imageCloudinaryController;

    public function __construct(ImageCloudinaryController $imageCloudinaryController, ConfiguracionController $configuracionController)
    {
        $this->middleware('permission:usuarios');
        $this->imageCloudinaryController = $imageCloudinaryController;
        $this->configuracionController = $configuracionController;
    }

    public function index()
    {
        return view('admin.usuarios.index');
    }

    public function all()
    {
        $users = User::with('roles', 'imagenes')->get();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'imagen' => 'file|mimes:jpg,jpeg,png|max:2048', // Validación de imagen
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $url_imagen_cloudinary = null;
        if ($request->hasFile('imagen')) {
            $uploadedImage = $this->imageCloudinaryController->upload($request, 'usuarios');
            $url_imagen_cloudinary = $uploadedImage->getData(true)['url'] ?? null;
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
            ]);

            if ($url_imagen_cloudinary && $user) {
                ImagenUser::create([
                    'user_id' => $user->id,
                    'ruta_imagen' => $url_imagen_cloudinary,
                    'estado' => 1,
                ]);
            }

            return response()->json(['message' => 'Usuario creado exitosamente', 'user' => $user], 201);
        } catch (\Exception $e) {
            Log::error('Error al crear el usuario: ' . $e->getMessage());
            return response()->json(['message' => 'Hubo un error al crear el usuario.'], 500);
        }
    }

    public function eliminarImagen(Request $request)
    {
        try {
            $publicId = $this->imageCloudinaryController->getPublicIdFromUrl($request->url_imagen_cloudinary);
            $ImagenEliminada = $this->imageCloudinaryController->delete('usuarios/' .$publicId);
            ImagenUser::where('ruta_imagen', $request->url_imagen_cloudinary)->delete();
            return response()->json(['message' => 'Imagen borrada correctamente', 'success' => $ImagenEliminada], 201);
        } catch (\Exception $e) {
            Log::error('Error al borrar la imagen: ' . $e->getMessage());
            return response()->json(['errors' => 'Hubo un error al borrar la imagen.'], 500);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($request->id)
            ],
            'phone' => 'required|string|max:255',
            'imagen' => 'file|mimes:jpg,jpeg,png|max:2048', // Validación de imagen
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 200);
        }

        $url_imagen_cloudinary = null;
        if ($request->hasFile('imagen')) {
            $uploadedImage = $this->imageCloudinaryController->upload($request, 'usuarios');
            $url_imagen_cloudinary = $uploadedImage->getData(true)['url'] ?? null;
        }

        try {

            $user = User::findOrFail($request->id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone
            ]);

            if ($url_imagen_cloudinary && $user) {

                $imagen = ImagenUser::where('user_id', $request->id)->first();

                if ($imagen) {
                    ImagenUser::where('user_id', $request->id)->update([
                        'ruta_imagen' => $url_imagen_cloudinary,
                        'estado' => 1,
                    ]);
                } else {
                    ImagenUser::create([
                        'user_id' => $user->id,
                        'ruta_imagen' => $url_imagen_cloudinary,
                        'estado' => 1,
                    ]);
                }
            }

            return response()->json(['message' => 'Usuario actualizado exitosamente', 'user' => $user], 200);
        } catch (\Exception $e) {
            Log::error('Error al crear el usuario: ' . $e->getMessage());
            return response()->json(['message' => 'Hubo un error al crear el usuario.'], 500);
        }
    }



    public function update_rol(Request $request, $id)
    {
        if ($request->rol_id === null) {
            return response()->json(['errors' => 'No selecciono ningun rol'], 201);
        }

        $user = User::findOrFail($id);
        $role = Role::findOrFail($request->rol_id);
        $user->syncRoles([$role]);
        return response()->json(['message' => 'El Rol del Usuario se actualizo', 'user' => $user], 201);
    }

    public function update_status(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'status' => $request->status
        ]);
        return response()->json(['message' => 'El estado del usuario se actualizó correctamente', 'user' => $user], 201);
    }

    public function update_password(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $user = User::findOrFail($id);
        $user->update([
            'password' => bcrypt($request->password),
        ]);

        $email_logeado = Auth::user()->email;
        $logout = false;
        if ($email_logeado == $user->email) {
            $logout = true;
        }
        return response()->json(['message' => 'La contraseña se actualizo correctamente', 'logout' => $logout], 201);
    }
}
