<?php

// app/Repositories/CartRepository.php
namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\SizeVariant;
use Illuminate\Http\Request;

class CartRepository
{
    /**
     * Retrieves all carts with pagination if specified.
     *
     * @param mixed $is_paginate Indicates if pagination is required.
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection The collection of carts.
     */
    public function all($is_paginate)
    {
        if (isset($is_paginate) && $is_paginate != 0) {
            return Cart::paginate($is_paginate);
        }
        return Cart::get();
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function create($request)
    {
        $user_id = auth()->user()->id;
        $size_variant = SizeVariant::where('variant_id',$request['variant_id'])->where('size_id',$request['size_id'])->first();
        return Cart::create(array_merge($request, ['user_id' => $user_id,'size_variant_id' => $size_variant->id]));
    }

    /**
     * Retrieves a specific cart by its ID.
     *
     * @param int $id The ID of the cart to retrieve.
     * @throws ModelNotFoundException if the cart with the given ID is not found.
     * @return Cart The cart object with the specified ID.
     */
    public function find($id)
    {
        return Cart::findOrFail($id);
    }

    /**
     * Updates a cart by its ID with the provided request data.
     *
     * @param int $id The ID of the cart to update.
     * @param mixed $request The request data for updating the cart.
     * @return Cart The updated cart object.
     */
    public function update($id, $request)
    {
        $cart = $this->find($id);
        $user_id = auth()->user()->id;

        $cart->update(array_merge($request, ['user_id' => $user_id]));
        return $cart;
    }

    /**
     * Deletes a cart by its ID.
     *
     * @param int $id The ID of the cart to delete.
     * @throws ModelNotFoundException if the cart with the given ID is not found.
     * @return void
     */
    public function delete($id)
    {
        $cart = $this->find($id);
        $cart->delete();
    }
    
     /**
     * Retrieves soft deleted records from the cart repository.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator Paginated cart of soft deleted records.
     */
    public function getSoftDeleted()
    {
        // Retrieve soft deleted records from the cart repository.
        // Only retrieves 15 records at a time.
        return Cart::onlyTrashed()->paginate(15);
    }

    /**
     * Restores a soft deleted cart.
     *
     * @param int $id The ID of the cart to restore.
     * @throws ModelNotFoundException if the cart with the given ID is not found.
     * @return bool Returns true if the cart is successfully restored, false otherwise.
     */
    public function restore($id)
    {
     // Find the cart with the given ID
     $cart = Cart::withTrashed()->findOrFail($id);
    
     // Restore the cart and return the result
     return $cart->restore();
    }
}
