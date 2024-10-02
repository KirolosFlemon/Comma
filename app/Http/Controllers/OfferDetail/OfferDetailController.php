<?php

// app/Http/Controllers/OfferDetailController.php
namespace App\Http\Controllers\OfferDetail;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfferDetail\OfferDetailRequest;
use App\Http\Resources\OfferDetail\OfferDetailResource;
use App\Services\OfferDetail\OfferDetailService;

/**
 * Class OfferDetailController
 * @package App\Http\Controllers\OfferDetail
 */
class OfferDetailController extends Controller
{
    /**
     * @var OfferDetailService
     */
    protected $offerDetailService;

    /**
     * OfferDetailController constructor.
     * @param OfferDetailService $offerDetailService
     */
    public function __construct(OfferDetailService $offerDetailService)
    {
        $this->offerDetailService = $offerDetailService;
    }

    /**
     * Get offerDetail by id
     * @param $id
     * @return OfferDetailResource
     */
    public function get($id)
    {
        $offerDetails = $this->offerDetailService->getOfferDetailById($id);
        return new OfferDetailResource($offerDetails);
    }

    /**
     * Get all offerDetails
     *
     * @param OfferDetailRequest $request
     * @return OfferDetailResource
     */
    public function all(OfferDetailRequest $request)
    {
        $offerDetails = $this->offerDetailService->getAllOfferDetails($request->is_paginate ?? 0);
        if (isset($request->is_paginate) && $request->is_paginate != 0) {
            return OfferDetailResource::collection($offerDetails);
        }
        
        return OfferDetailResource::collection($offerDetails);
    }

    /**
     * Create new offerDetail
     * @param OfferDetailRequest $request
     * @return OfferDetailResource
     */
    public function create(OfferDetailRequest $request,$id)
    {
        $offerDetail = $this->offerDetailService->createOfferDetail($request,$id);

        return new OfferDetailResource($offerDetail);
    }

    /**
     * Update offerDetail
     * @param OfferDetailRequest $request
     * @param $id
     * @return OfferDetailResource
     */
    public function update(OfferDetailRequest $request, $id)
    {
        $offerDetail =  $this->offerDetailService->updateOfferDetail($id, $request);
        return new OfferDetailResource($offerDetail);
    }

    /**
     * Delete offerDetail
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $this->offerDetailService->deleteOfferDetail($id);
        return response()->json([
            'Message' => 'success.',
            'data' => 'OfferDetail deleted successfully.',
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
        $offerDetail = $this->offerDetailService->getSoftDeleted();
        return  OfferDetailResource::collection($offerDetail);
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
        $this->offerDetailService->restore($id);
        return response()->json([
            'data' => 'Collection restored successfully.',
            'Message' => 'success.',
        ], 200);
    }
}

