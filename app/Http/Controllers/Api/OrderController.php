<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\PlaceOrderRequest;
use App\Repositories\OrderRepositories;
use App\Http\Resources\OrderResource;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrdersRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;



class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private OrderRepositories $orderRepo;


    public function __construct(OrderRepositories $orderRepo){

        $this->orderRepo = $orderRepo;

    }

    public function index()
    {
        
        try {
            $orders = $this->orderRepo->all();
            return apiResponse(JsonResponse::HTTP_OK, true,'data',new OrderResource($orders));
        } catch (Exception $exception) {
            return apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, false,'message', $exception->getMessage());
        }

    }

    public function store(OrdersRequest $request)
    {
        try {
            $data = $this->orderRepo->store($request->all(),$request);
            if ($data) {
                return apiResponse(JsonResponse::HTTP_OK, true,'data','Order Created Successfully');
            }
            return apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, false,'data','Insufficient quantity');
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {  
            $order=$this->orderRepo->getSingleRecord($id);
            if (empty($order)) {
                return apiResponse(JsonResponse::HTTP_OK, false,'data','Record does not exist');
            }             
            return apiResponse(JsonResponse::HTTP_OK, true,'data',$order);
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $result = $this->orderRepo->destroy($id);
            if (!empty($result)) {
                return apiResponse(JsonResponse::HTTP_OK, true,'data','Deleted Successfully');
            }else{
                return apiResponse(JsonResponse::HTTP_OK, false,'data','Record does not exist');
            }
        }catch(Exception $e){
            return $e->getMessage();
        }
    }
}
