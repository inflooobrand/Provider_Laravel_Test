<?php

use App\Models\User;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

function apiResponse($status_code, $success, $key, $value, $meta = '')
{
    $response = [];
    $response['status_code'] = $status_code;
    $response['success'] = $success;
    if ($status_code == 422 && gettype($value) == 'object' && get_class($value) == 'Illuminate\Support\MessageBag') {
        $errors = [];
        foreach ($value->toArray() as $attr => $value_errors) {
            $errors[$attr] = $value_errors[0];
        }
        $response['errors'] = $errors;
    } else {
        $response[$key] = $value;
    }
    if (!empty($meta)) {
        $response = array_merge($response, $meta);
    }
    return response()->json($response)->setStatusCode($status_code);
}


















