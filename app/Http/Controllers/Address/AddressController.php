<?php

// app/Http/Controllers/AddressController.php
namespace App\Http\Controllers\Address;

use App\Http\Controllers\Controller;
use App\Http\Requests\Address\AddressRequest;
use App\Http\Resources\Address\AddressResource;
use App\Services\Address\AddressService;

/**
 * Class AddressController
 * @package App\Http\Controllers\Address
 */
class AddressController extends Controller
{
    /**
     * @var AddressService
     */
    protected $addressService;

    /**
     * AddressController constructor.
     * @param AddressService $addressService
     */
    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    /**
     * Get address by id
     * @param $id
     * @return AddressResource
     */
    public function get($id)
    {
        $addresses = $this->addressService->getAddressById($id);
        return new AddressResource($addresses->load('city','user'));
    }

    /**
     * Get all addresses
     *
     * @param AddressRequest $request
     * @return AddressResource
     */
    public function all(AddressRequest $request)
    {
        $addresses = $this->addressService->getAllAddresses($request->is_paginate ?? 0);
        if (isset($request->is_paginate) && $request->is_paginate != 0) {
            return AddressResource::collection($addresses);
        }
        
        return AddressResource::collection($addresses);
    }

    /**
     * Create new address
     * @param AddressRequest $request
     * @return AddressResource
     */
    public function create(AddressRequest $request)
    {
        $address = $this->addressService->createAddress($request);

        return new AddressResource($address);
    }

    /**
     * Update address
     * @param AddressRequest $request
     * @param $id
     * @return AddressResource
     */
    public function update(AddressRequest $request, $id)
    {
        $address =  $this->addressService->updateAddress($id, $request);
        return new AddressResource($address->load('city','user'));
    }

    /**
     * Delete address
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $this->addressService->deleteAddress($id);
        return response()->json([
            'Message' => 'success.',
            'data' => 'Address deleted successfully.',
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
        $address = $this->addressService->getSoftDeleted();
        return  AddressResource::collection($address);
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
        $this->addressService->restore($id);
        return response()->json([
            'data' => 'Collection restored successfully.',
            'Message' => 'success.',
        ], 200);
    }
}

