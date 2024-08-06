<?php

namespace App\Http\Controllers;

use App\Http\DTOs\UserDTO;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Responses\Response;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Returns all users
     */
    public function index(): JsonResponse
    {
        $users = User::all();
        return Response::success($users);
    }

    /**
     * Returns a single User
     */
    public function show(User $user): JsonResponse
    {
        return Response::success($user);
    }

    /**
     * Creates a user and saves it to the database
     */
    public function store(UserCreateRequest $request): JsonResponse
    {
        $userDTO = UserDTO::fromRequest($request);
        $user = User::create($userDTO->toArray());
        return Response::success($user, 201);
    }

    /**
     * Update a user and saves it to the database
     */
    public function update(UserUpdateRequest $request, User $user): JsonResponse
    {
        $userDTO = UserDTO::fromRequest($request);
        $user->update($userDTO->toArray());
        return Response::success($user);
    }
    
    /**
     * Deletes a user from the database
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return Response::success(null, 204);
    }
}
