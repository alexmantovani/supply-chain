<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateWarehouseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->hasPermissionTo('edit warehouse');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            // 'name' => 'required|unique:warehouses,name,' . $this->name . ',name',
            'name' => [
                'required',
                Rule::unique('warehouses')->ignore($this->name, 'name'),
            ],
            'description' => [
                'max:255'
            ],
            'email_array.*' => [
                'email:rfc'
            ],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'email_array' => array_map('trim', explode(',', $this->emails)),
        ]);
    }
}
