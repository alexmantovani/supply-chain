<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWarehouseRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:warehouses|max:255',
            'description' => 'max:255',
            'email_array.*' => 'email:rfc',
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

    // public function messages(): array
    // {
    //     return [
    //         'emails.*' => 'Inserisci una o più mail valide separate dal carattere \',\'',
    //     ];
    // }
}
