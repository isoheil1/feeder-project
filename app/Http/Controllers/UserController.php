<?php

namespace App\Http\Controllers;

use App\Contracts\UserRepositoryInterface;
use App\Helpers\ResponseHelper;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use Arr;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{

    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Login user
     * 
     * @param \App\Http\Requests\LoginUserRequest $request
     * @return \Illuminate\Http\JsonResponse 
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        if (\Auth::attempt($request->only(['email', 'password'])) == false) {
            return ResponseHelper::fail(
                Response::HTTP_UNAUTHORIZED,
                [],
                trans('auth.failed')
            );
        }

        return ResponseHelper::success(
            Response::HTTP_OK,
            [
                'token' => $this->repository->findUser($request->input('email'))
                    ->createToken('api')->plainTextToken
            ]
        );
    }

    /**
     * Register user via email and password
     * 
     * @param \App\Http\Requests\RegisterUserRequest $request
     * @return \Illuminate\Http\JsonResponse 
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $user = $this->repository->create($request->validated());

        return ResponseHelper::success(
            Response::HTTP_OK,
            [
                'name' => $user['name'],
                'email' => $user['email'],
                'token' => $user->createToken('api')->plainTextToken
            ],
        );
    }
}
