<?php
// app/Services/ContactInformationService.php
namespace App\Services\ContactInformation;

use App\Repositories\ContactInformation\ContactInformationRepository;
use App\Traits\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactInformationService
{
    protected $contactInformationRepository;

    /**
     * Constructor function to initialize the repository
     *
     * @param ContactInformationRepository $contactInformationRepository The contactInformation repository
     */
    public function __construct(ContactInformationRepository $contactInformationRepository)
    {
        $this->contactInformationRepository = $contactInformationRepository;
    }

    /**
     * Fetch all contactInformations
     *
     * @return array The list of contactInformations
     */
    public function getAllContactInformations($is_paginate)
    {
        return $this->contactInformationRepository->all($is_paginate);
    }

    /**
     * Create a new contactInformation
     *
     * @param Request $request The request containing the contactInformation details
     * @return ContactInformation The newly created contactInformation
     */
    public function createContactInformation(Request $request)
    {
        try {
            DB::beginTransaction();
            $contactInformation =  $this->contactInformationRepository->create($request->all());

            // Commit the transaction if all operations are successful
            DB::commit();
            return $contactInformation;
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Fetch an contactInformation by its ID
     *
     * @param int $id The ID of the contactInformation
     * @return ContactInformation The contactInformation corresponding to the ID
     */
    public function getContactInformationById($id)
    {
        return $this->contactInformationRepository->find($id);
    }

    /**
     * Update an existing contactInformation
     *
     * @param int $id The ID of the contactInformation
     * @param Request $request The request containing the updated details
     * @return ContactInformation The updated contactInformation
     */
    public function updateContactInformation($id, $request)
    {
        try {
            DB::beginTransaction();
            $contactInformation = $this->contactInformationRepository->update($id, $request->all());
       
            // Commit the transaction if all operations are successful
            DB::commit();
            return $contactInformation->load('city','user');
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Delete an contactInformation by its ID
     *
     * @param int $id The ID of the contactInformation
     * @return void
     */
    public function deleteContactInformation($id)
    {
        $this->contactInformationRepository->delete($id);
    }

    /**
     * Retrieves soft deleted records from the contactInformation repository.
     *
     * @return Some_Return_Value
     */
    public function getSoftDeleted()
    {
        return $this->contactInformationRepository->getSoftDeleted();
    }



    /**
     * Restores a soft deleted contactInformation by its ID.
     *
     * @param int $id The ID of the contactInformation to restore.
     * @return void
     */
    public function restore($id)
    {
        // Call the restore method on the contactInformation repository
        // to restore the soft deleted contactInformation.
        return $this->contactInformationRepository->restore($id);
    }

}

