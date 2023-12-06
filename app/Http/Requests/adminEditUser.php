<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Http\Request;

class adminEditUser extends FormRequest
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
    public function rules(Request $req): array
    {
        $user = User::where("id", $req->input("editUserId"))->first();

        return [
            'name' => 'required|string|max:100',
            'email' => ['required', 'email', 'max:100', Rule::unique('users')->ignore($user)],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => "Поле \"Name\" должно быть заполнено",
            'email.required' => "Поле \"Email adress\" должно быть заполнено",
            'name.max' => "Поле \"Name\" должно содержать не более 100 символов",
            'email.max' => "Поле \"Email adress\" должно содержать не более 100 символов",
            'email.unique:users' => "Такая почта уже существует",
        ];
    }
}
