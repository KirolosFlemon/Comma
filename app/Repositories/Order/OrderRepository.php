<?php

// app/Repositories/OrderRepository.php
namespace App\Repositories\Order;

use App\Models\Order;
use App\Traits\HelpersTrait;
use Illuminate\Http\Request;

class OrderRepository
{
    use HelpersTrait;
    /**
     * Retrieves all orders with pagination if specified.
     *
     * @param mixed $is_paginate Indicates if pagination is required.
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection The collection of orders.
     */
    public function getGrandTotal()
    {
        // if (isset($is_paginate) && $ != 0) {
        //     return Order::paginate($is_paginate);
        // }
        return Order::get();
    }
    /**
     * Retrieves all orders with pagination if specified.
     *
     * @param mixed $is_paginate Indicates if pagination is required.
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection The collection of orders.
     */
    public function all($request,$is_paginate)
    {
        $code = $request->get('code', null);
        if ($this->IsNullOrEmptyString($request->get('code', null))) {
            $code = null;
        }
        $userId = $request->get('user_id', null);
        if ($this->IsNullOrEmptyString($request->get('user_id', null))) {
            $userId = null;
        }
        $phone = $request->get('phone', null);
        if ($this->IsNullOrEmptyString($request->get('phone', null))) {
            $phone = null;
        }
        
        $order = Order::query();
        $order->when($code, function ($q) use ($code) {
            $q->where('code', $code);
        });
        $order->when($phone, function ($q) use ($phone) {
            $q->whereHas('user',function($q) use ($phone){
                $q->where('phone', $phone);
            });
        });
        $order->when($userId, function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
        if (isset($is_paginate) && $is_paginate != 0) {
            return $order->paginate($is_paginate);
        }
        return $order->get();
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
        return Order::create($request);
    }

    /**
     * Retrieves a specific order by its ID.
     *
     * @param int $id The ID of the order to retrieve.
     * @throws ModelNotFoundException if the order with the given ID is not found.
     * @return Order The order object with the specified ID.
     */
    public function find($id)
    {
        return Order::findOrFail($id);
    }

    /**
     * Updates a order by its ID with the provided request data.
     *
     * @param int $id The ID of the order to update.
     * @param mixed $request The request data for updating the order.
     * @return Order The updated order object.
     */
    public function update($id, $request)
    {
        $order = $this->find($id);
        $order->update($request);
        return $order;
    }

    /**
     * Deletes a order by its ID.
     *
     * @param int $id The ID of the order to delete.
     * @throws ModelNotFoundException if the order with the given ID is not found.
     * @return void
     */
    public function delete($id)
    {
        $order = $this->find($id);
        $order->delete();
    }
    
     /**
     * Retrieves soft deleted records from the order repository.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator Paginated order of soft deleted records.
     */
    public function getSoftDeleted()
    {
        // Retrieve soft deleted records from the order repository.
        // Only retrieves 15 records at a time.
        return Order::onlyTrashed()->paginate(15);
    }

    /**
     * Restores a soft deleted order.
     *
     * @param int $id The ID of the order to restore.
     * @throws ModelNotFoundException if the order with the given ID is not found.
     * @return bool Returns true if the order is successfully restored, false otherwise.
     */
    public function restore($id)
    {
     // Find the order with the given ID
     $order = Order::withTrashed()->findOrFail($id);
    
     // Restore the order and return the result
     return $order->restore();
    }
}
