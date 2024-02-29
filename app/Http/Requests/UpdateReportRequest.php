<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReportRequest extends FormRequest
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
            'amount' => 'required|integer|gt:50',
            'description' => 'required|max:255',
            'type' => 'required|string',
            'confirm_status' => 'nullable|boolean',
            'reporter_id' => 'required|integer',
            'verifier_id' => 'nullable|integer'
        ];
    }
}
