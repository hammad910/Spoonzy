<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Content;

class StoreContentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return Content::getValidationRules();
    }

    public function messages(): array
    {
        return [
            'content_type.in' => 'Content type must be either experiment or documentary.',
            'media_url.*.url' => 'Media URLs must be valid URLs.'
        ];
    }
}