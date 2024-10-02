<?php

namespace App\Http\Requests\SubCategory;

use Illuminate\Foundation\Http\FormRequest;

class   SubCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Allow all requests to be authorized
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Get the current endpoint to determine which validation rules to use
        $k = count($this->segments());
        $endPoint = $this->segment($k);

        switch ($endPoint) {
            case 'create':
                // Validation rules for creating a sub category
                return $this->createValidation();

            case 'update':
                // Validation rules for updating a sub category
                return $this->updateValidation();

            case 'delete':
            case 'get':
            case 'restore':
                // Validation rules for getting a sub category
                return $this->idValidation();

            case 'all':
                // Validation rules for getting all sub categories
                return $this->allValidation();

            default:
                // Return empty rules if the endpoint is not recognized
                return [];
        }
    }


    /**
     * Validation rules for creating a sub category
     */
    private function createValidation()
    {
        return [
            // Required fields
            'name_ar' => ['required', 'string'],
            'name_en' => ['required', 'string'],

            // Optional fields
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif'],
            'category_ids' => ['nullable', 'array'], // Validation for array of category IDs
            'category_ids.*' => ['nullable', 'exists:categories,id'], // Each category ID should exist in the categories table
        ];
    }

    /**
     * Validation rules for updating a sub category
     */
    private function updateValidation()
    {
        return [
            // Required fields
            'id' => ['required', 'exists:sub_categories,id'],
            'name_ar' => ['required', 'string'],
            'name_en' => ['required', 'string'],

            // Optional fields
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif'],
            'category_ids' => ['nullable', 'array'], // Validation for array of category IDs
            'category_ids.*' => ['nullable', 'exists:categories,id'], // Each category ID should exist in the categories table
        ];
    }

    /**
     * Validation rules for getting a sub category
     */
    private function idValidation()
    {
        return [
            // Required field
            'id' => ['required', 'exists:sub_categories,id'],
        ];
    }

    /**
     * Validation rules for getting all sub categories
     */
    private function allValidation()
    {
        return [
            // Optional field
            'is_paginate' => ['nullable', 'integer'],
        ];
    }
}
