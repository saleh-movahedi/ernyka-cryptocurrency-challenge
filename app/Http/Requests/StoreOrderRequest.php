<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'exchangeable_id' => 'required|exists:ratios,id',
            'tradable_ratio' => 'required|numeric',
            'amount' => 'required|numeric|min:0',
            'order_type' => 'in:sell,buy',

        ];
    }
}
