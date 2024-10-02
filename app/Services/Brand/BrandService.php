<?php
// app/Services/BrandService.php
namespace App\Services\Brand;

use App\Repositories\Brand\BrandRepository;
use App\Traits\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BrandService
{
    protected $brandRepository;

    /**
     * Constructor for BrandService class.
     *
     * @param BrandRepository $brandRepository The brand repository instance
     * @throws \Exception if an error occurs during instantiation
     * @return void
     */
    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    /**
     * Retrieves all brands based on pagination flag.
     *
     * @param mixed $is_paginate Flag to determine pagination
     * @return mixed Result of retrieving all brands
     */
    public function getAllBrands($is_paginate)
    {
        return $this->brandRepository->all($is_paginate);
    }

    /**
     * Create a new brand with the provided request data.
     *
     * @throws \Exception if an error occurs during brand creation
     * @return Brand The newly created brand with images loaded
     */
    public function createBrand($request)
    {

        try {
            DB::beginTransaction();

            $brand = $this->brandRepository->create($request->except('images'));
    
            if ($request->has('images')) {
                foreach ($request->images as $image) {
                    $brand->images()->create(['image' => $image]);
                }
            }

            DB::commit();
            return $brand->load('images');
        } catch (\Throwable $th) {
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Retrieves a specific brand by its ID.
     *
     * @param int $id The ID of the brand to retrieve.
     * @throws ModelNotFoundException if the brand with the given ID is not found.
     * @return Brand The brand object with the specified ID.
     */
    public function getBrandById($id)
    {
        return $this->brandRepository->find($id);
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function updateBrand($id, Request $request)
    {
        try {

            DB::beginTransaction();

            $brand = $this->brandRepository->update($id, $request->except('images'));
            $brand->images()->delete();

            if ($request->images) {
                foreach ($request->images as $image) {
                    $brand->images()->create(['image' => $image]);
                }
            }
            // Commit the transaction if all operations are successful
            DB::commit();
            return $brand;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function deleteBrand($id)
    {
        $this->brandRepository->delete($id);
    }
    
    /**
     * Retrieves soft deleted records from the brand repository.
     *
     * @return Some_Return_Value
     */
    public function getSoftDeleted()
    {
        return $this->brandRepository->getSoftDeleted();
    }



    /**
     * Restores a soft deleted brand by its ID.
     *
     * @param int $id The ID of the brand to restore.
     * @return void
     */
    public function restore($id)
    {
        // Call the restore method on the brand repository
        // to restore the soft deleted brand.
        return $this->brandRepository->restore($id);
    }
}
