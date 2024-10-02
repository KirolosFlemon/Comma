<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
            case 'grand-total':
                return $this->getGrandTotalValidation();
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
            'code' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'payment_type_id' => ['nullable', 'exists:payment_types,id'],
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
            'id' => ['required', 'exists:orders,id'],
            'code' => ['required', 'string'],
            'user_id' => ['required', 'integer'],
            'address_id' => ['required', 'integer'],
            'status_id' => ['required', 'integer'],
            'coupon_price' => ['required', 'numeric'],
            'shipping_price' => ['required', 'numeric'],
            'payment_type_id' => ['required', 'integer'],
            'payment_status' => ['required', 'string'],
            'transaction_id' => ['required', 'string'],
            'coupon_id' => ['required', 'integer'],
            'total' => ['required', 'numeric'],
            'grand_total' => ['required', 'numeric'],
            'notes' => ['nullable', 'string'],
            'delivered_at' => ['nullable', 'date'],
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
            'id' => ['required', 'exists:brands,id'],
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
    private function getGrandTotalValidation()
    {
        return [
            'code' => ['nullable', 'exists:coupons,code'],
        ];
    }
}
