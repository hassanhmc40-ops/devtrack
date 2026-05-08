<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Only authenticated users (leads) can create projects.
     */
    public function authorize(): bool
    {
        return true; // Policy check is done in the controller
    }

    /**
     * Validation rules for creating a project (US3).
     */
    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'deadline'    => ['nullable', 'date', 'after_or_equal:today'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'       => 'A project title is required.',
            'title.min'            => 'The title must be at least 3 characters.',
            'deadline.after_or_equal' => 'The deadline must be today or a future date.',
        ];
    }
}
