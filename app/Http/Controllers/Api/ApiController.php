<?php

namespace App\Http\Controllers\Api;

use App\Repositories\ApiRepositories;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApiRequest;
use App\Http\Requests\ApiLoginRequest;
use App\Http\Resources\ApiResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class ApiController extends Controller
{

    private ApiRepositories $apiRepo;

    public function __construct(ApiRepositories $apiRepo)
    {
        $this->apiRepo = $apiRepo;
    }

    public function register(ApiRequest $request)
    {  
        try {

            $data=$this->apiRepo->store($request->all(),$request);
            return apiResponse(JsonResponse::HTTP_OK, true,'data',new ApiResource($data));
        } catch (Exception $exception) {
            return apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, false,'message', $exception->getMessage());
        }
    }

    public function loginUser(ApiLoginRequest $request)
    {
        try {
            $data=$this->apiRepo->login($request->all());
            if (empty($data)) {
                return apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, false,'messages','Email or Password Invalid');
            }
                return apiResponse(JsonResponse::HTTP_OK, true,'access_token',$data);
            } catch (Exception $exception) {
            return apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, false,'message', $exception->getMessage());
        }
    }

    public function dashboard()
    {
        try {
            $data = $this->apiRepo->get();
            return apiResponse(JsonResponse::HTTP_OK, true,'data','Successfull');

           } catch (Exception $exception) {
            return apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, false,'message', $exception->getMessage());
        }
    }
    public function logout()
    {
        try {
                $data =  $this->apiRepo->destroy();
                if ($data) {
                    return apiResponse(JsonResponse::HTTP_OK, true,'data','logout Successfull');
                }else{
                    return apiResponse(JsonResponse::HTTP_OK, true,'data','Unauthenticated');
                }

            } catch (Exception $exception) {
            return apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, false,'message', $exception->getMessage());
        }
    }
}
