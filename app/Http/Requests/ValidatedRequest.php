<?php

namespace App\Http\Requests;
use App\Http\Responses\Response;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class ValidatedRequest extends FormRequest
{
  public function failedValidation(Validator $validator)
  {
    throw new HttpResponseException(Response::error($validator->errors(), 400));
  }
}