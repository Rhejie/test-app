<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserServices {

    public function getUsers() {

        $users = UserResource::collection(User::with('role')->get());

        return $users;
    }

    public function storeUser($request) {

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->password = Hash::make($request->password);

        if($user->save()) {
            return $user->role();
        }


    }

    public function updateUser($request, $id) {
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->password = Hash::make($request->password);

        if($user->save()) {
            return $user->role();
        }
    }

    public function getUserById($id) {

        $user = User::with('role')->find($id);
        return $user;

    }
}