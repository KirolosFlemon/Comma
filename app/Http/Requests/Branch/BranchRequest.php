<?php

namespace App\Http\Requests\Branch;

use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
     * A method that defines the validation rules for creating a new branch.
     *
     * @return array The validation rules array for creating a new branch.
     */
    private function createValidation()
    {
        return [
            'name_ar' => ['required', 'string'],
            'name_en' => ['required', 'string'],
            'address' => ['required', 'string', 'min:1', 'max:150'],
            'lat' => ['required', 'numeric'],
            'long' => ['required', 'numeric'],
        ];
    }
    
    /**
     * A method that defines the validation rules for updating a branch.
     *
     * @return array The validation rules array for updating a branch.
     */
    private function updateValidation()
    {
        return [
            'id' => ['required', 'exists:branches,id'],
            'name_ar' => ['required', 'string'],
            'name_en' => ['required', 'string'],
            'address' => ['required', 'string', 'min:1', 'max:150'],
            'lat' => ['required', 'numeric'],
            'long' => ['required', 'numeric'],
        ];
    }
    private function idValidation()
    {
        return [
            'id' => ['required', 'exists:branches,id'],
        ];
    }
    private function allValidation()
    {
        return [
            'is_paginate' => ['nullable', 'integer'],
        ];
    }
}

