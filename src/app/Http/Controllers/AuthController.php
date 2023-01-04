<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(
        private AuthService $authService
    ) {
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function login(Request $request): JsonResponse
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $auth = $this->authService->login($email, $password);

        if (empty($auth)) {
            return $this->responseNotFound();
        }

        return $this->responseSuccess($auth);
    }


    /**
     * @throws \Throwable
     */
    public function logout(Request $request): JsonResponse
    {
        $userAuth = $request->user();

        $response = $this->authService->logout($userAuth);

        if (!$response) {
            return $this->responseError('Error when realized logout');
        }

        return $this->responseNoContent(message: 'Logout with success!');
    }
}
