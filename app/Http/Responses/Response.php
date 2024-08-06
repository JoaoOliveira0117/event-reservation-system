<?php

namespace App\Http\Responses;

class Response {

  /**
   * Builds API response
   * 
   * @param ?object $data Object containing the response data
   * @param int $status Status code returned
   * @return \Illuminate\Http\JsonResponse
   */
  private static function build(object $data, int $status) {
    return response()->json([
      'data' => $data,
      'success' => $status >= 200 && $status < 300,
    ], $status);
  }

  /**
   * Renders error response with 400 Status Code as default;
   * 
   * @param object $data Object containing the response data
   * @param int $status Status code returned
   * @return \Illuminate\Http\JsonResponse
   */
  public static function error($data, int $status = 400) {
    return self::build($data, $status);
  }

  /**
   * Renders success response with 200 Status Code as default;
   * 
   * @param ?object $data Optional object containing the response data
   * @param int $status Status code returned
   * @return \Illuminate\Http\JsonResponse
   */
  public static function success($data, int $status = 200) {
    return self::build($data, $status);
  }
}