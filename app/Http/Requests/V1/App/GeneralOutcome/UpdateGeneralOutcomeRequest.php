<?php

namespace App\Http\Requests\V1\App\GeneralOutcome;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGeneralOutcomeRequest extends FormRequest
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
            'reporter_id' => ['required', 'exists:users,id'],
            'description' => ['required'],
            'amount' => ['required', 'integer']
        ];
    }
}
