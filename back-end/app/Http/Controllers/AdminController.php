<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use App\Http\Requests\RoleRequest;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function roles() {
        $roles = Role::all();
        return response()->json([
            "status" => "success",
            "data" => RoleResource::collection($roles)
        ]);
    }

    public function addRole(RoleRequest $request) {
        $role = $request->name;
        Role::create($request->only('name'));
        return response()->json([
            'status' => 'success',
            'message' => "Role '{$role}' created successfully"
        ], 201);
    }

    public function updateRole(RoleRequest $request, $id) {
        $role = Role::findOrFail($id);
        $name= $role->name;
        $role->update($request->only('name'));
        return response()->json([
            'status' => 'success',
            'message' => "Role '{$name}' updated successfully to '{$request->name}'"
        ], 202);
    }

    public function deleteRole($id) {
        $role = Role::findOrFail($id);
        if($role->name == 'owner' || $role->name == 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => "Role '{$role->name}' cannot be deleted"
            ], 403);
        }
        $role->delete();
        return response()->json([
            'status' => 'success',
            'message' => "Role '{$role->name}' deleted successfully"
        ]);
    }

    public function permissions() {
        $permissions = Permission::all();
        return response()->json([
            "status" => "success",
            "data" => PermissionResource::collection($permissions)
        ]);
    }

    public function addPermission(PermissionRequest $request) {
        Permission::create($request->only('name'));
        return response()->json([
            "status" => "success",
            "message" => "permission '{$request->name}' created successfully"
        ], 201);
    }

    public function updatePermission(PermissionRequest $request, $id) {
        $permission = Permission::findOrFail($id);
        $name = $permission->name;
        $permission->update($request->only('name'));
        return response()->json([
            'status' => 'success',
            'message' => "Permission '{$name}' updated successfully to '{$request->name}'"
        ], 202);
    }

    public function deletePermission($id) {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return response()->json([
            "status" => "success",
            "message" => "Permission '{$permission->name}' deleted successfully"
        ]);
    }
}
