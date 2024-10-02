<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class RoleRequest extends FormRequest
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
     * Get the validation rules for creating a new rule.
     *
     * @return array<string, array<string>>
     */
    private function createValidation()
    {
        return [
            'name' => ['required', 'string', 'max:250', Rule::unique('roles')],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['required', 'integer', 'exists:permissions,id'],
        ];
    }

    /**
     * Get the validation rules for updating a new rule.
     *
     * @return array<string, array<string>>
     */
    private function updateValidation()
    {
        return [
            'id' => ['required', 'exists:rules,id'],
            'name' => ['required', 'string', 'max:250', Rule::unique('roles')],
            'permissions' => ['required', 'array'],
            'permissions.*' => ['required', 'integer', 'exists:permissions,id'],
        ];
    }

    /**
     * Get the validation rules for the rule ID.
     *
     * @return array<string, array<string>>
     */
    private function idValidation()
    {
        return [
            'id' => ['required', 'exists:rules,id']
        ];
    }

    /**
     * Get the validation rules for the is_paginate field.
     *
     * @return array<string, array<string>>
     */
    private function allValidation()
    {
        return [
            'is_paginate' => ['nullable', 'integer'],
        ];
    }
}
