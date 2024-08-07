<?php

namespace App\Http\DTOs;
use Illuminate\Http\Request;

abstract class BaseDTO
{
  public function __construct(array $data) {
    throw new \InvalidArgumentException('DTOs must be implemented in child classes');
  }

  public static function fromRequest(Request $request): static {
    return new static($request->all());
  }

  public static function arrayFromRequest(Request $request): array {
    return self::fromRequest($request)->toArray();
  }

  public function toArray(): array {
    return get_object_vars($this);
  }

}