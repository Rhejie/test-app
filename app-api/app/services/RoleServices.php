<?php

namespace App\Services;

use App\Http\Resources\RoleResource;
use App\Models\Role;

class RoleServices {

    public function getRoles() {

        $roles = Role::get();
        return RoleResource::collection($roles);
        
    }

    public function storeRole($request) {
        $role = new Role();
        $role->name = $request->name;
        $role->description = $request->description;
        if($role->save()) {
            return $role;
        }

    }

    public function getRoleById($id) {
        $role = Role::find($id);
        return $role;
    }

    public function updateRole($request, $id) {

        $role = Role::find($id);
        $role->name = $request->name;
        $role->description = $request->description;
        if($role->save()) {
            return $role;
        }

    }

}