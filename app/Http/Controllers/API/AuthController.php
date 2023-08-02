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

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

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

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return $this->setErrorResponse('Unauthorized', 401);
        }

        return $this->setSuccessResponse([
            'access_token' => $this->respondWithToken($token)->original['access_token'],
            'user' => auth()->user()
        ], 200);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->setSuccessResponse(auth()->user(), 200);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        
        return $this->setSuccessResponse("Successfully logged out", 200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
