<?php

namespace App\Http\Requests\V1\App\Report;

use App\Rules\EvenOddCheckRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
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
            'amount' => ['required', 'integer', 'gt:50', new EvenOddCheckRule()],
            'description' => 'required|max:255',
            'type' => ['required', 'string', 'in:INCOME,EXPENSE'],
            'confirm_status' => 'nullable|boolean',
            'reporter_id' => 'required|integer',
            'verifier_id' => 'nullable|integer',
        ];
    }
}
