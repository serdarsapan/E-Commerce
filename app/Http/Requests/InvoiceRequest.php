<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'country' => 'required',
            'name' => 'required|string|max:50',
            'company_name' => 'nullable|string|max:100',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'zip_code' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'note' => 'nullable|string',
        ];
    }
    public function messages() : array
    {
        return [
            'country.required' => 'The country field is required.',
            'name.required' => 'The name field is required.',
            'company_name.max' => 'The company name may not be greater than :100.',
            'address.required' => 'The address field is required.',
            'city.required' => 'The city field is required.',
            'zip_code.required' => 'The zip code field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'phone.required' => 'The phone field is required.',
        ];
    }
}
