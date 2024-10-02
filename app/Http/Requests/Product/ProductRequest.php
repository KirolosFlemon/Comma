<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
     * Returns the validation rules for creating a product.
     *
     * @return array The validation rules.
     */
    private function createValidation()
    {
        return [
            'name_ar' => ['nullable', 'string'],
            'name_en' => ['nullable', 'string'],
            'description_ar' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'price_after_discount' => ['nullable', 'numeric', 'min:0'],
            'sku' => ['required', 'string', 'unique:products'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['exists:categories,id'],
            'collections' => ['nullable', 'array'],
            'collections.*' => ['exists:collections,id'],
            'branches' => ['nullable', 'array'],
            'best_seller' => ['nullable', 'boolean'],
            'branches.*' => ['exists:branches,id'],
            'variants' => ['nullable', 'array'],
            'variants.*.size_id' => ['nullable', 'array'],
            'variants.*.size_id.*' => ['nullable', 'exists:sizes,id'],
            'variants.*.color_id' => ['nullable', 'exists:colors,id'],
            'variants.*.material_id' => ['nullable', 'exists:materials,id'],
            'variants.*.image' => ['nullable', 'image'],
            'variants.*.additional_price' => ['nullable', 'numeric', 'min:0'],
            'variants.*.inventory_number' => ['nullable', 'numeric', 'min:0'],
            'variants.*.out_of_stock' => ['boolean'],
        ];
    }

    /**
     * Returns the validation rules for updating a product.
     *
     * @return array The validation rules.
     */
    private function updateValidation()
    {
        return [
            'id' => ['required', 'exists:products,id'],
            'name_ar' => ['required', 'string'],
            'name_en' => ['required', 'string'],
            'description_ar' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'price_after_discount' => ['nullable', 'numeric', 'min:0'],
            'sku' => ['nullable', 'string', Rule::unique('products')->ignore($this->id)],
            'brand_id' => ['required', 'exists:brands,id'],
            'categories' => ['required', 'array'],
            'categories.*' => ['exists:categories,id'],
            'collections' => ['required', 'array'],
            'best_seller' => ['required', 'boolean'],
            'collections.*' => ['exists:collections,id'],
            'branches' => ['required', 'array'],
            'branches.*' => ['exists:branches,id'],
            'variants' => ['required', 'array'],
            'variants.*.size_id' => ['nullable', 'array'],
            'variants.*.size_id.*' => ['nullable', 'exists:sizes,id'],
            'variants.*.color_id' => ['nullable', 'exists:colors,id'],
            'variants.*.material_id' => ['required', 'exists:materials,id'],
            'variants.*.additional_price' => ['nullable', 'numeric', 'min:0'],
            'variants.*.inventory_number' => ['nullable', 'numeric', 'min:0'],
            'variants.*.out_of_stock' => ['boolean'],
        ];
    }
    /**
     * Validates the 'id' field to ensure it is required and exists in the 'products' table.
     *
     * @return array Returns an array with the validation rules for the 'id' field.
     */

    private function idValidation()
    {
        return [
            'id' => ['required', 'exists:products,id'],
        ];
    }

    /**
     * Returns an empty array.
     *
     * @return array Empty array.
     */
    private function allValidation()
    {
        return [];
    }

}
