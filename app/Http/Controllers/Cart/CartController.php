<?php

// app/Http/Controllers/CartController.php
namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;

use App\Http\Requests\Cart\CartRequest;
use App\Http\Resources\Cart\CartResource;
use App\Services\Cart\CartService;


class CartController extends Controller
{
    protected $cartService;

    /**
     * A constructor for the CartController class.
     *
     * @param CartService $cartService The cart service instance to be injected.
     * @throws \Exception if an error occurs during instantiation
     * @return void
     */
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Retrieves a specific cart by its ID.
     *
     * @param int $id The ID of the cart to retrieve.
     * @return CartResource The cart resource object.
     */
    public function get($id)
    {
        $carts = $this->cartService->getCartById($id);
        return new CartResource($carts);
    }
    
    /**
     * Retrieves all carts using the cart service.
     *
     * @return CartResource
     */
    public function all(CartRequest $request)
    {
        $carts = $this->cartService->getAllCarts($request->is_paginate ?? 0);
        if (isset($request->is_paginate) && $request->is_paginate != 0) {

            return CartResource::collection($carts);
        }
        return CartResource::collection($carts);
    }

    /**
     * Creates a new cart using the provided request.
     *
     * @param CartRequest $request The request containing cart information.
     * @return CartResource The newly created cart resource.
     */
    public function create(CartRequest $request)
    {
        $cart = $this->cartService->createCart($request);
        
        return new CartResource($cart);
    }


    /**
     * A description of the entire PHP function.
     *
     * @param CartRequest $request description
     * @param $id description
     * @throws Some_Exception_Class description of exception
     * @return CartResource description
     */
    public function update(CartRequest $request, $id)
    {
        $cart =  $this->cartService->updateCart($id, $request);
        return new CartResource($cart);
    }

    /**
     * Deletes a cart by its ID.
     *
     * @param int $id The ID of the cart to delete.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating success.
     */
    public function delete($id)
    {
        $this->cartService->deleteCart($id);
        return response()->json([
            'Message' => 'success.',
            'data' => 'Cart deleted successfully.',
        ], 200);
    }

    
    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function getSoftDeleted()
    {
         $cart = $this->cartService->getSoftDeleted();
        return  CartResource::collection($cart);
    }
    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function restore($id)
    {
        $this->cartService->restore($id);
        return response()->json([
            'data' => 'Collection restored successfully.',
            'Message' => 'success.',
        ], 200);
    }
}
