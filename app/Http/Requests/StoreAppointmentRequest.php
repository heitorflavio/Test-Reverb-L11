<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
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
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'start' => ['required', 'date'],
            'end' => ['required', 'date'],
            // 'start' => ['required'],
            // 'end' => ['required'],
            'calendar_id' => ['required', 'exists:calendars,id'],
            'status' => ['required', 'string'],
            'color' => ['required', 'string'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The title field is required.',
            'description.required' => 'The description field is required.',
            'start.required' => 'The start field is required.',
            'end.required' => 'The end field is required.',
            'calendar_id.required' => 'The calendar field is required.',
            'status.required' => 'The status field is required.',
            'color.required' => 'The color field is required.',
        ];
    }
}
