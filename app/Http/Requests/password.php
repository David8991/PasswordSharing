<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class password extends FormRequest
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
            "password" => 'Required|min:8|max:20',
            "accessLevel" => 'Required'
        ];
    }

    public function messages()
    {
        return [
            'password.required' => "Поле \"Password\" должно быть заполнено",
            'password.min' => "Поле \"Password\" должно содержать минимум 8 символов",
            'password.max' => "Поле \"Password\" должно содержать не более 20 символов",
            'accessLevel.required' => "Поле \"Password access\" должно быть заполнено",
        ];
    }
}
