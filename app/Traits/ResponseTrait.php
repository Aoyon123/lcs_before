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
    public function responseSuccess($data, $message = "Successfull"): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
            'errors' => null

        ]);
    }


    /**
     *Error Response
     * @param array|object $errors
     * @param string $message
     * @return JsonResponse
     */
    public function responseError($errors,$message = "Something Went Wrong"): JsonResponse
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => null,
            'errors' => $errors

        ]);
    }
}
