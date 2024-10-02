<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
     * Validation rules for creating a category.
     *
     * @return array Validation rules.
     */
    private function createValidation(): array
    {
        return [
            'name_ar' => ['required', 'string'],
            'name_en' => ['required', 'string'],
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif'],
        ];
    }

    /**
     * Validation rules for updating a category.
     *
     * @return array Validation rules.
     */
    private function updateValidation(): array
    {
        return [
            'id' => ['required', 'exists:categories,id'],
            'name_ar' => ['required', 'string'],
            'name_en' => ['required', 'string'],
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif'],
        ];
    }

    /**
     * Validation rules for a category's ID.
     *
     * @return array Validation rules.
     */
    private function idValidation(): array
    {
        return [
            'id' => ['required', 'exists:categories,id'],
        ];
    }

    /**
     * Validation rules for pagination.
     *
     * @return array Validation rules.
     */
    private function allValidation(): array
    {
        return [
            'is_paginate' => ['nullable', 'integer'],
        ];
    }
}

