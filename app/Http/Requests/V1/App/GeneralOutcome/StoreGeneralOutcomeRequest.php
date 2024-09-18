<?php

namespace App\Http\Requests\V1\App\GeneralOutcome;

use App\Rules\EvenOddCheckRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreGeneralOutcomeRequest extends FormRequest
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
            'description' => ['required'],
            'amount' => ['required', 'integer', 'gt:50', new EvenOddCheckRule()],
        ];
    }
}
