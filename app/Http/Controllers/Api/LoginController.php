<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Responses\TokenResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'       => ['required', 'email'],
            'password'    => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status-code' => 400,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return  response()->json([
                'status-code' => 401,
                'message' => 'El usuario y/o contraseña son incorrectos'
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        $user->tokens()->delete();

        return new TokenResponse($user);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status-code' => 200,
            'message'     => 'Token deleted successfully',
        ]);
    }

    public function validateToken(Request $request)
    {
        $user = User::where('email', $request->user()->email)->first();
        $user->tokens()->delete();

        return new TokenResponse($user);
    }
}
