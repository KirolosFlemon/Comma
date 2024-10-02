<?php

// app/Repositories/CouponRepository.php
namespace App\Repositories\Coupon;

use App\Models\Coupon;

class CouponRepository
{
    public function all($is_paginate)
    {
        if (isset($is_paginate) && $is_paginate != 0) {
            return Coupon::with('users')->paginate($is_paginate);
        }
        return Coupon::with('user')->get();
    }

    public function create($request)
    {
        $coupon = Coupon::create([
            'code' => $request['code'],
            'type' => $request['type'],
            'value' => $request['value'],
            'all_users' => $request['all_users'],
        ]);

        if ($request['all_users'] == 0 && $request['user_id']) {
            foreach ($request['user_id'] as $user_id) {
                $coupon->users()->attach($user_id, ['no_used_times' => $request['no_used_times']]);
            }
        }
        return $coupon->load('users');
    }

    public function find($id)
    {
        return Coupon::with('users')->findOrFail($id);
    }

    public function update($id, $request)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->update([
            'code' => $request['code'],
            'type' => $request['type'],
            'value' => $request['value'],
            'all_users' => $request['all_users'],
        ]);

        if ($request['all_users'] == 0 && $request['user_id']) {
            $coupon->users()->sync($request['user_id']);
        }
        return $coupon->load('users');
    }

    public function delete($id)
    {
        $coupon = $this->find($id);
        $coupon->delete();
    }
    
     /**
     * Retrieves soft deleted records from the coupon repository.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator Paginated coupon of soft deleted records.
     */
    public function getSoftDeleted()
    {
        // Retrieve soft deleted records from the coupon repository.
        // Only retrieves 15 records at a time.
        return Coupon::onlyTrashed()->paginate(15);
    }

    /**
     * Restores a soft deleted coupon.
     *
     * @param int $id The ID of the coupon to restore.
     * @throws ModelNotFoundException if the coupon with the given ID is not found.
     * @return bool Returns true if the coupon is successfully restored, false otherwise.
     */
    public function restore($id)
    {
     // Find the coupon with the given ID
     $coupon = Coupon::withTrashed()->findOrFail($id);
    
     // Restore the coupon and return the result
     return $coupon->restore();
    }

    public function findByCode($code)
    {
        return Coupon::where('code',$code)->first();
    }
}
