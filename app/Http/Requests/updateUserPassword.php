<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class updateUserPassword extends FormRequest
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
        $currentPass = $req->input("current_password");

        return [
            'current_password' => [
                'required', 
                'string', 
                Rule::excludeIf(fn () => Hash::check($currentPass, $user->password))
            ],
            "password" => 'Required|min:8|max:20',
        ];
    }

    public function messages()
    {
        return [
            'password.required' => "Поле \"Password\" должно быть заполнено",
            'password.min' => "Поле \"Password\" должно содержать минимум 8 символов",
            'password.max' => "Поле \"Password\" должно содержать не более 20 символов",
        ];
    }
}
