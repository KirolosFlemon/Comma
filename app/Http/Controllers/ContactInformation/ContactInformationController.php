<?php

// app/Http/Controllers/ContactInformationController.php
namespace App\Http\Controllers\ContactInformation;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactInformation\ContactInformationRequest;
use App\Http\Resources\ContactInformation\ContactInformationResource;
use App\Services\ContactInformation\ContactInformationService;

/**
 * Class ContactInformationController
 * @package App\Http\Controllers\ContactInformation
 */
class ContactInformationController extends Controller
{
    /**
     * @var ContactInformationService
     */
    protected $contactInformationService;

    /**
     * ContactInformationController constructor.
     * @param ContactInformationService $contactInformationService
     */
    public function __construct(ContactInformationService $contactInformationService)
    {
        $this->contactInformationService = $contactInformationService;
    }

    /**
     * Get contactInformation by id
     * @param $id
     * @return ContactInformationResource
     */
    public function get($id)
    {
        $contactInformations = $this->contactInformationService->getContactInformationById($id);
        return new ContactInformationResource($contactInformations);
    }

    /**
     * Get all contactInformations
     *
     * @param ContactInformationRequest $request
     * @return ContactInformationResource
     */
    public function all(ContactInformationRequest $request)
    {
        $contactInformations = $this->contactInformationService->getAllContactInformations($request->is_paginate ?? 0);
        if (isset($request->is_paginate) && $request->is_paginate != 0) {
            return ContactInformationResource::collection($contactInformations);
        }
        
        return ContactInformationResource::collection($contactInformations);
    }

    /**
     * Create new contactInformation
     * @param ContactInformationRequest $request
     * @return ContactInformationResource
     */
    public function create(ContactInformationRequest $request)
    {
        $contactInformation = $this->contactInformationService->createContactInformation($request);

        return new ContactInformationResource($contactInformation);
    }

    /**
     * Update contactInformation
     * @param ContactInformationRequest $request
     * @param $id
     * @return ContactInformationResource
     */
    public function update(ContactInformationRequest $request, $id)
    {
        $contactInformation =  $this->contactInformationService->updateContactInformation($id, $request);
        return new ContactInformationResource($contactInformation->load('city','user'));
    }

    /**
     * Delete contactInformation
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $this->contactInformationService->deleteContactInformation($id);
        return response()->json([
            'Message' => 'success.',
            'data' => 'Contact Information deleted successfully.',
        ], 200);
    }
    

    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function getSoftDeleted()
    {
        $contactInformation = $this->contactInformationService->getSoftDeleted();
        return  ContactInformationResource::collection($contactInformation);
    }
    /**
     * A description of the entire PHP function.
     *
     * @param datatype $paramname description
     * @throws Some_Exception_Class description of exception
     * @return Some_Return_Value
     */
    public function restore($id)
    {
        $this->contactInformationService->restore($id);
        return response()->json([
            'data' => 'Contact Information restored successfully.',
            'Message' => 'success.',
        ], 200);
    }
}

