<?php
// app/Services/SizeService.php
namespace App\Services\Size;

use App\Repositories\Size\SizeRepository;
use App\Traits\HelperFunctions;
use Illuminate\Support\Facades\DB;

class SizeService
{
    protected $sizeRepository;

    public function __construct(SizeRepository $sizeRepository)
    {
        $this->sizeRepository = $sizeRepository;
    }

    /**
     * Retrieve all sizes
     *
     * @param bool $is_paginate
     * @return mixed
     */
    public function getAllSizes($is_paginate)
    {
        return $this->sizeRepository->all($is_paginate);
    }

    /**
     * Create a new size
     *
     * @param $request
     * @return mixed
     * @throws \Exception
     */
    public function createSize($request)
    {
        try {
            DB::beginTransaction();
            $size =  $this->sizeRepository->create($request->except('images'));

            // Commit the transaction if all operations are successful
            DB::commit();
            return $size;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Retrieve size by id
     *
     * @param $id
     * @return mixed
     */
    public function getSizeById($id)
    {
        return $this->sizeRepository->find($id);
    }

    /**
     * Update size by id
     *
     * @param $id
     * @param $request
     * @return mixed
     * @throws \Exception
     */
    public function updateSize($id, $request)
    {
        try {

            DB::beginTransaction();

            $size = $this->sizeRepository->update($id, $request->except('images'));

            // Commit the transaction if all operations are successful
            DB::commit();
            return $size;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Delete size by id
     *
     * @param $id
     */
    public function deleteSize($id)
    {
        $this->sizeRepository->delete($id);
    }

        /**
     * Retrieves soft deleted records from the size repository.
     *
     * @return Some_Return_Value
     */
    public function getSoftDeleted()
    {
        return $this->sizeRepository->getSoftDeleted();
    }

    /**
     * Restores a soft deleted size by its ID.
     *
     * @param int $id The ID of the size to restore.
     * @return void
     */
    public function restore($id)
    {
        // Call the restore method on the size repository
        // to restore the soft deleted size.
        return $this->sizeRepository->restore($id);
    }
}

