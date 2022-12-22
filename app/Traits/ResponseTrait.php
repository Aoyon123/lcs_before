<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait
{

    /**
     *
     * @param array|object $data
     * @param string $message
     * @return JsonResponse
     */
    public function responseSuccess($status, $message = "Successfull", $data): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ]);
    }


    /**
     *Error Response
     * @param array|object $errors
     * @param string $message
     * @return JsonResponse
     */
    public function responseError($status, $message = "Something Went Wrong"): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,

        ]);
    }

    public function responseDone($status,$message): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
        ]);
    }
}
