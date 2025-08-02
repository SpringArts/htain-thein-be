<?php

namespace App\Http\Requests\V1\App\Report;

use App\Enums\ConfirmStatus;
use App\Enums\FinancialType;
use App\Rules\EvenOddCheckRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

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
            'amount' => ['bail', 'required', 'integer', 'gt:50', new EvenOddCheckRule()],
            'description' => ['bail', 'required', 'max:255'],
            'type' => ['bail', 'required', 'string', Rule::in([
                FinancialType::INCOME,
                FinancialType::EXPENSE,
            ])],
            'confirmStatus' => ['bail', 'required', 'string', ['bail', 'required', 'string', Rule::in([
                ConfirmStatus::PENDING,
                ConfirmStatus::ACCEPTED,
                ConfirmStatus::REJECTED,
            ])],],
            'verifier_id' => ['bail', 'nullable', 'integer'],
        ];
    }
}
