<?php

namespace App\Http\Requests\City;

use Illuminate\Foundation\Http\FormRequest;

class CityRequest extends FormRequest
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
     * A method that defines the validation rules for creating a new city.
     *
     * @return array<string, array<string>>
     */
    private function createValidation()
    {
        return [
            'name_ar' => ['required', 'string', 'max:100'],
            'name_en' => ['required', 'string'], 'max:100',
            'postal_code' => ['nullable', 'integer'],
            'shipping_price' => ['nullable'],
            
        ];
    }

    /**
     * Update the validation rules for the model.
     *
     * @return array
     */
    private function updateValidation()
    {
        return [
            'id' => ['required', 'exists:cities,id'],
            'name_ar' => ['required', 'string'],
            'name_en' => ['required', 'string'],
            'postal_code' => ['nullable'],
            'shipping_price' => ['nullable'],
        ];
    }

    /**
     * A method that defines the validation rules for the city ID.
     *
     * @return array<string, array<string>>
     */
    private function idValidation()
    {
        return [
            'id' => ['required', 'exists:cities,id'],
        ];
    }

    private function allValidation()
    {
        return [
            'is_paginate' => ['nullable', 'integer'],
        ];
    }
}
