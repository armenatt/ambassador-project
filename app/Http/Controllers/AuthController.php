<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\TokenRepository;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = new User();

        $user->last_name = $request->last_name;
        $user->first_name = $request->first_name;
        $user->email = $request->email;
        $user->is_admin = $request->path() === 'api/admin/register' ? 1 : 0;
        $user->password = Hash::make($request->password);

        $user->save();
        return response([
            'message' => 'user created successfully',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response([
                'error' => 'invalid credentials'
            ], 401);
        }

        $adminLogin = $request->path() === 'api/admin/register' ? 1 : 0;

        if ($adminLogin && !auth()->user()->is_admin) {
            return response([
                'error' => 'Access Denied'
            ], 403);
        }

        $token = \auth()->user()->createToken('auth_token');
        return response([
            'message' => 'logged in successfully',
            'user' => \auth()->user(),
            'token' => $token
        ]);

    }

    public function user(Request $request)
    {
        $user = $request->user();
        return new UserResource($user);
    }

    public function logout()
    {

        $token = Auth::user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

//        $token->revoke();

        return response([
            'message' => 'success',
            'token' => $token
        ]);
    }
}
