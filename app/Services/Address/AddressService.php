<?php
// app/Services/AddressService.php
namespace App\Services\Address;

use App\Repositories\Address\AddressRepository;
use App\Traits\HelperFunctions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressService
{
    protected $addressRepository;

    /**
     * Constructor function to initialize the repository
     *
     * @param AddressRepository $addressRepository The address repository
     */
    public function __construct(AddressRepository $addressRepository)
    {
        $this->addressRepository = $addressRepository;
    }

    /**
     * Fetch all addresses
     *
     * @return array The list of addresses
     */
    public function getAllAddresses($is_paginate)
    {
        return $this->addressRepository->all($is_paginate);
    }

    /**
     * Create a new address
     *
     * @param Request $request The request containing the address details
     * @return Address The newly created address
     */
    public function createAddress(Request $request)
    {
        try {
            DB::beginTransaction();

            $address =  $this->addressRepository->create($request->all());

            // Commit the transaction if all operations are successful
            DB::commit();
            return $address->load('city','user');
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Fetch an address by its ID
     *
     * @param int $id The ID of the address
     * @return Address The address corresponding to the ID
     */
    public function getAddressById($id)
    {
        return $this->addressRepository->find($id);
    }

    /**
     * Update an existing address
     *
     * @param int $id The ID of the address
     * @param Request $request The request containing the updated details
     * @return Address The updated address
     */
    public function updateAddress($id, $request)
    {
        try {

            DB::beginTransaction();

            $address = $this->addressRepository->update($id, $request->all());
       
            // Commit the transaction if all operations are successful
            DB::commit();
            return $address->load('city','user');
        } catch (\Throwable $th) {
            // Roll back the transaction if any operation fails
            DB::rollback();
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Delete an address by its ID
     *
     * @param int $id The ID of the address
     * @return void
     */
    public function deleteAddress($id)
    {
        $this->addressRepository->delete($id);
    }

    /**
     * Retrieves soft deleted records from the address repository.
     *
     * @return Some_Return_Value
     */
    public function getSoftDeleted()
    {
        return $this->addressRepository->getSoftDeleted();
    }



    /**
     * Restores a soft deleted address by its ID.
     *
     * @param int $id The ID of the address to restore.
     * @return void
     */
    public function restore($id)
    {
        // Call the restore method on the address repository
        // to restore the soft deleted address.
        return $this->addressRepository->restore($id);
    }

}

