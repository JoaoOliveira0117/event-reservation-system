<?php

namespace App\Http\Services;

use App\Builders\UserBuilder;
use App\Http\DTOs\UserDTO;
use App\Models\User;

class UserService extends Service {
  protected static string $model = User::class;
  protected static string $DTO = UserDTO::class;

  public static function getUser(string $userId) {
    return self::$model::query()
      ->forUser($userId)
      ->withEvents()
      ->withTickets()
      ->firstOrFail();
  }
}