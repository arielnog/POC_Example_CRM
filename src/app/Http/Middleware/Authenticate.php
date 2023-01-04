<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     * @throws \App\Exceptions\AuthException
     */
    protected function redirectTo($request)
    {
        if ($request->header('Content-Type') == 'application/json') {
            throw new AuthException(
                message: "User not auth",
                code: 403
            );
        }
    }
}
