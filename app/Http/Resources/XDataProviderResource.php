<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class XDataProviderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array|Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "provider" => 'X_DATA_PROVIDER',
            "id" => $this->parentIdentification,
            "email" => $this->parentEmail,
            "status" => $this->statusCode,
            "created_at" => $this->registerationDate,
            "currency" => $this->Currency,
            "balance" => $this->parentAmount,
        ];
    }
}

