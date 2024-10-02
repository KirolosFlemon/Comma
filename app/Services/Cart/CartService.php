<?php
// app/Services/CartService.php
namespace App\Services\Cart;

use App\Repositories\Cart\CartRepository;
use App\Traits\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartService
{
    protected $cartRepository;

    /**
     * Constructor for CartService class.
     *
     * @param CartRepository $cartRepository The cart repository instance
     * @throws \Exception if an error occurs during instantiation
     * @return void
     */
    public function __construct(CartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    /**
     * Retrieves all carts based on pagination flag.
     *
     * @param mixed $is_paginate Flag to determine pagination
     * @return mixed Result of retrieving all carts
     */
    public function getAllCarts($is_paginate)
    {
        return $this->cartRepository->all($is_paginate);
    }

    /**
     * Create a new cart with the provided request data.
     *
     * @throws \Exception if an error occurs during cart creation
     * @return Cart The newly created cart with images loaded
     */
    public function createCart(Request $request)
    {

        try {
            DB::beginTransaction();

            $cart = $this->cartRepository->create($request->all());
            DB::commit();
            return $cart;
        } catch (\Throwable $th) {
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Retrieves a specific cart by its ID.
     *
     * @param int $id The ID of the cart to retrieve.
     * @throws ModelNotFoundException if the cart with the given ID is not found.
     * @return Cart The cart object with the specified ID.
     */
    public function getCartById($id)
    {
        return $this->cartRepository->find($id);
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function updateCart($id, Request $request)
    {
        try {

            DB::beginTransaction();

            $cart = $this->cartRepository->update($id, $request->all());
            // Commit the transaction if all operations are successful
            DB::commit();
            return $cart;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function deleteCart($id)
    {
        $this->cartRepository->delete($id);
    }
    
    /**
     * Retrieves soft deleted records from the cart repository.
     *
     * @return Some_Return_Value
     */
    public function getSoftDeleted()
    {
        return $this->cartRepository->getSoftDeleted();
    }



    /**
     * Restores a soft deleted cart by its ID.
     *
     * @param int $id The ID of the cart to restore.
     * @return void
     */
    public function restore($id)
    {
        // Call the restore method on the cart repository
        // to restore the soft deleted cart.
        return $this->cartRepository->restore($id);
    }
}
