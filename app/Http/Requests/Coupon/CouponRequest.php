<?php

namespace App\Http\Requests\Coupon;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            'code' => ['required', 'string', 'max:150'],
            'type' => ['required', 'in:value,percentage'],
            'value' => ['required', 'integer'],
            'all_users' => ['nullable', 'boolean'],
            'user_id' => ['nullable', 'exists:users,id'],
            'no_used_time' => ['nullable', 'string', 'max:255'],
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
            'id' => ['required', 'exists:coupons,id'],
            'code' => ['required', 'string', 'max:150'],
            'type' => ['required', 'in:value,percentage'],
            'value' => ['required', 'integer'],
            'all_users' => ['nullable', 'boolean'],
            'user_id' => ['arrray', 'nullable'],
            'user_id.*' => ['exists:users,id'],
            'no_used_time' => ['nullable', 'integer' ],
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
