<?php

namespace App\Http\Requests;

use App\Enums\KeyTypeEnum;
use Illuminate\Validation\Rule;

class StoreTransactionRequest extends FormRequest
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
            'key_type' => [
                'required',
                Rule::in([KeyTypeEnum::DOC, KeyTypeEnum::EMAIL, KeyTypeEnum::PHONE])
            ],
            'key_code' => 'required',
            'total' => 'required|integer',
        ];
    }

}
