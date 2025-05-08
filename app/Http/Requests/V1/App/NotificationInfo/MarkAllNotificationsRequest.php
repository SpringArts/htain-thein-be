<?php

namespace App\Http\Requests\V1\App\NotificationInfo;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MarkAllNotificationsRequest extends FormRequest
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
            'ids' => ['required', 'array'],
            'ids.*' => [
                'required',
                'integer',
                Rule::exists('notification_reads', 'noti_info_id')->where(function ($query) {
                    $query->where('user_id', auth()->id());
                }),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'ids.required' => 'The notification IDs are required.',
            'ids.array' => 'The notification IDs must be an array.',
            'ids.*.required' => 'Each notification ID is required.',
            'ids.*.integer' => 'Each notification ID must be a valid integer.',
            'ids.*.exists' => 'One or more notification IDs are invalid or do not belong to you.',
        ];
    }
}
