<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGoalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'category' => ['nullable', 'string', 'max:100'],
            'start_date' => ['required', 'date'],
            'deadline' => ['required', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'in:active,completed,failed'],
            'specific' => ['nullable', 'string'],
            'measurable' => ['nullable', 'string'],
            'achievable' => ['nullable', 'string'],
            'relevant' => ['nullable', 'string'],
            'time_bound' => ['nullable', 'string'],
            'milestones' => ['nullable', 'array'],
            'milestones.*' => ['required', 'string', 'max:255'],
        ];
    }
}
