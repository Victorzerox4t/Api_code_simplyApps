<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\UserLoginRequest;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $data = $request->validated();

        if (User::where('username', $data['username'])->exists()) {
            throw new HttpResponseException(response([
                'errors' => [
                    'username' => ['Username already exists.']
                ]
            ], 400));
        }


        $user = new User($data);
        $user->password = Hash::make($data['password']);
        $user->save();
        return (new UserResource($user))->response()->setStatusCode(201);
    }


    public function login(UserLoginRequest $request)
    {
        $data = $request->validated();  // Data sudah divalidasi
        $user = User::where('username', $data['username'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json([
                'errors' => [
                    'username' =>
                        ['Username or password is wrong'],
                ]
            ], 401);
        }

        $user->token = Str::uuid()->toString();
        $user->save();

        return new UserResource($user);
    }


    public function get(Request $request) : UserResource
    {
        $user = Auth::user();
        return new UserResource($user);
    }

    public function update(UserUpdateRequest $request) : UserResource
    {
        $data = $request->validated();
        $user = Auth::user();

        if(isset($data['name'])){
            $user->name = $data['name'];
        }
        if(isset($data['password'])){
            $user->password = Hash::make($data['password']);
        }
        $user->save();
        return new UserResource($user);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->token = null;
        $user->save();

        return response()->json([
            'data' => true
        ], 200);
    }
}
