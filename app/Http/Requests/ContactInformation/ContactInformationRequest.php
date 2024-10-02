<?php

namespace App\Http\Requests\ContactInformation;

use Illuminate\Foundation\Http\FormRequest;

class ContactInformationRequest extends FormRequest
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
     * Get the validation rules for creating a new address.
     *
     * @return array<string, array<string>>
     */
    private function createValidation()
    {
        return [
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'digits:11'],
            'message' => ['required', 'string'],
        ];
    }

    /**
     * Get the validation rules for updating a new address.
     *
     * @return array<string, array<string>>
     */
    private function updateValidation()
    {
   
        return [
            'id' => ['required', 'exists:contact_informations,id'],
            'name' => ['required', 'string', 'max:150'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'digits:11'],
            'message' => ['required', 'string'],
        ];
    }

    /**
     * Get the validation rules for the address ID.
     *
     * @return array<string, array<string>>
     */
    private function idValidation()
    {
        return [
            'id' => ['required', 'exists:contact_informations,id']
        ];
    }

    /**
     * Get the validation rules for the is_paginate field.
     *
     * @return array<string, array<string>>
     */
    private function allValidation()
    {
        return [
            'is_paginate' => ['nullable', 'integer'],
        ];
    }
}
