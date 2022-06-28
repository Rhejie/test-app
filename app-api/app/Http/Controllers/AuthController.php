<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Services\UserServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(UserRequest $request) {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->password = Hash::make($request->password);

        if($user->save()) {
            return response()->json([
                "message" => "User created successfully",
                "status_code" => 201
            ], 201);
        }
        else {
            return response()->json([
                "message" => "Some error occurred",
                "status_code" => 500
            ], 500);
        }
    }

    public function login(LoginRequest $request) {
        if(!Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            return response()->json([
                'message' => 'Invalide Email/Password',
                'status_code' => 401,
            ], 401);
        }

        $user = $request->user();
        if(strtolower($user->role->name) === 'admin') {
            $tokenData = $user->createToken('Personal Access Token', ['do_anything']);
        } else {
            $tokenData = $user->createToken('Personal Access Token', ['can_create']);
        }

        $token = $tokenData->token;

        if($request->remeber_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }

        if($token->save()) {
            return response()->json([
                'user' => $user,
                "access_token" => $tokenData->accessToken,
                "token_type" => "Bearer",
                "token_scope" => $tokenData->token->scopes[0],
                "expires_at" => Carbon::parse($tokenData->token->expires_at)->toDateTimeLocalString(),
                'status_code' => 200
            ], 200);
        }
        else {
            return response()->json([
                'message' => 'Some error occurred',
                'status_code' => 500,
            ], 500);
        }
        
    }

    public function logout(Request $request) {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Logout Successfully',
            'status_code' => 200,
        ], 200);
    }

    public function profile(Request $request, UserServices $userServices) {
        if($request->user()){
            $user = $userServices->getUserById($request->user()->id);
            return response()->json($user, 200);
        }

        return response()->json([
            'message' => 'Not Logged In',
            'status_code' => 500
        ], 500);
    }
}
