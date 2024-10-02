<?php

// app/Repositories/ContactInformationRepository.php
namespace App\Repositories\ContactInformation;

use App\Models\ContactInformation;

class ContactInformationRepository
{
    public function all($is_paginate)
    {
        if (isset($is_paginate) && $is_paginate != 0) {
            return ContactInformation::paginate($is_paginate);
        }
        return ContactInformation::get();
    }

    public function create($request)
    {
        return ContactInformation::create($request);
    }

    public function find($id)
    {
        return ContactInformation::findOrFail($id);
    }

    public function update($id, $request)
    {
        $contactInformation = $this->find($id);
        $contactInformation->update($request);
        return $contactInformation;
    }

    public function delete($id)
    {
        $contactInformation = $this->find($id);
        $contactInformation->delete(); 
    }
    
     /**
     * Retrieves soft deleted records from the contactInformation repository.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator Paginated contactInformation of soft deleted records.
     */
    public function getSoftDeleted()
    {
        // Retrieve soft deleted records from the contactInformation repository.
        // Only retrieves 15 records at a time.
        return ContactInformation::onlyTrashed()->paginate(15);
    }

    /**
     * Restores a soft deleted contactInformation.
     *
     * @param int $id The ID of the contactInformation to restore.
     * @throws ModelNotFoundException if the contactInformation with the given ID is not found.
     * @return bool Returns true if the contactInformation is successfully restored, false otherwise.
     */
    public function restore($id)
    {
     // Find the contactInformation with the given ID
     $contactInformation = ContactInformation::withTrashed()->findOrFail($id);
    
     // Restore the contactInformation and return the result
     return $contactInformation->restore();
    }
}
