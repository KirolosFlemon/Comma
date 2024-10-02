<?php

// app/Repositories/AddressRepository.php
namespace App\Repositories\Address;

use App\Models\Address;

class AddressRepository
{
    public function all($is_paginate)
    {
        if (isset($is_paginate) && $is_paginate != 0) {
            return Address::with('city','user')->paginate($is_paginate);
        }
        return Address::with('city','user')->get();
    }

    public function create($request)
    {
        return Address::create($request);
    }

    public function find($id)
    {
        return Address::findOrFail($id);
    }

    public function update($id, $request)
    {
        $address = $this->find($id);
        $address->update($request);
        return $address;
    }

    public function delete($id)
    {
        $address = $this->find($id);
        $address->delete();
    }
    
     /**
     * Retrieves soft deleted records from the address repository.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator Paginated address of soft deleted records.
     */
    public function getSoftDeleted()
    {
        // Retrieve soft deleted records from the address repository.
        // Only retrieves 15 records at a time.
        return Address::onlyTrashed()->paginate(15);
    }

    /**
     * Restores a soft deleted address.
     *
     * @param int $id The ID of the address to restore.
     * @throws ModelNotFoundException if the address with the given ID is not found.
     * @return bool Returns true if the address is successfully restored, false otherwise.
     */
    public function restore($id)
    {
     // Find the address with the given ID
     $address = Address::withTrashed()->findOrFail($id);
    
     // Restore the address and return the result
     return $address->restore();
    }
}
