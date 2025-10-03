<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Supplement;

class StoreSupplementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return Supplement::getValidationRules();
    }

    public function messages(): array
    {
        return [
            'date.before_or_equal' => 'Date cannot be in the future.',
            'supplement_name.required' => 'Supplement name is required.'
        ];
    }
}