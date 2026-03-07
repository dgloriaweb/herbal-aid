<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function get_menu_items()
    {
        $menu_items = \App\Models\MenuItem::with(['parent', 'roles'])->orderBy('order')->get();
        return response()->json($menu_items);
    }

    public function get_menu_permissions()
    {
        $permissions = DB::table('menu_item_role')
            ->select('menu_item_id', 'role_id')
            ->get();
        return response()->json($permissions);
    }

    public function save_menu_permissions(Request $request)
    {
        try {
            $permissions = $request->permissions;
            
            \Log::info('Received permissions:', ['permissions' => $permissions]);
            
            DB::table('menu_item_role')->truncate();
            
            if (!empty($permissions)) {
                foreach ($permissions as $permission) {
                    DB::table('menu_item_role')->insert([
                        'menu_item_id' => $permission['menu_item_id'],
                        'role_id' => $permission['role_id'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
            
            \Log::info('Permissions saved successfully');
            return back()->with('success', 'Permissions saved successfully');
        } catch (\Exception $e) {
            \Log::error('Error saving permissions:', ['error' => $e->getMessage()]);
            return back()->with('error', 'Failed to save permissions: ' . $e->getMessage());
        }
    }
}
