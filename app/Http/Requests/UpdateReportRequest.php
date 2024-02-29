<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

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
