<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Resources\RoleResource;
use App\Http\Resources\RoleCollection;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rolesWithPermissions = Role::with('permissions')->get();
        return new RoleCollection($rolesWithPermissions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'permissions' => 'nullable|array|required',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $permissions = $request->input('permissions', []);
        $role = Role::create(['name' => $request->name]);

        $role->givePermissionTo($permissions);

        return response()->json([
            'message' => "role created successfully"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $roleWithPermissions = Role::with('permissions')->where('id', $id)->first();
        if($roleWithPermissions){
                return new RoleResource($roleWithPermissions);


        }else{
            return response()->json([
                'error' => 'nothing'
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>'required',
            'permissions' => 'nullable|array|required',
            'permissions.*' => 'exists:permissions,name',
        ]);

        $permissions = $request->input('permissions', []);
        $role = Role::where('id', $id)->first();

        try{
            $role->name = $request->name;
            $role->save();
            $role->syncPermissions($permissions);

            return response()->json(['message' => "role updated successfully"]);

        }catch(\Exception $e){

            return response()->json(['message',$e->getMessage()]);

        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::where('id', $id)->first();
        $deletion = $role->delete();

        if($deletion){
            return response()->json(['message' => "role deleted successfully"]);
        }
    }

    public function switchRole(Request $request, $user_id)
    {
        $request->validate([
            'role'=>'required|exists:roles,name',
        ]);
        
        try{
            $user  = User::with('roles')->findOrFail($user_id);
            $user->syncRoles($request->role);

            return  response()->json([
                'success'=>'User Role updated successfully']
            );
        }catch(\Exception $e){
            return response()->json(['message',$e->getMessage()]);
        }

    }
}
