<?php

namespace App\Http\Controllers;
use App\Http\DTOs\AuthDTO;
use App\Http\DTOs\UserDTO;
use App\Http\Requests\Auth\AuthLoginRequest;
use App\Http\Requests\Auth\AuthRegisterRequest;
use App\Http\Responses\Response;
use App\Models\User;

class AuthController extends Controller
{
  public function register(AuthRegisterRequest $request) {
    $userDTO = UserDTO::fromRequest($request);
    $user = User::create($userDTO->toArray());
    return Response::success($user, 201);
  }

  public function login(AuthLoginRequest $request)
  {
    $authDTO = AuthDTO::fromRequest($request);

    if(!auth()->attempt($authDTO->toArray())){
      $data = (object) ['error' => 'Invalid credentials'];
      return Response::error($data, 422);
    }

    $user = User::where('email', $authDTO->email)->first();

    $authToken = $user->createToken('authToken')->plainTextToken;

    return Response::success((object) [
      'user' => $user,
      'access_token' => $authToken,
      'token_type' => 'bearer'
    ]);
  }

  public function logout() {
    auth()->user()->tokens()->delete();
    return Response::success((object) null, 204);
  }
}