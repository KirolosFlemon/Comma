<?php

namespace App\Http\Requests\Status;

use Illuminate\Foundation\Http\FormRequest;

class StatusRequest extends FormRequest
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
     * A method that defines the validation rules for creating a new status.
     *
     * @return array The validation rules array for creating a new status.
     */
    private function createValidation()
    {
        return [
            'name_ar' => ['required', 'string'],
            'name_en' => ['required', 'string'],
        ];
    }
    
    /**
     * A method that defines the validation rules for updating a status.
     *
     * @return array The validation rules for updating a status.
     */
    private function updateValidation()
    {
        return [
            'id' => ['required', 'exists:statuses,id'],
            'name_ar' => ['required', 'string'],
            'name_en' => ['required', 'string'],
        ];
    }
    /**
     * A method that defines the validation rules for validating the status ID.
     *
     * @return array The validation rules for the status ID.
     */
    private function idValidation()
    {
        return [
            'id' => ['required', 'exists:statuses,id'],
        ];
    }
    /**
     * A description of the entire PHP function.
     *
     * @return array The validation rules array for all statuses.
     */
    private function allValidation()
    {
        return [
            'is_paginate' => ['nullable', 'integer'],
        ];
    }
}

