<?php
// app/Services/ColorService.php
namespace App\Services\Color;

use App\Repositories\Color\ColorRepository;
use App\Traits\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ColorService
{
    protected $colorRepository;

    /**
     * Constructs a new ColorService instance.
     *
     * @param ColorRepository $colorRepository The color repository to be injected.
     * @throws None
     * @return None
     */
    public function __construct(ColorRepository $colorRepository)
    {
        $this->colorRepository = $colorRepository;
    }

    /**
     * Retrieves all colors with optional pagination.
     *
     * @param mixed $is_paginate Flag to determine pagination
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function getAllColors($is_paginate)
    {
        return $this->colorRepository->all($is_paginate);
    }

    /**
     * Creates a new color using the provided Request object and returns the created color.
     *
     * @param Request $request The Request object containing the data for the new color.
     * @throws Exception If an error occurs during color creation.
     * @return Color The newly created color object.
     */
    public function createColor(Request $request)
    {
        try {
            DB::beginTransaction();
            $color =  $this->colorRepository->create($request);
            // Commit the transaction if all operations are successful
            DB::commit();
            return $color;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Retrieves a specific collection by its ID.
     *
     * @param int $id The ID of the collection to retrieve.
     * @throws ModelNotFoundException if the collection with the given ID is not found.
     * @return Collection The collection object with the specified ID.
     */
    public function getColorById($id)
    {
        return $this->colorRepository->find($id);
    }

    /**
     * Updates a color with the provided ID and Request object.
     *
     * @param mixed $id The ID of the color to update.
     * @param Request $request The Request object containing the updated color data.
     * @throws \Exception If an error occurs during color update.
     * @return Color The updated Color object.
     */
    public function updateColor($id, Request $request)
    {
        try {

            DB::beginTransaction();

            $color = $this->colorRepository->update($id, $request->except('images'));


            // Commit the transaction if all operations are successful
            DB::commit();
            return $color;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Deletes a color by ID.
     *
     * @param int $id The ID of the color to delete.
     * @throws None
     * @return None
     */
    public function deleteColor($id)
    {
        $this->colorRepository->delete($id);
    }

    /**
     * Retrieves soft deleted records from the color repository.
     *
     * @return Some_Return_Value
     */
    public function getSoftDeleted()
    {
        return $this->colorRepository->getSoftDeleted();
    }



    /**
     * Restores a soft deleted color by its ID.
     *
     * @param int $id The ID of the color to restore.
     * @return void
     */
    public function restore($id)
    {
        // Call the restore method on the color repository
        // to restore the soft deleted color.
        return $this->colorRepository->restore($id);
    }
}
