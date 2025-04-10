<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RolesController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('permission:roles');
    }


    public function index()
    {
        return view('admin.roles.index');
    }


    public function all()
    {
        $roles = Role::with('permissions')->get();
        return response()->json($roles);
    }

    public function show($id)
    {
        $role = Role::findOrFail($id);
        return view('roles.show', compact('role'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $rol = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        return response()->json(['message' => 'Rol creado exitosamente', 'rol' => $rol], 201);
    }


    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($id),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 201);
        }

        $role = Role::findOrFail($id);

        $role->update([
            'name' => $request->name
        ]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return response()->json(['message' => 'Role updated successfully', 'role' => $role], 200);
    }


    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json(['message' => 'Role deleted successfully'], 200);
    }
}
