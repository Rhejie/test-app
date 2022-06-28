<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Http\Resources\RoleResource;
use App\Models\Role;
use App\Services\RoleServices;
use Illuminate\Http\Request;
use LDAP\Result;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(RoleServices $roleServices)
    {   
        return response()->json($roleServices->getRoles());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request, RoleServices $roleServices)
    {
        $role = $roleServices->storeRole($request);

        return response()->json($role);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, RoleServices $roleServices)
    {   
        $role = $roleServices->getRoleById($id);

        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id, RoleServices $roleServices)
    {
        $role = $roleServices->updateRole($request, $id);

        return response()->json($role);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if($role->delete()) {
            return response()->json([
                'message' => 'Role deleted successfully',
                'status_code' => 200,
            ], 200);
        }
        else {
            return response()->json([
                'message' => 'Some error occurred',
                'status_code' => 500
            ], 500);
        }
    }
}
