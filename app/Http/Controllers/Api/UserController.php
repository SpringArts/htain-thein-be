<?php

namespace App\Http\Controllers\Api;

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
        return $this->userAction->fetchUsers($validatedData);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        Gate::authorize('adminPermission');
        $formData = $request->safe()->all();
        return $this->userAction->createUser($formData);
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
        return $this->userAction->updateUser($request->safe()->all(), $user);
    }

    public function destroy(User $user): JsonResponse
    {
        Gate::authorize('superAdminPermission');
        return $this->userAction->deleteUser($user);
    }

    public function saveLocation(Request $request): int
    {
        $saveLocation = $this->userAction->saveLocation($request);

        return 200;
    }
}
