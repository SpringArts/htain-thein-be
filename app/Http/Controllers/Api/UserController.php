<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\App\User\FetchUserRequest;
use App\Http\Requests\V1\App\User\StoreUserRequest;
use App\Http\Requests\V1\App\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\UseCases\UserAction\UserAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    private UserAction $userAction;

    public function __construct(UserAction $userAction)
    {
        $this->userAction = $userAction;
    }

    public function index(FetchUserRequest $request): JsonResponse
    {
        $validatedData = $request->safe()->all();
        $data = $this->userAction->fetchUsers($validatedData);
        $meta = ResponseHelper::getPaginationMeta($data);

        return response()->json([
            'data' => UserResource::collection($data),
            'meta' => $meta,
        ]);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        Gate::authorize('adminPermission');
        $formData = $request->safe()->all();
        $this->userAction->createUser($formData);

        return ResponseHelper::success('Successfully created', null, 201);
    }

    public function show(User $user): JsonResponse
    {
        return response()->json([
            'data' => new UserResource($user),
        ]);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        Gate::authorize('adminPermission');
        $this->userAction->updateUser($request->safe()->all(), $user);

        return ResponseHelper::success('Successfully Updated', null, 200);
    }

    public function destroy(User $user): JsonResponse
    {
        Gate::authorize('superAdminPermission');
        $this->userAction->deleteUser($user);

        return ResponseHelper::success('Successfully Deleted', null, 200);
    }

    public function saveLocation(Request $request): int
    {
        $saveLocation = $this->userAction->saveLocation($request);

        return 200;
    }
}
