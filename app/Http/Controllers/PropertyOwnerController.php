<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Property;
use App\Models\Service;
use App\Traits\UserTrait;
use Illuminate\Http\Request;

class PropertyOwnerController extends Controller
{
    use UserTrait;
    //

    public function  getAllServices(Request $request)
    {
        try {
            $services =  Service::all();
            return response()->json(
                [
                    'response' => "success",
                    "data" => $services
                ],
                201
            );
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response' => 'failure', 'message' => $th->getMessage()]);
        }
    }

    public function getAllAmenities(Request $request)
    {
        try {
            $amenities =  Amenity::all();
            return response()->json(
                [
                    'response' => "success",
                    "data" => $amenities
                ],
                201
            );
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response' => 'failure', 'message' => $th->getMessage()]);
        }
    }

    public function getRegisterPropertyByPage(Request $request)
    {
        try {
            //code...
            $limit = $request->input('limit', 100);
            $page = $request->input('page', 1);
            $sortOrder = $request->input('sort_order', 'desc');

            $user_id =  $this->getCurrentLoggedUserBySanctum()->id;

            $property = Property::orderBy('id', $sortOrder)->where('owner_id', $user_id)
                ->with([
                    'agent',
                    'owner',
                    'services',
                    'amenities',
                    'category',
                    'amenityProperties',
                    'propertyServices',
                    'paymentPeriod',
                    'status',
                    'currency'

                ])
                ->paginate($limit, ['*'], 'page', $page);

            $response = [
                "data" => $property->items(),
                "pagination" => [
                    "total" => $property->total(),
                    "current_page" => $property->currentPage(),
                    "last_page" => $property->lastPage(),
                    "per_page" => $property->perPage(),
                ]

            ];

            return response()->json(['response' => "success", 'data' => $response], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    public function getOwnerTotals(Request $request)
    {
        try {
            //code...
            $user_id =  $this->getCurrentLoggedUserBySanctum()->id;
            // $total_referrals =  User::where('referrer_id', $user_id)->where("property_owner_verified", true)->count();
            $toal_properties = Property::where('owner_id', $user_id)->count();
            return response()->json(['response' => 'success', 'message' => 'Totals fetched successfully.', 'data' => ['total_properties' => $toal_properties]]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }
}
