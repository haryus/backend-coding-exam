<?php

namespace App\Http\Controllers\API;

use App\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        return Role::all();
    }
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    
        $role = Role::create($request->all());
        return response()->json($role, 201);
    }
    public function show($id)
    {
        $role = Role::findOrFail($id);
        return response()->json([
            'role' => $role,
        ]);
    }    
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $role->update($request->all());
        return response()->json([
            'message' => 'Role successfully updated.',
            'role' => $role,
        ], 200);
    }    
    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->users()->delete();
            $role->delete();
            return response()->json([
                'message' => 'Role successfully deleted.'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Role not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the user.'
            ], 500);
        }
    }
    public function rolesWithUsers()
    {
        $rolesWithoutUsers = Role::doesntHave('users')->get();

        return response()->json($rolesWithoutUsers);
    }
}
