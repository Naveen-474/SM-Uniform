<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CustomerRequest extends FormRequest
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
    public function rules(Request $request): array
    {
        $id = $this->route('customer_detail');
        return [
            'name' => 'required|string|min:2|max:25',
            'address' => 'required|string|min:2|max:100',
            'pin_code' => 'required|string|min:1|max:6',
            'mobile_number' => 'nullable|integer|digits:10|unique:customers,mobile_number,' . $id . ',id,deleted_at,NULL',
            'gstin' => 'required|min:1|unique:customers,gstin,' . $id . ',id,deleted_at,NULL',
        ];
    }
}
