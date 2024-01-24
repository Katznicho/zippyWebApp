<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\Category;
use App\Models\Service;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
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

    public function  getAllCategories(Request $request)
    {
        try {
            //code...
            $categories =  Category::all();
            return response()->json(
                [
                    'response' => "success",
                    "data" => $categories
                ],
                201
            );
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response' => 'failure', 'message' => $th->getMessage()]);
        }
    }
}
