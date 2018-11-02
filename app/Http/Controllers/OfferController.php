<?php

namespace App\Http\Controllers;

use App\Offers;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function create(Request $request)
    {

        $inputs = $request->all();

        $newOffer = Offers::create($inputs);

        return response()->json(['status' => 'success', 'offer' => $newOffer], 200);

    }

    public function getOffer($id, Request $request)
    {

        $allOffers = Offers::where('company_id', '=', $id)->get();

        return response()->json(['status' => 'success', 'offers' => $allOffers], 200);

    }

    public function getOfferById($id)
    {

        $offer = Offers::find($id)->get();

        return response()->json(['status' => 'success', 'offers' => $offer], 200);

    }

    public function deleteOffer($id)
    {
        try {
            $offer = Offers::find($id);
            $offer->delete();
            return response()->json(['status' => 'success', 'message' => 'Offer deleted'], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'Error', 'message' => 'Error'], 401);
        }
    }

    public function updateOffer(Request $request)
    {

        try {
            Offers::where('id', $request->get('id'))
                ->update(['name' => $request->get('name'),
                    'description' => $request->get('description'),
                    'time' => $request->get('time'),
                    'price' => $request->get('price')]);

            return response()->json(['status' => 'success', 'message' => 'updated'], 200);

        } catch (\Illuminate\Database\QueryException $ex) {
            return response()->json(['status' => 'Error', 'message' => 'Error'], 401);
        }
    }
}
