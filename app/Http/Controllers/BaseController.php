<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

abstract class BaseController extends Controller
{
    public function ok($data)
    {
        return response()->json($data, Response::HTTP_OK);
    }

    public function errorResponse($errorCode, $message, $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        $data = array(
            'code' => $errorCode,
            'message' => $message,

        );

        return response()->json($data, $statusCode);
    }
}
