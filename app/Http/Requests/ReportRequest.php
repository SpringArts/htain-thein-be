<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class ReportRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        $rules = [
            'amount' => 'required|integer|gt:50',
            'description' => 'required|max:255',
            'type' => 'required|string',
            'confirm_status' => 'nullable|boolean',
            'reporter_id' => 'required|integer',
            'verifier_id' => 'nullable|integer'
        ];

        // Conditional rules for the update operation
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['amount'] = 'required|integer|gt:50';
            $rules['description'] = 'required|max:255';
            $rules['type'] = 'required|string';
            $rules['confirm_status'] = 'nullable|boolean';
            $rules['reporter_id'] = 'nullable|integer';
            $rules['verifier_id'] = 'nullable|integer';
        }

        return $rules;
    }
    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, $this->errorResponse($validator));
    }

    /**
     * Get the error response for the request.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function errorResponse(Validator $validator)
    {
        return response()->json([
            'errors' => $validator->errors(),
        ], 422);
    }
}
