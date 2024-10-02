<?php

namespace App\Http\Requests\Size;

use Illuminate\Foundation\Http\FormRequest;

class SizeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
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
            case 'restore':
                return $this->idValidation();
            case 'all':
                return $this->allValidation();

            default:
                return [];
        }
    }

    /**
     * A method that defines the validation rules for creating a new size.
     *
     * @return array<string, array<string>> The validation rules.
     */
    private function createValidation()
    {
        return [
            'size' => ['required', 'string'],
        ];
    }

    /**
     * A method that defines the validation rules for updating a size.
     *
     * @return array<string, array<string>> The validation rules.
     */
    private function updateValidation()
    {
        return [
            'id' => ['required', 'exists:sizes,id'],
            'size' => ['required', 'string'],
        ];
    }
    /**
     * A method that defines the validation rules for the size ID.
     *
     * @return array<string, array<string>> The validation rules.
     */
    private function idValidation()
    {
        return [
            'id' => ['required', 'exists:sizes,id'],
        ];
    }
    /**
     * A method that defines an empty array of validation rules.
     *
     * @return array Empty array.
     */
    private function allValidation()
    {
        return [
            'is_paginate' => ['nullable', 'integer'],
        ];
    }
}
