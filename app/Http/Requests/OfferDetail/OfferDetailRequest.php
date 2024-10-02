<?php

namespace App\Http\Requests\OfferDetail;

use Illuminate\Foundation\Http\FormRequest;

class OfferDetailRequest extends FormRequest
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
     * Get the validation rules for creating a new offer.
     *
     * @return array<string, array<string>>
     */
    private function createValidation()
    {
        return [
            'id' => ['required', 'exists:offers,id'],
            'code' => ['nullable', 'string', 'min:2', 'max:255'],
            'type' => ['required', 'string', 'min:2', 'max:255', 'in:value,percentage'],
            'value' => ['required', 'numeric', 'min:0', 'max:100'],
            'min_quantity' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'product_id' => ['nullable', 'exists:products,id'],
            'collection_id' => ['nullable', 'exists:collections,id'],
        ];
    }

    /**
     * Get the validation rules for updating a new offer.
     *
     * @return array<string, array<string>>
     */
    private function updateValidation()
    {
        return [
            'id' => ['required', 'exists:offers,id'],
            'code' => ['nullable', 'string', 'min:2', 'max:255'],
            'type' => ['required', 'string', 'min:2', 'max:255', 'in:value,percentage'],
            'value' => ['required', 'numeric', 'min:0', 'max:100'],
            'min_quantity' => ['nullable', 'numeric', 'min:0', 'max:100'],
            // 'min_price' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ];
    }

    /**
     * Get the validation rules for the offer ID.
     *
     * @return array<string, array<string>>
     */
    private function idValidation()
    {
        return [
            'id' => ['required', 'exists:offers,id']
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
