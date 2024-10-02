<?php

namespace App\Http\Requests\Favourite;

use Illuminate\Foundation\Http\FormRequest;

class FavouriteRequest extends FormRequest
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
            'user_id' => ['required', 'exists:users,id'],
            'product_id' => ['required', 'exists:products,id'],
        ];
    }

    /**
     * Defines the validation rules for updating a brand.
     *
     * @return array The validation rules for updating a brand.
     */
    private function updateValidation()
    {
        return [
            'id' => ['required', 'exists:favourites,id'],
            'user_id' => ['required', 'exists:users,id'],
            'product_id' => ['required', 'exists:products,id'],
        ];
    }

    /**
     * Defines the validation rules for validating the brand ID.
     *
     * @return array The validation rules for the brand ID.
     */
    private function idValidation()
    {
        return [
            'id' => ['required', 'exists:favourites,id'],
        ];
    }

    /**
     * Defines the validation rules for all validations.
     *
     * @return array The validation rules for all validations.
     */
    private function allValidation()
    {
        return [
            'is_paginate' => ['nullable', 'integer'],
        ];
    }
}
