<?php

namespace App\Http\Requests\Slider;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
     * A method that defines the validation rules for creating a new slider.
     *
     * @return array The validation rules array for creating a new slider.
     */
    private function createValidation()
    {
        return [
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif'],
            'active' => ['required', 'boolean'],
        ];
    }
    
    /**
     * A method that defines the validation rules for updating a slider.
     *
     * @return array The validation rules for updating a slider.
     */
    private function updateValidation()
    {
        return [
            'id' => ['required', 'exists:sliders,id'],
            'active' => ['required', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif'],
        ];
    }
    /**
     * A method that defines the validation rules for validating the slider ID.
     *
     * @return array The validation rules for the slider ID.
     */
    private function idValidation()
    {
        return [
            'id' => ['required', 'exists:sliders,id'],
        ];
    }
    /**
     * A description of the entire PHP function.
     *
     * @return array The validation rules array for all sliders.
     */
    private function allValidation()
    {
        return [
            'is_paginate' => ['nullable', 'integer'],
        ];
    }
}

