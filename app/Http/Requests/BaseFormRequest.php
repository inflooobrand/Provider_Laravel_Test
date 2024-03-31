<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;


class BaseFormRequest  extends FormRequest
{

	public function failedValidation(Validator $validator)
    {
        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'status_code'   => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'success'   => false,
                'message'   => $this->validationErrorsToString($validator->errors()),
                //'data'      => null
            ]));
        }
    }

    public function response(array $errors)
    {

        if ($this->expectsJson()) {
            return apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY,false, 'message', $errors,null);
        }
    }

    /**
     *
     * @param $errArray
     * @return string
     */
    public function validationErrorsToString($errArray) {
        $valArr = array();
        foreach ($errArray->toArray() as $key => $value) {
            $errStr = $value[0];
            array_push($valArr, $errStr);
        }
        if(!empty($valArr)){
            $errStrFinal = implode(',', $valArr);
        }
        return $errStrFinal;
    }
}