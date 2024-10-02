<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'address' => ['required', 'string', 'max:150'],
            'lat' => ['required', 'numeric'],
            'long' => ['required', 'numeric'],
            'user_id' => ['required', 'exists:users,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'room_floor' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'digits:11'],
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
            'id' => ['required', 'exists:addresses,id'],
            'address' => ['required', 'string', 'max:150'],
            'lat' => ['required', 'numeric'],
            'long' => ['required', 'numeric'],
            'user_id' => ['required', 'exists:users,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'room_floor' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'digits:11'],
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
            'id' => ['required', 'exists:addresses,id']
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
