<?php

namespace App\Repositories;

use App\Repositories\contracts\CurdContracts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use App\Models\Product;
use Exception;


class ProductRepositories implements CurdContracts
{

    public function all()
    {
        try {                
                $perPage = request()->get('per_page', 10);
                return Product::paginate($perPage);
            } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function getSingleRecord($id)
    {
        try {
            return  Product::find($id);
            } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function store($data)
    {
        try {
                return Product::create($data);
            } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function update(array $data, $id)
    {
        try {

            return Product::updateOrCreate(['id' => $id], 
                [
                    'name' => $data['name'] ?? $data->name,
                    'description' => $data['description'] ?? $data->description,
                    'price'=>$data['price'] ?? $data->price,
                    'quantity'=>$data['quantity'] ?? $data->quantity
                ]);
                
            } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function destroy($id)
    {
        try {
                $product= Product::find($id);
                if($product){
                    return Product::destroy($id);
                }
                return $product;
            } catch (Exception $exception) {
            throw $exception;
        }
    }

}

