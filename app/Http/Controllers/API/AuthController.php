<?php

namespace App\Http\Controllers\API;

use App\Helper\ResponseDefault;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ResponseDefault;

    public function register(RegisterRequest $request)
    {
        try {
            $input = $request->validated();
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => bcrypt($input['password']),
            ]);

            return $this->setSuccessResponse([
                'user' => $user,
                'token' => $user->createToken('auth_token')->plainTextToken
            ], 201);
        } catch (Exception $e) {
            return $this->setErrorResponse($e->getMessage(), 500);
        }
    }

    public function login(LoginRequest $request)
    {
        $input = $request->validated();

        if (Auth::attempt($input)) {
            return $this->setSuccessResponse([
                'user' => Auth::user(),
                'token' => Auth::user()->createToken('auth_token')->plainTextToken
            ], 200);
        }

        return $this->setErrorResponse('invalid credential', 401);
    }

    public function logout()
    {
        Auth::user()->currentAccessToken()->delete();
        return $this->setSuccessResponse(null, 200);
    }
}
