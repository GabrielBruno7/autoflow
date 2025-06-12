<?php

namespace App\Http\Controllers;

use App\Domain\User\User;
use App\Infra\UserDb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User as AuthUser;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function actionRegister(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
            ]);

            $user = AuthUser::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'user' => $user,
                'token' => $user->createToken('register')->plainTextToken
            ], 201);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function actionLogin(Request $request)
    {
        try {
            $user = (new User(new UserDb()))
                ->setEmail($request->email)
                ->loadUserByEmail()
                ->checkPassword($request->password)
                ->generateToken()
            ;

            return response()->json(['token' => $user->getToken()], 200);
        } catch (\Throwable $e) {
            Log::error('Erro ao autenticar usuário', ['error' => $e->getMessage()]);
            dd($e);
            return response()->json(['message' => self::DEFAULT_ERROR_MESSAGE], 500);
        }
    }
}