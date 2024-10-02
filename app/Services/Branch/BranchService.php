<?php
// app/Services/BranchService.php
namespace App\Services\Branch;

use App\Repositories\Branch\BranchRepository;
use App\Traits\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BranchService
{
    protected $branchRepository;

    public function __construct(BranchRepository $branchRepository)
    {
        $this->branchRepository = $branchRepository;
    }

    /**
     * Retrieves all branches with pagination if specified.
     *
     * @param mixed $is_paginate Indicates if pagination is required.
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Collection The collection of branches.
     */
    public function getAllBranches($is_paginate)
    {
        return $this->branchRepository->all($is_paginate);
    }

    /**
     * A description of the entire PHP function.
     * 
     * @param Request $request 
     * @throws \Exception if an error occurs during branch creation
     * @return Branch The created branch object.
     */
    public function createBranch(Request $request)
    {
        try {
            DB::beginTransaction();

            $branch =  $this->branchRepository->create($request);
            // Commit the transaction if all operations are successful
            DB::commit();
            return $branch;
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
    public function getBranchById($id)
    {
        return $this->branchRepository->find($id);
    }

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function updateBranch($id, $request)
    {
        try {

            DB::beginTransaction();

            $branch = $this->branchRepository->update($id, $request);

            // Commit the transaction if all operations are successful
            DB::commit();
            return $branch;
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
    public function deleteBranch($id)
    {
        $this->branchRepository->delete($id);
    }

    /**
     * Retrieves soft deleted records from the branch repository.
     *
     * @return Some_Return_Value
     */
    public function getSoftDeleted()
    {
        return $this->branchRepository->getSoftDeleted();
    }



    /**
     * Restores a soft deleted branch by its ID.
     *
     * @param int $id The ID of the branch to restore.
     * @return void
     */
    public function restore($id)
    {
        // Call the restore method on the branch repository
        // to restore the soft deleted branch.
        return $this->branchRepository->restore($id);
    }
}
