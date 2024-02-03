<?php

namespace App\Http\Controllers;

use App\Http\Requests\ListUserRequest;
use App\Services\Interfaces\UsersServiceInterface;
use Exception;

class UserController extends BaseController
{
    protected  UsersServiceInterface $productService;

    public function __construct(UsersServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function list(ListUserRequest $request)
    {
        $options = $request->validated();
        try {
            return $this->ok($this->productService->list($options));
        } catch (Exception $e) {
            return $this->errorResponse(500, $e->getMessage());
        }
    }
}
