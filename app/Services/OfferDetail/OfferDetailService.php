<?php
// app/Services/OfferDetailService.php
namespace App\Services\OfferDetail;

use App\Repositories\OfferDetail\OfferDetailRepository;
use App\Traits\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferDetailService
{
    protected $offerDetailRepository;

    /**
     * Constructor function to initialize the repository
     *
     * @param OfferDetailRepository $offerDetailRepository The offerDetail repository
     */
    public function __construct(OfferDetailRepository $offerDetailRepository)
    {
        $this->offerDetailRepository = $offerDetailRepository;
    }

    /**
     * Fetch all offerDetails
     *
     * @return array The list of offerDetails
     */
    public function getAllOfferDetails($is_paginate)
    {
        return $this->offerDetailRepository->all($is_paginate);
    }

    /**
     * Create a new offerDetail
     *
     * @param Request $request The request containing the offerDetail details
     * @return OfferDetail The newly created offerDetail
     */
    public function createOfferDetail(Request $request,$id)
    {
        try {
            DB::beginTransaction();

            $offerDetail =  $this->offerDetailRepository->create($request->all(),$id);

            // Commit the transaction if all operations are successful
            DB::commit();
            return $offerDetail;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Fetch an offerDetail by its ID
     *
     * @param int $id The ID of the offerDetail
     * @return OfferDetail The offerDetail corresponding to the ID
     */
    public function getOfferDetailById($id)
    {
        return $this->offerDetailRepository->find($id);
    }

    /**
     * Update an existing offerDetail
     *
     * @param int $id The ID of the offerDetail
     * @param Request $request The request containing the updated details
     * @return OfferDetail The updated offerDetail
     */
    public function updateOfferDetail($id, $request)
    {
        try {

            DB::beginTransaction();

            $offerDetail = $this->offerDetailRepository->update($id, $request->all());
       
            // Commit the transaction if all operations are successful
            DB::commit();
            return $offerDetail->load('city','user');
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Delete an offerDetail by its ID
     *
     * @param int $id The ID of the offerDetail
     * @return void
     */
    public function deleteOfferDetail($id)
    {
        $this->offerDetailRepository->delete($id);
    }

    /**
     * Retrieves soft deleted records from the offerDetail repository.
     *
     * @return Some_Return_Value
     */
    public function getSoftDeleted()
    {
        return $this->offerDetailRepository->getSoftDeleted();
    }



    /**
     * Restores a soft deleted offerDetail by its ID.
     *
     * @param int $id The ID of the offerDetail to restore.
     * @return void
     */
    public function restore($id)
    {
        // Call the restore method on the offerDetail repository
        // to restore the soft deleted offerDetail.
        return $this->offerDetailRepository->restore($id);
    }

}

