<?php
// app/Services/CityService.php
namespace App\Services\City;

use App\Repositories\City\CityRepository;
use App\Traits\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CityService
{
    protected $cityRepository;

    /**
     * Constructor for CityService class.
     *
     * @param CityRepository $cityRepository The city repository instance.
     * @throws \Exception If unable to instantiate CityService.
     * @return void
     */
    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * Retrieves all cities with optional pagination.
     *
     * @param mixed $is_paginate Indicates if pagination is required.
     * @return \Illuminate\Database\Eloquent\Collection The collection of cities.
     */
    public function getAllCities($is_paginate)
    {
        return $this->cityRepository->all($is_paginate);
    }

    /**
     * Creates a new city based on the provided request data.
     *
     * @param mixed $request The request data for creating the city.
     * @throws \Exception If an error occurs during city creation.
     * @return City The newly created city with images loaded.
     */
    public function createCity(Request $request)
    {
        try {
            DB::beginTransaction();
            $city =  $this->cityRepository->create($request);
     
            // Commit the transaction if all operations are successful
            DB::commit();
            return $city;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Retrieves a specific city by its ID.
     *
     * @param int $id The ID of the city to retrieve.
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function getCityById($id)
    {
        return $this->cityRepository->find($id);
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function updateCity($id, $request)
    {
        try {

            DB::beginTransaction();

            $city = $this->cityRepository->update($id, $request);
            // Commit the transaction if all operations are successful
            DB::commit();
            return $city;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $id description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function deleteCity($id)
    {
        $this->cityRepository->delete($id);
    }

    /**
     * Retrieves soft deleted records from the city repository.
     *
     * @return Some_Return_Value
     */
    public function getSoftDeleted()
    {
        return $this->cityRepository->getSoftDeleted();
    }



    /**
     * Restores a soft deleted city by its ID.
     *
     * @param int $id The ID of the city to restore.
     * @return void
     */
    public function restore($id)
    {
        // Call the restore method on the city repository
        // to restore the soft deleted city.
        return $this->cityRepository->restore($id);
    }
}
