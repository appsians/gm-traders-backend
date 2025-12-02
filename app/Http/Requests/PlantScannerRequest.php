<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlantScannerRequest extends FormRequest
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
        'plant_name'       => 'required|string|max:255',
        'qr_code'          => 'required|string ',
        'variety'          => 'required|string',
        'birthday'         => 'required|string',
        'care_instructions' => 'required|string',
        'verified_by'       => 'nullable|string',
        'qr_code_image'     => 'nullable|url',
    ];
    }
}
