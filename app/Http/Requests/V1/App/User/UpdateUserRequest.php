<?php

namespace App\Http\Requests\V1\App\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'name' => 'sometimes|required|max:255',
            'email' => ['sometimes', 'required', 'email', Rule::unique('users')->ignore($this->user)],
            'password' => 'nullable|min:8',
            'role' => 'sometimes|required|in:ADMIN,MEMBER,SUPER_ADMIN',
            'accountStatus' => 'sometimes|required|in:ACTIVE,SUSPENDED',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'account_status' => $this->accountStatus ?? $this->account_status ?? null,
        ]);
    }
}
