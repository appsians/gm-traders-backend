<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FruitScannerRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'fruit_qr_code'   => 'required|string|max:255',
        'fruit_name'      => 'required|string|max:255',
        'qr_code_image'   => 'required|string',
        'origin'          => 'required|string',
        'farmer_name'     => 'required|string',
        'orchard_size' => 'required|string',
        
    ];
    }
}
