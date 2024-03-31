<?php

namespace App\Repositories;

use App\Repositories\contracts\CurdContracts;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Services\PaymentService;
use App\Models\Product;
use App\Models\Order;
use App\Models\Payment;
use Exception;

class OrderRepositories implements CurdContracts
{

    
    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;

    }

    public function all()
    {
        try {
                $perPage = request()->get('per_page', 10);
                return  Order::with('product', 'payment')->paginate($perPage);

            } catch(Exception $e){
                return $e->getMessage();
        }
    }

  public function store($data)
  {
        try {
            DB::beginTransaction();
                // Fetch the product
                $product = Product::findOrFail($data['product_id']);
                // Check if product quantity is sufficient
                if ($product['quantity'] <= 0 ) {
                    return false;
                }
                // Calculate total price
                $totalPrice = $product['price'] * $data['quantity'];
                $productQuantity = $product['quantity'] - $data['quantity'];
                    Product::where('id',$data['product_id'])
                            ->update(['quantity' => $productQuantity]);
                // Create the order
                $orderId = Order::insertGetId([
                    'product_id' => $product['id'],
                    'quantity' => $data['quantity'],
                    'total_price' => $totalPrice,
                    'customer_name' => $product['customer_name'],
                ]);
                if ($orderId) {                    
                        $payment = $this->paymentService->processPayment();
                        $status='failed';
                        if ($payment) {
                            $status='completed';
                        }
                        $paymentId = Payment::insertGetId([
                            'order_id' => $orderId,
                            'status' => $status,
                        ]);
                    Order::where('id',$orderId)->update(['payment_id' => $paymentId]);
                }
            DB::commit();
            return true;

        }catch(Exception $e){
            DB::rollback();
            return $e->getMessage();
    }

  }

    public function getSingleRecord($id)
    {
        try {
            return  Order::with('product', 'payment')->find($id);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

  public function update(array $data, $id)
  {

  }

  public function destroy($id)
  {
    try {
            $order= Order::find($id);
            if($order){
                return Order::destroy($id);
            }
            return $order;
    } catch (Exception $exception) {
        throw $exception;
    }
  }
}

