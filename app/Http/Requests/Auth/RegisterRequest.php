<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:1', 'max:60'],
            // 'last_name' => ['required','string','min:1','max:60'],
            'username' => ['nullable', 'string', 'min:1', 'max:60'],
            'phone' => ['required','digits:11','unique:users,phone'],
            'email' => ['required','unique:users,email'],
            'password' => ['required','min:4'],
            'image' => ['nullable','image']
        ];
    }
}
