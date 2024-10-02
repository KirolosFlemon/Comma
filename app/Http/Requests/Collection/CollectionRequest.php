<?php

namespace App\Http\Requests\Collection;

use Illuminate\Foundation\Http\FormRequest;

class CollectionRequest extends FormRequest
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
     * A method that defines the validation rules for creating a new collection.
     *
     * @return array The validation rules array for creating a new collection.
     */
    private function createValidation()
    {
        return [
            'name_ar' => ['required', 'string', 'max:50'],
            'name_en' => ['required', 'string', 'max:50'],
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif'],
        ];
    }

    /**
     * A method that defines the validation rules for updating a collection.
     *
     * @return array The validation rules array for updating a collection.
     */
    private function updateValidation()
    {
        return [
            'id' => ['required', 'exists:collections,id'],
            'name_ar' => ['required', 'string', 'max:50'],
            'name_en' => ['required', 'string', 'max:50'],
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif'],
        ];
    }

    /**
     * A method that defines the validation rules for getting a collection.
     *
     * @return array The validation rules array for getting a collection.
     */
    private function idValidation()
    {
        return [
            'id' => ['required', 'exists:collections,id'],
        ];
    }

    /**
     * A method that defines the validation rules for getting all collections.
     *
     * @return array The validation rules array for getting all collections.
     */
    private function allValidation()
    {
        return [
            'is_paginate' => ['nullable', 'integer'],
        ];
    }
}
