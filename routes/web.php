<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/admin/login', function () {
    return view('admin.auth.login');
})->name('admin.login');

Route::get('/admin', function () {
    return view('admin.auth.login');
})->name('admin.login');


Route::get('/admin/home', [App\Http\Controllers\HomeController::class, 'index'])->name('admin.home');

Route::group(['middleware' => 'web'], function () {
    Auth::routes();

    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
});

Route::get('/user/role', [App\Http\Controllers\HomeController::class, 'getUserRole'])->middleware('auth');
Route::post('/upload-image', [App\Http\Controllers\ImageCloudinaryController::class, 'upload']);
Route::delete('/delete-image', [App\Http\Controllers\ImageCloudinaryController::class, 'delete']);



Route::group(['middleware' => ['auth', 'permission:configuraciones']], function () {
    Route::get('/admin/configuraciones', [App\Http\Controllers\ConfiguracionController::class, 'index'])->name('admin.configuraciones.index');
    Route::post('/configuraciones/store', [App\Http\Controllers\ConfiguracionController::class, 'store']);
});


Route::group(['middleware' => ['auth', 'permission:propiedad']], function () {
    Route::get('/admin/propiedad', [App\Http\Controllers\PropiedadController::class, 'index'])->name('admin.propiedad.index');
    Route::get('/propiedad/all', [App\Http\Controllers\PropiedadController::class, 'all']);
    Route::get('/propiedad/buscar_direccion/{lat}/{lng}', [App\Http\Controllers\PropiedadController::class, 'buscar_direccion']);
    Route::post('/propiedad/store', [App\Http\Controllers\PropiedadController::class, 'store']);
    Route::post('/propiedad/update', [App\Http\Controllers\PropiedadController::class, 'update']);
    Route::delete('/propiedad/delete/{id}', [App\Http\Controllers\PropiedadController::class, 'delete']);
    Route::post('/propiedad/delete-imagen', [App\Http\Controllers\ImagenesPropiedadesController::class, 'delete_imagen']);
    Route::post('/propiedad/update-imagen-principal', [App\Http\Controllers\ImagenesPropiedadesController::class, 'update_imagen_principal']);
});

Route::group(['middleware' => ['auth', 'permission:atributo_adicional']], function () {
    Route::get('/admin/atributo_adicional', [App\Http\Controllers\AtributoAdicionalController::class, 'index'])->name('admin.atributo_adicional.index');
    Route::get('/atributo_adicionales/all', [App\Http\Controllers\AtributoAdicionalController::class, 'all']);
    Route::post('/atributo_adicionales/store', [App\Http\Controllers\AtributoAdicionalController::class, 'store']);
    Route::post('/atributo_adicionales/update', [App\Http\Controllers\AtributoAdicionalController::class, 'update']);
    Route::put('/atributo_adicionales/update-status/{id}', [App\Http\Controllers\AtributoAdicionalController::class, 'update_status']);
    Route::post('/atributo_adicionales/eliminar-imagen', [App\Http\Controllers\AtributoAdicionalController::class, 'eliminar_imagen']);
});

Route::group(['middleware' => ['auth', 'permission:categoria_secundaria']], function () {
    Route::get('/admin/categoria_secundaria', [App\Http\Controllers\CategoriaSecundariaController::class, 'index'])->name('admin.categoria_secundaria.index');
    Route::get('/categoria_secundarias/all', [App\Http\Controllers\CategoriaSecundariaController::class, 'all']);
    Route::post('/categoria_secundarias/store', [App\Http\Controllers\CategoriaSecundariaController::class, 'store']);
    Route::put('/categoria_secundarias/update/{id}', [App\Http\Controllers\CategoriaSecundariaController::class, 'update']);
    Route::put('/categoria_secundarias/update-status/{id}', [App\Http\Controllers\CategoriaSecundariaController::class, 'update_status']);
});


Route::group(['middleware' => ['auth', 'permission:ubicacion']], function () {
    Route::get('/admin/ubicacion', [App\Http\Controllers\UbicacionController::class, 'index'])->name('admin.ubicacion.index');
    Route::get('/ubicaciones/all', [App\Http\Controllers\UbicacionController::class, 'all']);
    Route::post('/ubicaciones/store', [App\Http\Controllers\UbicacionController::class, 'store']);
    Route::put('/ubicaciones/update/{id}', [App\Http\Controllers\UbicacionController::class, 'update']);
    Route::put('/ubicaciones/update-status/{id}', [App\Http\Controllers\UbicacionController::class, 'update_status']);
});

Route::group(['middleware' => ['auth', 'permission:tipo_propiedad']], function () {
    Route::get('/admin/tipo_propiedad', [App\Http\Controllers\TipoPropiedadController::class, 'index'])->name('admin.tipo_propiedad.index');
    Route::get('/tipos_propiedades/all', [App\Http\Controllers\TipoPropiedadController::class, 'all']);
    Route::post('/tipos_propiedades/store', [App\Http\Controllers\TipoPropiedadController::class, 'store']);
    Route::put('/tipos_propiedades/update/{id}', [App\Http\Controllers\TipoPropiedadController::class, 'update']);
    Route::put('/tipos_propiedades/update-status/{id}', [App\Http\Controllers\TipoPropiedadController::class, 'update_status']);
});

Route::group(['middleware' => ['auth', 'permission:formato_negocio']], function () {
    Route::get('/admin/formato_negocio', [App\Http\Controllers\FormatoNegocioController::class, 'index'])->name('admin.formato_negocio.index');
    Route::get('/formato_negocios/all', [App\Http\Controllers\FormatoNegocioController::class, 'all']);
    Route::post('/formato_negocios/store', [App\Http\Controllers\FormatoNegocioController::class, 'store']);
    Route::put('/formato_negocios/update/{id}', [App\Http\Controllers\FormatoNegocioController::class, 'update']);
    Route::put('/formato_negocios/update-status/{id}', [App\Http\Controllers\FormatoNegocioController::class, 'update_status']);
});

Route::group(['middleware' => ['auth', 'permission:usuarios']], function () {
    Route::get('/admin/usuarios', [App\Http\Controllers\UsuariosController::class, 'index'])->name('admin.usuarios.index');
    Route::get('/usuarios/all', [App\Http\Controllers\UsuariosController::class, 'all']);
    Route::post('/usuarios/store', [App\Http\Controllers\UsuariosController::class, 'store']);
    Route::post('/usuarios/update', [App\Http\Controllers\UsuariosController::class, 'update']);
    Route::put('/usuarios/update-rol/{id}', [App\Http\Controllers\UsuariosController::class, 'update_rol']);
    Route::put('/usuarios/update-status/{id}', [App\Http\Controllers\UsuariosController::class, 'update_status']);
    Route::put('/usuarios/update-password/{id}', [App\Http\Controllers\UsuariosController::class, 'update_password']);
    Route::get('/usuarios/imagen', [App\Http\Controllers\UsuariosController::class, 'obtenerImagen']);
    Route::post('/usuarios/eliminar-imagen', [App\Http\Controllers\UsuariosController::class, 'eliminarImagen']);
});

Route::group(['middleware' => ['auth', 'permission:roles']], function () {
    Route::get('/admin/roles', [App\Http\Controllers\RolesController::class, 'index'])->name('admin.roles.index');
    Route::get('/roles/all', [App\Http\Controllers\RolesController::class, 'all']);
    Route::post('/roles/store', [App\Http\Controllers\RolesController::class, 'store']);
    Route::put('/roles/update/{id}', [App\Http\Controllers\RolesController::class, 'update']);
    Route::get('/permissions', [App\Http\Controllers\PermissionController::class, 'index']);
});

Route::group(['middleware' => ['auth', 'permission:clientes']], function () {
    Route::get('/admin/clientes', [App\Http\Controllers\ClientesController::class, 'index'])->name('admin.clientes.index');
    Route::get('/clientes/all', [App\Http\Controllers\ClientesController::class, 'all']);
    Route::put('/clientes/update-status/{id}', [App\Http\Controllers\ClientesController::class, 'update_status']);
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/tipos_propiedades/all-select', [App\Http\Controllers\TipoPropiedadController::class, 'all_select']);
    Route::get('/formato_negocios/all-select', [App\Http\Controllers\FormatoNegocioController::class, 'all_select']);
    Route::get('/ubicaciones/all-select', [App\Http\Controllers\UbicacionController::class, 'all_select']);
    Route::get('/categoria_secundarias/all-select', [App\Http\Controllers\CategoriaSecundariaController::class, 'all_select']);
    Route::get('/atributo_adicionales/all-select', [App\Http\Controllers\AtributoAdicionalController::class, 'all_select']);
});



Route::get('/', [App\Http\Controllers\LandingController::class, 'home'])->name('landing.home');
Route::get('/propiedad/{titulo?}', [App\Http\Controllers\LandingController::class, 'propiedad'])->name('landing.propiedad');
Route::get('/landing/propiedades', [App\Http\Controllers\LandingController::class, 'propiedades']);
Route::get('/landing/agentes', [App\Http\Controllers\LandingController::class, 'agentes']);
Route::get('/configuraciones/all', [App\Http\Controllers\ConfiguracionController::class, 'all']);
Route::post('/clientes/store', [App\Http\Controllers\LandingController::class, 'store']);


Route::get('/storage-link', function () {
    $targetFolder = storage_path('app/public');
    $linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';
    symlink($targetFolder, $linkFolder);
});
