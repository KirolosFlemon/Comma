<?php

namespace App\Http\Requests\Color;

use Illuminate\Foundation\Http\FormRequest;

class ColorRequest extends FormRequest
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
            case 'restore':
                return $this->idValidation();
            case 'all':
                return $this->allValidation();

            default:
                return [];
        }
    }


    /**
     * A method that defines the validation rules for creating a new color.
     *
     * @return array The validation rules array for creating a new color.
     */
    private function createValidation()
    {
        return [
            'name_ar' => ['required', 'string'],
            'name_en' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif'],
        ];
    }
    
    /**
     * A method that defines the validation rules for updating a color.
     *
     * @return array The validation rules for updating a color.
     */
    private function updateValidation()
    {
        return [
            'id' => ['required', 'exists:colors,id'],
            'name_ar' => ['required', 'string'],
            'name_en' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif'],
        ];
    }
    /**
     * A method that defines the validation rules for validating the color ID.
     *
     * @return array The validation rules for the color ID.
     */
    private function idValidation()
    {
        return [
            'id' => ['required', 'exists:colors,id'],
        ];
    }
    /**
     * A description of the entire PHP function.
     *
     * @return array The validation rules array for all colors.
     */
    private function allValidation()
    {
        return [
            'is_paginate' => ['nullable', 'integer'],
        ];
    }
}

