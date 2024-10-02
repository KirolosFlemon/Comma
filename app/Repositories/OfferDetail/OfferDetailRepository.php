<?php

// app/Repositories/OfferDetailRepository.php
namespace App\Repositories\OfferDetail;

use App\Models\Offer;
use App\Models\OfferDetail;

class OfferDetailRepository
{
    public function all($is_paginate)
    {
        if (isset($is_paginate) && $is_paginate != 0) {
            return offer::with('details')->paginate($is_paginate);
        }
        return offer::with('details')->get();
    }

    public function create($request,$id)
    {
        $offer =  Offer::findOrFail($id);
        if ($request['product_id']) {
            $offerDetail = $offer->details()->create(['detailable_type' => 'App\Models\Product', 'detailable_id' => $request['product_id']]);
        } elseif ($request['collection_id']) {
            $offerDetail = $offer->details()->create([
                'detailable_type' => 'App\Models\Collection',
                'detailable_id' => $request['collection_id']
            ]);
        } else {
            $offerDetail = null;
        }
        return $offer->load('details');
    }

    public function find($id)
    {
        return Offer::findOrFail($id);
    }

    public function update($id, $request)
    {
        $offer =  Offer::findOrFail($id);
        $offer->details()->sync($request);
        return $offer;
    }

    public function delete($id)
    {
        $offer = $this->find($id);
        $offer->delete();
    }
    
     /**
     * Retrieves soft deleted records from the OfferDetail repository.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator Paginated OfferDetail of soft deleted records.
     */
    public function getSoftDeleted()
    {
        // Retrieve soft deleted records from the OfferDetail repository.
        // Only retrieves 15 records at a time.
        return offer::onlyTrashed()->paginate(15);
    }

    /**
     * Restores a soft deleted OfferDetail.
     *
     * @param int $id The ID of the OfferDetail to restore.
     * @throws ModelNotFoundException if the OfferDetail with the given ID is not found.
     * @return bool Returns true if the OfferDetail is successfully restored, false otherwise.
     */
    public function restore($id)
    {
     // Find the OfferDetail with the given ID
     $offer = offer::withTrashed()->findOrFail($id);
    
     // Restore the OfferDetail and return the result
     return $offer->restore();
    }
}
