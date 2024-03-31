<?php

namespace App\Services;

use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class PaymentService
{
    public function processPayment()
    {
        try{
        // Simulate payment process - Randomly assign successful or failed payment
        $success = (bool) rand(0, 1);
            if ($success) {
                return true;
            }
            return false;
        } catch (Exception $exception) {
            return apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, false,'message', $exception->getMessage());
        }
    }
}


