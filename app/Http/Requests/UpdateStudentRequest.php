<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
        $id = $this->route('id');
        return [
            'student_number' => [
                'required', // Ensures that the student_number must be present
                'integer',   // Ensures that the student_number is a string
                'digits:8',
                'unique:students,student_number,' . $id, // Unique in students table, excluding the current student
            ],
            'email' => [
                'email',
                'required',
                'unique:students,email,' . $id, // Unique in students table, excluding the current student
            ],
            'first_name' => 'required',
            'last_name' => 'required',
        ];
    }
}
