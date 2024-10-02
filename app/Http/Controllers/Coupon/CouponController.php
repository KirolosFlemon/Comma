<?php

// app/Http/Controllers/CouponController.php
namespace App\Http\Controllers\Coupon;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coupon\CouponRequest;
use App\Http\Resources\Coupon\CouponResource;
use App\Services\Coupon\CouponService;
use Illuminate\Http\Request;

/**
 * Class CouponController
 * @package App\Http\Controllers\Coupon
 */
class CouponController extends Controller
{
    /**
     * @var CouponService
     */
    protected $couponService;

    /**
     * CouponController constructor.
     * @param CouponService $couponService
     */
    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    /**
     * Get coupon by id
     * @param $id
     * @return CouponResource
     */
    public function get($id)
    {
        $coupons = $this->couponService->getCouponById($id);
        return new CouponResource($coupons);
    }

    /**
     * Get all coupons
     *
     * @param CouponRequest $request
     * @return CouponResource
     */
    public function all(CouponRequest $request)
    {
        $coupons = $this->couponService->getAllCoupons($request->is_paginate ?? 0);
        if (isset($request->is_paginate) && $request->is_paginate != 0) {
            return CouponResource::collection($coupons);
        }
        
        return CouponResource::collection($coupons);
    }

    /**
     * Create new coupon
     * @param CouponRequest $request
     * @return CouponResource
     */
    public function create(CouponRequest $request)
    {
        $coupon = $this->couponService->createCoupon($request);

        return new CouponResource($coupon);
    }

    /**
     * Update coupon
     * @param CouponRequest $request
     * @param $id
     * @return CouponResource
     */
    public function update(CouponRequest $request, $id)
    {
        $coupon =  $this->couponService->updateCoupon($id, $request);
        return new CouponResource($coupon);
    }

    /**
     * Delete coupon
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $this->couponService->deleteCoupon($id);
        return response()->json([
            'Message' => 'success.',
            'data' => 'Coupon deleted successfully.',
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
        $coupon = $this->couponService->getSoftDeleted();
        return  CouponResource::collection($coupon);
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
        $this->couponService->restore($id);
        return response()->json([
            'data' => 'Coupon restored successfully.',
            'Message' => 'success.',
        ], 200);
    }


    public function getCouponByCode(Request $request)
    {
        $coupons = $this->couponService->getCouponByCode($request->code);
        return new CouponResource($coupons);
    }

}

