<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Responses\Response;
use App\Http\Services\UserService;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Returns all users
     */
    public function index(): JsonResponse
    {
        $users = UserService::getAll();
        return Response::success($users);
    }

    /**
     * Returns a single User
     */
    public function show(User $user): JsonResponse
    {
        $result = UserService::getUser($user->id);
        return Response::success($result);
    }

    /**
     * Creates a user and saves it to the database
     */
    public function store(UserCreateRequest $request): JsonResponse
    {   
        $user = UserService::create($request);
        return Response::success($user, 201);
    }

    /**
     * Update a user and saves it to the database
     */
    public function update(UserUpdateRequest $request, User $user): JsonResponse
    {
        if (!Gate::allows('manage-user', $user)) {
            return Response::error((object) ['error' => 'Unauthorized.'], 403);
        }

        UserService::update($user, $request);
        return Response::success($user);
    }
    
    /**
     * Deletes a user from the database
     */
    public function destroy(User $user): JsonResponse
    {

        UserService::delete($user);
        return Response::success((object) null, 204);
    }
}
