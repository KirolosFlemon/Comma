<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $k = count($this->segments());
        $endPoint = $this->segment($k);
        switch ($endPoint) {
            case 'create':
                return $this->createValidation();
            case 'update':
                return $this->updateValidation();
            case 'delete':
            case 'get':
                return $this->idValidation();
            case 'all':
                return $this->allValidation();

            default:
                return [];
        }
    }


    /**
     * A method that defines the validation rules for creating a new branch.
     *
     * @return array The validation rules array for creating a new branch.
     */
    private function createValidation()
    {
        return [
            'name' => ['required', 'string', 'min:1', 'max:60'],
            'username' => ['nullable', 'string', 'min:1', 'max:60'],
            'phone' => ['required', 'digits:11', 'unique:users,phone,except,id'],
            'email' => ['required', 'unique:users,email,except,id'],
            'password' => ['required', 'min:4'],
            'image' => ['nullable', 'image']
        ];
    }

    /**
     * A method that defines the validation rules for updating a branch.
     *
     * @return array The validation rules array for updating a branch.
     */
    private function updateValidation()
    {
        return [
            'id' => ['required', 'exists:users,id'],
            'name' => ['required', 'string'],
            'username' => ['nullable', 'string', 'min:1', 'max:60'],
            'phone' => ['required', 'digits:11', 'unique:users,phone,except,id'],
            'email' => ['required', 'unique:users,email,except,id'],
            'password' => ['required', 'min:4'],
        ];
    }
    private function idValidation()
    {
        return [
            'id' => ['required', 'exists:users,id'],
        ];
    }
    private function allValidation()
    {
        return [
            'is_paginate' => ['nullable', 'integer'],
        ];
    }
}
