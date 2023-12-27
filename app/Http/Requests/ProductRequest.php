<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        $id = $this->route('product');
        return [
            'name' => 'required|string|min:2|max:25|unique:products,name,' . $id . ',id,deleted_at,NULL',
            'display_name' => 'required|string|min:2|max:30',
            'hsn' => 'required|string|min:4|max:30',
            'price' => 'required|integer|min:1',
        ];
    }
}
