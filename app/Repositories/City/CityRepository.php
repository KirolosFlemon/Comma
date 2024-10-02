<?php

// app/Repositories/CityRepository.php
namespace App\Repositories\City;

use App\Models\City;

class CityRepository
{
    /**
     * Retrieve all cities with optional pagination.
     *
     * @throws \Exception If pagination parameter is invalid.
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function all($is_paginate)
    {
        if (isset($is_paginate) && $is_paginate != 0) {
            return City::paginate($is_paginate);
        }
        return City::all();
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
        return City::create($request->all());
    }

    /**
     * Retrieves a city by its ID.
     *
     * @param int $id The ID of the city to retrieve.
     * @throws ModelNotFoundException If the city with the given ID is not found.
     * @return City The city model instance.
     */
    public function find($id)
    {
        return City::findOrFail($id);
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function update($id, $request)
    {
        $city = $this->find($id);
        $city->update($request->all());
        return $city;
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function delete($id)
    {
        $city = $this->find($id);
        $city->delete();
    }

         /**
     * Retrieves soft deleted records from the city repository.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator Paginated city of soft deleted records.
     */
    public function getSoftDeleted()
    {
        // Retrieve soft deleted records from the city repository.
        // Only retrieves 15 records at a time.
        return City::onlyTrashed()->paginate(15);
    }

    /**
     * Restores a soft deleted city.
     *
     * @param int $id The ID of the city to restore.
     * @throws ModelNotFoundException if the city with the given ID is not found.
     * @return bool Returns true if the city is successfully restored, false otherwise.
     */
    public function restore($id)
    {
     // Find the city with the given ID
     $city = City::withTrashed()->findOrFail($id);
    
     // Restore the city and return the result
     return $city->restore();
    }
}
