<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class adminCrateUser extends FormRequest
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
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:8|max:20',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Поле \"Name\" должно быть заполнено",
            'email.required' => "Поле \"Email adress\" должно быть заполнено",
            'password.required' => "Поле \"Password\" должно быть заполнено",
            'name.max' => "Поле \"Name\" должно содержать не более 100 символов",
            'email.max' => "Поле \"Email adress\" должно содержать не более 100 символов",
            'password.min' => "Поле \"Password\" должно содержать минимум 8 символов",
            'password.max' => "Поле \"Password\" должно содержать не более 20 символов",
            'email.unique' => "Такая почта уже существует",
        ];
    }
}
