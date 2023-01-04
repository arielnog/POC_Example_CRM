<?php

namespace App\Services;

use App\Exceptions\AuthException;
use App\Factories\Entities\UserFactory;
use Exception;
use Illuminate\Support\Facades\Auth;
use Throwable;

class AuthService
{
    /**
     * @param string $email
     * @param string $password
     * @return array
     * @throws Exception
     */
    public function login(string $email, string $password): array
    {
        try {
            $user = Auth::attempt(
                [
                    'email' => $email,
                    'password' => $password,
                ]
            );

            if (!$user) {
                throw new AuthException(
                    message: 'Error when Auth',
                    code: 403
                );
            }

            return $this->prepareResponseWithToken();
        } catch (Throwable $e) {
            throw $e;
        }
    }

    /**
     * @param $userAuth
     * @return bool
     * @throws \Throwable
     */
    public function logout($userAuth): bool
    {
        try {
            $userAuth->tokens()->delete();

            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * @return array
     * @throws \Exception
     */
    private function prepareResponseWithToken(): array
    {
        $user = Auth::user();
        $userEntity = UserFactory::fromModel($user);

        return [
            'token' => $user->createToken('auth_token')->plainTextToken,
            'token_type' => 'Bearer',
            'user' => $userEntity->toArray(),
            'expires_in' => config('sanctum.expiration')
        ];
    }
}
