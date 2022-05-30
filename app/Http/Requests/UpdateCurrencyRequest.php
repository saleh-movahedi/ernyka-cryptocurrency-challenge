<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed $id
 * @property mixed $slug
 * @property mixed $name
 */
class UpdateCurrencyRequest extends FormRequest
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
        return array(
            'name' => "required|unique:currencies,name,{$this->id}|max:20",
            'slug' => "required|unique:currencies,slug,{$this->id}|max:10",
        );
    }
}
