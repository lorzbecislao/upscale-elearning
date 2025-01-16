<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UpdateCourseRequest extends FormRequest
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
            'code' => [
                'required',
                Rule::unique('courses', 'code')->whereNull('deleted_at')->ignore($id),
                'string',
            ],
            'name' => [
                'required',
                Rule::unique('courses', 'name')->whereNull('deleted_at')->ignore($id),
                'string',
            ],
            'description' => 'nullable',
        ];
    }
}
