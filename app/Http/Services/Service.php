<?php

namespace App\Http\Services;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class Service
{
  protected static string $model;
  protected static string $DTO;

  protected static function getModel(): Model
  {
    return app(static::$model);
  }

  public static function dataFromRequest(Request $request) {
    return static::$DTO::arrayFromRequest($request);
  }

  public static function getAll() {
    return static::getModel()::all();
  }

  public static function getById($id) {
    return static::getModel()::find($id);
  }

  public static function create(Request $request) {
    $data = static::dataFromRequest($request);
    return static::getModel()::create($data);
  }

  public static function update(Model $targetModel,Request $request) {
    $data = static::dataFromRequest($request);
    return $targetModel->update($data);
  }

  public static function delete(Model $targetModel) {
    return $targetModel->delete();
  }
}