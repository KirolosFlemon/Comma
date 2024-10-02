<?php

namespace App\Http\Requests\Material;

use Illuminate\Foundation\Http\FormRequest;

class MaterialRequest extends FormRequest
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
            case 'resotre':
                return $this->idValidation();
            case 'all':
                return $this->allValidation();

            default:
                return [];
        }
    }

    /**
     * A method that defines the validation rules for creating a material.
     *
     * @return array The validation rules for creating a material.
     */
    private function createValidation()
    {
        return [
            'name_ar' => ['required', 'string','min:5' ,'max:150'],
            'name_en' => ['required', 'string','min:5' ,'max:150'],
        ];
    }

    /**
     * A method that defines the validation rules for updating a material.
     *
     * @return array The validation rules for updating a material.
     */
    private function updateValidation()
    {
        return [
            'id' => ['required', 'exists:materials,id'],
            'name_ar' => ['required', 'string'],
            'name_en' => ['required', 'string'],
        ];
    }

    /**
     * A method that defines the validation rules for a material ID.
     *
     * @return array The validation rules for a material ID.
     */
    private function idValidation()
    {
        return [
            'id' => ['required', 'exists:materials,id'],
        ];
    }

    /**
     * A method that defines the validation rules for the pagination parameter.
     *
     * @return array The validation rules for the pagination parameter.
     */
    private function allValidation()
    {
        return [
            'is_paginate' => ['nullable','integer'],
        ];
    }
}

