<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\BristolStool;

class StoreBristolStoolRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return BristolStool::getValidationRules();
    }

    public function messages(): array
    {
        return [
            'bristol_type.between' => 'Bristol type must be between 1 and 7.',
            'date.before_or_equal' => 'Date cannot be in the future.'
        ];
    }
}