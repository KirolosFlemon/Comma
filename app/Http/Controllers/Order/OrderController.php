<?php

// app/Http/Controllers/OrderController.php
namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;

use App\Http\Requests\Order\OrderRequest;
use App\Http\Resources\Order\OrderAllResource;
use App\Http\Resources\Order\OrderResource;
use App\Services\Order\OrderService;
use Illuminate\Support\Facades\Request;

class OrderController extends Controller
{
    protected $orderService;

    /**
     * A constructor for the OrderController class.
     *
     * @param OrderService $orderService The order service instance to be injected.
     * @throws \Exception if an error occurs during instantiation
     * @return void
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Retrieves a specific order by its ID.
     *
     * @param int $id The ID of the order to retrieve.
     * @return OrderResource The order resource object.
     */
    public function get($id)
    {
        $orders = $this->orderService->getOrderById($id);
        return new OrderAllResource($orders);
    }

    
    /**
     * Retrieves a specific order by its ID.
     *
     * @param int $id The ID of the order to retrieve.
     * @return OrderResource The order resource object.
     */
    public function getGrandTotal(OrderRequest $request)
    {
        return  $orders = $this->orderService->getGrandTotal($request);
    }
    
    
    /**
     * Retrieves all orders using the order service.
     *
     * @return OrderResource
     */
    public function all(OrderRequest $request)
    {
        $orders = $this->orderService->getAllOrders($request,$request->is_paginate ?? 0);
        if (isset($request->is_paginate) && $request->is_paginate != 0) {

            return OrderAllResource::collection($orders);
        }
        return OrderAllResource::collection($orders);
    }

    /**
     * Creates a new order using the provided request.
     *
     * @param OrderRequest $request The request containing order information.
     * @return OrderResource The newly created order resource.
     */
    public function create(OrderRequest $request)
    {
        $order = $this->orderService->createOrder($request);
        
        return new OrderResource($order);
    }


    /**
     * A description of the entire PHP function.
     *
     * @param OrderRequest $request description
     * @param $id description
     * @throws Some_Exception_Class description of exception
     * @return OrderResource description
     */
    public function update(OrderRequest $request, $id)
    {
        $order =  $this->orderService->updateOrder($id, $request);
        return new OrderResource($order);
    }

    /**
     * Deletes a order by its ID.
     *
     * @param int $id The ID of the order to delete.
     * @return \Illuminate\Http\JsonResponse The JSON response indicating success.
     */
    public function delete($id)
    {
        $this->orderService->deleteOrder($id);
        return response()->json([
            'Message' => 'success.',
            'data' => 'Order deleted successfully.',
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
         $order = $this->orderService->getSoftDeleted();
        return  OrderAllResource::collection($order);
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
        $this->orderService->restore($id);
        return response()->json([
            'data' => 'Collection restored successfully.',
            'Message' => 'success.',
        ], 200);
    }
}
