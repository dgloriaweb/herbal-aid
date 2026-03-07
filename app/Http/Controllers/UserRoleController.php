<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function get_users()
    {
        $users = \App\Models\User::with('roles')->get();
        return response()->json($users);
    }

    public function get_roles()
    {
        $roles = \App\Models\Role::all();
        return response()->json($roles);
    }

    public function assign_role(Request $request)
    {
        $user = \App\Models\User::findOrFail($request->user_id);
        $role = \App\Models\Role::findOrFail($request->role_id);
        
        if (!$user->roles->contains($role->id)) {
            $user->roles()->attach($role->id);
            return response()->json(['success' => true, 'message' => 'Role assigned successfully']);
        }
        
        return response()->json(['success' => false, 'message' => 'User already has this role'], 400);
    }
}
