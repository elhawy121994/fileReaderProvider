<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'statusCode' => ['string', 'sometimes', Rule::in(['authorised','decline','refunded'])],
            'provider' => ['sometimes', 'string', Rule::in(['DataProviderX', 'DataProviderY'])],
            'currency' => ['sometimes', 'string', 'max:4', 'min:2'],
            'balanceMin' => ['sometimes', 'numeric'],
            'balanceMax' => ['sometimes', 'numeric'],
        ];
    }
}
