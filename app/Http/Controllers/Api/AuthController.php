<?php

namespace App\Http\Controllers\Api;

use App\Services\UserServiceInterface;
use App\Http\Requests\Api\LoginUser;
use App\Http\Requests\Api\RegisterUser;
use App\RealWorld\Transformers\UserTransformer;
use Tymon\JWTAuth\Contracts\Providers\Auth;

class AuthController extends ApiController
{
    private $userService;

    /**
     * AuthController constructor.
     *
     * @param UserTransformer $transformer
     */
    public function __construct(UserTransformer $transformer,
                                UserServiceInterface $userService)
    {
        $this->transformer = $transformer;
        $this->userService = $userService;
    }

    /**
     * Login user and return the user if successful.
     *
     * @param LoginUser $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginUser $request)
    {
        $credentials = $request->only('user.email', 'user.password');
        $credentials = $credentials['user'];

        if (! Auth::once($credentials)) {
            return $this->respondFailedLogin();
        }

        return $this->respondWithTransformer(auth()->user());
    }

    /**
     * Register a new user and return the user if successful.
     *
     * @param RegisterUser $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterUser $request)
    {
        $user = $this->userService->registerUser($request);

        return $this->respondWithTransformer($user);
    }
}
