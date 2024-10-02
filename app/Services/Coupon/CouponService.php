<?php
// app/Services/CouponService.php
namespace App\Services\Coupon;

use App\Repositories\Coupon\CouponRepository;
use App\Traits\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponService
{
    protected $couponRepository;

    /**
     * Constructor function to initialize the repository
     *
     * @param CouponRepository $couponRepository The coupon repository
     */
    public function __construct(CouponRepository $couponRepository)
    {
        $this->couponRepository = $couponRepository;
    }

    /**
     * Fetch all coupons
     *
     * @return array The list of coupons
     */
    public function getAllCoupons($is_paginate)
    {
        return $this->couponRepository->all($is_paginate);
    }

    /**
     * Create a new coupon
     *
     * @param Request $request The request containing the coupon details
     * @return Coupon The newly created coupon
     */
    public function createCoupon(Request $request)
    {
        try {
            DB::beginTransaction();

            $coupon =  $this->couponRepository->create($request->all());

            // Commit the transaction if all operations are successful
            DB::commit();
            return $coupon;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Fetch an coupon by its ID
     *
     * @param int $id The ID of the coupon
     * @return Coupon The coupon corresponding to the ID
     */
    public function getCouponById($id)
    {
        return $this->couponRepository->find($id);
    }


    
    /**
     * Update an existing coupon
     *
     * @param int $id The ID of the coupon
     * @param Request $request The request containing the updated details
     * @return Coupon The updated coupon
     */
    public function updateCoupon($id, $request)
    {
        try {

            DB::beginTransaction();

            $coupon = $this->couponRepository->update($id, $request->all());
       
            // Commit the transaction if all operations are successful
            DB::commit();
            return $coupon;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Delete an coupon by its ID
     *
     * @param int $id The ID of the coupon
     * @return void
     */
    public function deleteCoupon($id)
    {
        $this->couponRepository->delete($id);
    }

    /**
     * Retrieves soft deleted records from the coupon repository.
     *
     * @return Some_Return_Value
     */
    public function getSoftDeleted()
    {
        return $this->couponRepository->getSoftDeleted();
    }



    /**
     * Restores a soft deleted coupon by its ID.
     *
     * @param int $id The ID of the coupon to restore.
     * @return void
     */
    public function restore($id)
    {
        // Call the restore method on the coupon repository
        // to restore the soft deleted coupon.
        return $this->couponRepository->restore($id);
    }
    public function getCouponByCode($code)
    {
        return $this->couponRepository->findByCode($code);
    }
}

