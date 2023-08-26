<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class NotiInfoRequest extends FormRequest
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
    public function rules(): array
    {
        $rules = [
            'user_id' => 'required|integer',
            'report_id' => 'required|integer',
            'check_status' => 'nullable|boolean',
        ];

        // Conditional rules for the update operation
        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['user_id'] .= '|sometimes'; // Make user_id field optional during update
            $rules['report_id'] .= '|sometimes'; // Make report_id field optional during update
            // Add any other conditional rules specific to the update operation
        }

        return $rules;
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
