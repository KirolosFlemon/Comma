<?php
// app/Services/MaterialService.php
namespace App\Services\Material;

use App\Repositories\Material\MaterialRepository;
use App\Traits\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MaterialService
{
    protected $materialRepository;

    public function __construct(MaterialRepository $materialRepository)
    {
        $this->materialRepository = $materialRepository;
    }

    /**
     * Retrieve all materials.
     *
     * @param bool $is_paginate Whether to paginate the results or not.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllMaterials($is_paginate)
    {
        return $this->materialRepository->all($is_paginate);
    }

    /**
     * Create a new material.
     *
     * @param \Illuminate\Http\Request $request The request containing the material data.
     * @return \App\Models\Material The newly created material.
     * @throws \Exception If an error occurs during material creation.
     */
    public function createMaterial(Request $request)
    {
        try {
            DB::beginTransaction();
            $material =  $this->materialRepository->create($request);
           
            // Commit the transaction if all operations are successful
            DB::commit();
            return $material;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Retrieve a material by its ID.
     *
     * @param int $id The ID of the material.
     * @return \App\Models\Material|null The material with the given ID, or null if not found.
     */
    public function getMaterialById($id)
    {
        return $this->materialRepository->find($id);
    }

    /**
     * Update a material with the given ID.
     *
     * @param int $id The ID of the material to update.
     * @param \Illuminate\Http\Request $request The request containing the updated material data.
     * @return \App\Models\Material The updated material.
     * @throws \Exception If an error occurs during material update.
     */
    public function updateMaterial($id, $request)
    {
        try {

            DB::beginTransaction();

            $material = $this->materialRepository->update($id, $request->all());
            // Commit the transaction if all operations are successful
            DB::commit();
            return $material;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Delete a material with the given ID.
     *
     * @param int $id The ID of the material to delete.
     * @return void
     */
    public function deleteMaterial($id)
    {
        $this->materialRepository->delete($id);
    }
    
     /**
     * Retrieves soft deleted records from the material repository.
     *
     * @return Some_Return_Value
     */
    public function getSoftDeleted()
    {
        return $this->materialRepository->getSoftDeleted();
    }

    /**
     * Restores a soft deleted material by its ID.
     *
     * @param int $id The ID of the material to restore.
     * @return void
     */
    public function restore($id)
    {
        // Call the restore method on the material repository
        // to restore the soft deleted material.
        return $this->materialRepository->restore($id);
    }
}

