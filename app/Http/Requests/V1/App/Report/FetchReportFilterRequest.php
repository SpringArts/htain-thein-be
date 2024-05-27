<?php

namespace App\Http\Requests\V1\App\Report;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FetchReportFilterRequest extends FormRequest
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
            'limit' => ['integer'],
            'page' => ['integer'],
            'generalSearch' => ['nullable', 'string'],
            'amount' => ['nullable', 'integer'],
            'type' => ['nullable', Rule::in(['INCOME', 'EXPENSE'])],
            'confirmStatus' => ['nullable', 'boolean'],
            'createdAt' => ['nullable', 'date'],
        ];
    }
}
