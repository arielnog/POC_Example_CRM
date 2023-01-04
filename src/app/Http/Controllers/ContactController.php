<?php

namespace App\Http\Controllers;

use App\Services\ContactService;
use App\ValueObjects\ContactPipeline;
use App\ValueObjects\Uuid;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __construct(
        public ContactService $contactService
    )
    {
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function list(Request $request): JsonResponse
    {
        $contacts = $this->contactService->list();

        if ($contacts->isEmpty()) {
            return $this->responseNotFound();
        }

        return $this->responseWithArray($contacts->toArray());
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function getById(Request $request): JsonResponse
    {
        $contactId = Uuid::fromString(
            $request->route('contactId')
        );

        $user = $this->contactService->getById(
            contactId: $contactId
        );

        if (empty($user)) {
            return $this->responseNotFound();
        }

        return $this->responseSuccess($user->toArray());
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function store(Request $request): JsonResponse
    {
        $params = $request->all();

        $response = $this->contactService->store(
            $params
        );

        return $this->responseCreated($response);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\InvalidArgumentException
     * @throws \Throwable
     */
    public function update(Request $request): JsonResponse
    {
        $contactId = Uuid::fromString(
            $request->route('contactId')
        );

        $params = $request->all();

        $response = $this->contactService->update($contactId, $params);

        if (!$response){
            return $this->responseError(message: "update error");
        }

        return $this->responseNoContent();
    }

    public function updatePipeline(Request $request): JsonResponse
    {
        $contactId = Uuid::fromString(
            $request->route('contactId')
        );

        $pipeline = ContactPipeline::fromString($request->input('pipeline'));

        $response = $this->contactService->changePipeline($contactId, $pipeline);

        if (!$response){
            return $this->responseError(message: "update error");
        }

        return $this->responseNoContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\InvalidArgumentException
     * @throws \Throwable
     */
    public function delete(Request $request): JsonResponse
    {
        $contactId = Uuid::fromString(
            $request->route('contactId')
        );

        $response = $this->contactService->delete($contactId);

        if (!$response){
            return $this->responseError(message: "delete error");
        }

        return $this->responseNoContent();
    }
}
