<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        return User::with('role')->get();
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255|unique:users,full_name',
            'email' => 'required|email|unique:users,email',
            'nominated_password' => 'nullable|min:6|confirmed',  // Make sure there is nominated_password_confirmation field in the request
            'confirmed_password' => 'nullable|min:6', // No confirmation validation here, since it's already handled in nominated_password
            'role_id' => 'required|exists:roles,id',
        ]);
    
        if ($validatedData['nominated_password'] && $validatedData['nominated_password'] !== $validatedData['confirmed_password']) {
            return response()->json(['message' => 'Passwords do not match.'], 400);
        }
    
        $user = User::create([
            'full_name' => $validatedData['full_name'],
            'email' => $validatedData['email'],
            'nominated_password' => Hash::make($validatedData['nominated_password']),
            'confirmed_password' => Hash::make($validatedData['confirmed_password']), // You may not need this field at all depending on your use case
            'role_id' => $validatedData['role_id'],
        ]);
    
        return response()->json([
            'message' => 'User successfully updated.',
            'user' => $user,
        ], 201);
    }
    
    public function show($id)
    {
        $user = User::with('role')->findOrFail($id);
        $rolesWithoutUsers = Role::doesntHave('users')->get();
        $rolesWithoutUsers->push($user->role);
        return response()->json([
            'user' => $user,
            'roles_without_users' => $rolesWithoutUsers
        ]);
    }    
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'full_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id),
            ],
            'nominated_password' => 'nullable|min:6|confirmed',
            'confirmed_password' => 'nullable|min:6',
            'role_id' => 'required|exists:roles,id',
        ], [
            'full_name.unique' => 'The full name has already been taken.',
            'email.unique' => 'The email has already been taken.',
        ]);
        $user = User::findOrFail($id);
        $user->update([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'nominated_password' => isset($validated['nominated_password']) ? Hash::make($validated['nominated_password']) : $user->nominated_password,
            'confirmed_password' => isset($validated['confirmed_password']) ? Hash::make($validated['confirmed_password']) : $user->confirmed_password,
            'role_id' => $validated['role_id'],
        ]);
        return response()->json([
            'message' => 'User successfully updated.',
            'user' => $user,
        ], 200);
    }
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json([
                'message' => 'User successfully deleted.'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while deleting the user.'
            ], 500);
        }
    }
    
    public function roleData()
    {
        // Fetch roles that do not have any associated users (no role_id in users table)
        $roleData = Role::doesntHave('users')->get();

        return response()->json($roleData);
    }
}
