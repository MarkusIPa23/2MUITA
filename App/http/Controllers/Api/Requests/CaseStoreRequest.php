<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CaseStoreRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'vehicle.plate_no' => 'required|string',
            'vehicle.country' => 'required|string|size:2',
            'declarant.name' => 'required|string',
            'cargo' => 'required|array|min:1',
            'cargo.*.hs_code' => 'required|digits:10',
            'cargo.*.value_eur' => 'required|numeric|min:0',
            'cargo.*.weight_kg' => 'nullable|numeric|min:0',
        ];
    }
}
