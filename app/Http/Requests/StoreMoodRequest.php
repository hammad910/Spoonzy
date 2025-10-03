<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Mood;

class StoreMoodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return Mood::getValidationRules();
    }

    public function messages(): array
    {
        return [
            'date.before_or_equal' => 'Date cannot be in the future.',
            'mood_level.between' => 'Mood level must be between 1 and 10.',
            'tags.array' => 'Tags must be an array.'
        ];
    }
}