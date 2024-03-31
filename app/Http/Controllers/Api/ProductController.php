<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\ProductRepositories;
use App\Http\Resources\ProductResource;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\ProductUpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Product;
use Exception;



class ProductController extends Controller
{


    private ProductRepositories $productRepo;

    public function __construct(ProductRepositories $productRepo){
        $this->productRepo = $productRepo;
    }

    public function index()
    {
        try {
            $products = $this->productRepo->all();
            return apiResponse(JsonResponse::HTTP_OK, true,'data',new ProductResource($products));
        } catch (Exception $exception) {
            return apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, false,'message', $exception->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(ProductRequest $request)
    {
        try {
            $result = $this->productRepo->store($request->all(),$request);
            return apiResponse(JsonResponse::HTTP_OK, true,'data',new ProductResource($result));
        } catch (Exception $exception) {
            return apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, false,'message', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {            
            $product=$this->productRepo->getSingleRecord($id);
            if (empty($product)) {
                return apiResponse(JsonResponse::HTTP_OK, false,'data','Record does not exist');
            }             
            return apiResponse(JsonResponse::HTTP_OK, true,'data',$product);
        } catch (Exception $exception) {
            return apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, false,'message', $exception->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request,$id)
    {
        try {
            $results=$this->productRepo->update($request->all(),$id);
            return apiResponse(JsonResponse::HTTP_OK, true,'data',new ProductResource($results));
        }
        catch(Exception $e){
            return $e->getMessage();
        } 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $result = $this->productRepo->destroy($id);
            if (!empty($result)) {
                return apiResponse(JsonResponse::HTTP_OK, true,'data','Deleted Successfully');
            }else{
                return apiResponse(JsonResponse::HTTP_OK, false,'data','Record does not exist');
            }
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }
}
