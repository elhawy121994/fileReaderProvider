<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class YDataProviderResource extends JsonResource
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
            "provider" => 'Y_DATA_PROVIDER',
            "id" => $this->id,
            "email" => $this->email,
            "status" => $this->status,
            "created_at" => (DateTime::createFromFormat('j/n/Y', $this->created_at))->format('Y-m-d'),
            "currency" => $this->currency,
            "balance" => $this->balance,
        ];
    }
}
