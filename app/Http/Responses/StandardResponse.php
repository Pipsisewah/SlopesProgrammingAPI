<?php


namespace App\Http\Responses;


use Illuminate\Http\JsonResponse;

trait StandardResponse
{

    public static function getStandardResponse(String $statusCode, String $message, Array $data = null): JsonResponse{
        $data['message'] = $message;
        return new JsonResponse($data, $statusCode);
    }
}
