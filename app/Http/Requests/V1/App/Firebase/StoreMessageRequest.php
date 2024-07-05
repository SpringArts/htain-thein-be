<?php

namespace App\Http\Requests\V1\App\Firebase;

use Illuminate\Foundation\Http\FormRequest;
use Log;

class StoreMessageRequest extends FormRequest
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
        Log::info($this->message);
        return [
            'message' => ['required', 'string', 'max:255'],
        ];
    }
}
