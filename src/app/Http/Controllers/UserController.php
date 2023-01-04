<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\ValueObjects\Uuid;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UserController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {
    }

    /**
     * @throws \Throwable
     */
    public function list(Request $request): JsonResponse
    {
       $users = $this->userService->list();

        if ($users->isEmpty()) {
            return $this->responseNotFound();
        }

        return $this->responseWithArray($users->toArray());
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function getById(Request $request): JsonResponse
    {
        $userUuid = Uuid::fromString(
            $request->route('userId')
        );

        $user = $this->userService->getById(
            userId: $userUuid
        );

        if (empty($user)) {
            return $this->responseNotFound();
        }

        return $this->responseSuccess($user->toArray());
    }

    /**
     * @throws Exception|\Throwable
     */
    public function store(Request $request): JsonResponse
    {
        $params = $request->all();

        $response = $this->userService->save(
            $params
        );

        return $this->responseCreated($response);
    }

    /**
     * @throws Exception|Throwable|
     */
    public function update(Request $request): JsonResponse
    {
        $userId = Uuid::fromString(
            $request->route('userId')
        );

        $params = $request->all();

        $response = $this->userService->update($userId, $params);

        if (!$response){
            return $this->responseError(message: "update error");
        }

        return $this->responseNoContent();
    }

    public function delete(Request $request): JsonResponse
    {
        $userId = Uuid::fromString(
            $request->route('userId')
        );

        $response = $this->userService->delete($userId);

        if (!$response){
            return $this->responseError(message: "delete error");
        }

        return $this->responseNoContent();
    }
}
