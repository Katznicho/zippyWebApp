<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\PointUsage;
use App\Models\PropertyNotification;
use App\Models\User;
use App\Models\ZippyAlert;
use App\Traits\MessageTrait;
use App\Traits\UserTrait;
use App\Traits\ZippyAlertTrait;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use UserTrait, MessageTrait, ZippyAlertTrait;
    //
    public function getUserPoints(Request $request)
    {
        try {

            $user_id =  $this->getCurrentLoggedUserBySanctum()->id;
            $user = User::with([
                'pointUsages'
            ])->find($user_id);
            return response()->json(['data' => $user, 'response' => 'success', 'message' => 'User Points fetched successfully.']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response' => 'failure', 'message' => $th->getMessage()]);
        }
    }

    public function fetchUserPointsUsages(Request $request)
    {
        try {
            $user_id =  $this->getCurrentLoggedUserBySanctum()->id;
            // $user = User::find($user_id)->pointUsages;
            $points = PointUsage::where('user_id', $user_id)->get();
            return response()->json(['response' => 'success', 'data' => $points, 'message' => 'User Usage Points fetched successfully.']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response' => 'failure', 'message' => $th->getMessage()]);
        }
    }

    public function loadMoreUserPointsUsages(Request $request)
    {
        try {
            $user_id =  $this->getCurrentLoggedUserBySanctum()->id;
            $points = PointUsage::where('user_id', $user_id)->skip($request->skip)->take($request->take)->get();
            return response()->json(['response' => 'success', 'data' => $points, 'message' => 'User Usage Points fetched successfully.']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response' => 'failure', 'message' => $th->getMessage()]);
        }
    }

    public function createPropertyAlert(Request $request)
    {
        try {

            $user_id =  $this->getCurrentLoggedUserBySanctum()->id;

            //first count the number of alerts a user has
            $total_alerts = ZippyAlert::where('user_id', $user_id)->count();
            if ($total_alerts > 4) {
                return response()->json(['response' => 'failure', 'alert_max' => true, 'message' => "You have reached the maximum number of alerts. You can only have up to 4 alerts."]);
            }
            $user = User::find($user_id);

            $request->validate([
                'services' => 'required|array',
                'amenities' => 'required|array',
                'contact_options' => 'required|array',
                'number_of_bedrooms' => 'required',
                'number_of_bathrooms' => 'required',
                'cost' => 'required',
                'category_id' => 'required',
                'longitude' => 'required',
                'latitude' => 'required',
                'address' => 'required',
            ]);

            $this->zippySearchAlgorithm($request, $user);

            $userAlert =  ZippyAlert::create([
                'user_id' => $user_id,
                'category_id' => $request->category_id,
                'services' => json_encode($request->services),
                'amenities' => json_encode($request->amenities),
                'cost' => $request->cost,
                'contact_options' => json_encode($request->contact_options),
                'number_of_bedrooms' => $request->number_of_bedrooms,
                'number_of_bathrooms' => $request->number_of_bathrooms,
                'is_active' => true,
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'address' => $request->address
            ]);

            $message = "Hello " . $user->name . ",\n\n"  . "Your Zippy Alert has been created.\n\n" . "Regards,\n" . "Zippy Team";
            if ($user->phone_number) {
                $this->sendMessage($user->phone_number, $message);
            }

            return response()->json(['response' => 'success', 'message' => 'Property Alert created successfully.']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response' => 'failure', 'message' => $th->getMessage()]);
        }
    }

    public function deActivateAlert(Request $request)
    {
        try {
            $user_id =  $this->getCurrentLoggedUserBySanctum()->id;
            $user = User::find($user_id);
            $userAlert =  ZippyAlert::where('user_id', $user_id)->where('id', $request->alert_id)->update(['is_active' => false]);

            $message = "Hello " . $user->name . ",\n\n"  . "Your Zippy Alert has been deactivated.\n\n" . "Regards,\n" . "Zippy Team";
            if ($user->phone_number) {
                $this->sendMessage($user->phone_number, $message);
            }
            return response()->json(['response' => 'success', 'message' => 'Property Alert deactivated successfully.']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response' => 'failure', 'message' => $th->getMessage()]);
        }
    }

    public function ActivateAlert(Request $request)
    {
        try {
            $user_id =  $this->getCurrentLoggedUserBySanctum()->id;
            $user = User::find($user_id);
            $userAlert =  ZippyAlert::where('user_id', $user_id)->where('id', $request->alert_id)->update(['is_active' => true]);
            $message = "Hello " . $user->name . ",\n\n"  . "Your Zippy Alert has been deactivated.\n\n" . "Regards,\n" . "Zippy Team";
            if ($user->phone_number) {
                $this->sendMessage($user->phone_number, $message);
            }
            return response()->json(['response' => 'success', 'message' => 'Property Alert activated successfully.']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response' => 'failure', 'message' => $th->getMessage()]);
        }
    }

    public function getUserAlerts(Request $request)
    {
        try {
            $user_id =  $this->getCurrentLoggedUserBySanctum()->id;
            $userAlerts = ZippyAlert::where('user_id', $user_id)
                ->with(['category', 'user'])
                ->get();
            return response()->json(['alerts' => $userAlerts, 'response' => 'success', 'message' => 'User Alerts fetched successfully.']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response' => 'failure', 'message' => $th->getMessage()]);
        }
    }

    public function getUserNotifications(Request $request)
    {
        try {
            $limit = $request->input('limit', 100);
            $page = $request->input('page', 1);
            $sortOrder = $request->input('sort_order', 'desc');
            $user_id = $this->getCurrentLoggedUserBySanctum()->id;

            // Add a status filter if 'status' is provided in the request
            $status = $request->input('status');
            $paymentQuery = PropertyNotification::where('user_id', $user_id);

            if (!empty($status)) {
                $paymentQuery->where('status', $status);
            }

            $res = $paymentQuery->orderBy('id', $sortOrder)->with([
                'user', 'property',
            ])->paginate($limit, ['*'], 'page', $page);

            $response = [
                'data' => $res->items(),
                'pagination' => [
                    'current_page' => $res->currentPage(),
                    'per_page' => $limit,
                    'total' => $res->total(),
                ],
            ];

            return response()->json(['success' => true, 'data' => $response]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }


    public function createUserBooking(Request $request)
    {
        try {
            $request->validate([
                'property_id' => 'required',
                'total_price' => 'required',
            ]);
            $user_id =  $this->getCurrentLoggedUserBySanctum()->id;
            Booking::create([
                'user_id' => $user_id,
                'property_id' => $request->property_id,
                'total_price' => $request->total_price,
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    public function getUserBookings(Request $request)
    {
        try {
            $limit = $request->input('limit', 100);
            $page = $request->input('page', 1);
            $user_id =  $this->getCurrentLoggedUserBySanctum()->id;

            $bookingQuery = Booking::where('user_id', $user_id)->with(['property', 'user']);

            $bookings = $bookingQuery->paginate($limit, ['*'], 'page', $page);

            $response = [
                'data' => $bookings->items(),
                'pagination' => [
                    'current_page' => $bookings->currentPage(),
                    'per_page' => $limit,
                    'total' => $bookings->total(),
                ],
            ];

            return response()->json(['success' => true, 'data' => $response]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }
}
