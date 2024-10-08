<?php

namespace App\Http\Requests\V1\App\Announcement;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnnouncementRequest extends FormRequest
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
            'title' => 'required|string',
            'content' => 'string',
            'isVisible' => 'boolean',
            'priority' => 'integer|in:1,2,3',
            'slug' => 'string|in:work,cost,alert,info,others',
            'dueDate' => 'required|date|after:today',
        ];
    }
}
