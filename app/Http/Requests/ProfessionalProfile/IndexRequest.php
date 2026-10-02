<?php

namespace App\Http\Requests\ProfessionalProfile;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // public function authorize(): bool
    // {
    //     return false;
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:100',
            'location' => 'nullable|string|max:100',
            'skill' => 'nullable|array|max:50',
            'skill.*' => 'integer|exists:skills,id',
            'following' => 'nullable|boolean',
            'followed' => 'nullable|boolean',
        ];
    }
}
