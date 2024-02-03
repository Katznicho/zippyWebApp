<?php

namespace App\Http\Controllers;

use App\Mail\AccountCreation;
use App\Mail\UserVerification;
use App\Models\Property;
use App\Models\User;
use App\Traits\MessageTrait;
use App\Traits\UserTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AgentController extends Controller
{
    use UserTrait, MessageTrait;
    //

    public  function  registerPropertyOwner(Request $request)
    {
        try {
            //code...
            //email , phone number, fullname
            $request->validate([
                'email' => 'required|string|email|unique:users,email,except,id',
                'phone_number' => 'required|string|unique:users,phone_number,except,id',
                'name' => 'required|string',
            ]);



            $user_id =  $this->getCurrentLoggedUserBySanctum()->id;
            // Generate a random OTP code
            // $otpCode = 123456;
            $otpCode = random_int(100000, 999999);

            $password = Str::random(8);



            $user = User::create([
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'referrer_id' => $user_id,
                'password' => Hash::make($password),
                'name' => $request->name,
                'role' => config("users.Roles.Property Owner"),
                'otp' => Hash::make($otpCode),
                'otp_send_time' => now(),
            ]);

            try {
                // Send the OTP code to the user's email
                Mail::to($user->email)->send(new UserVerification($user, $otpCode));
            } catch (\Throwable $th) {
                // throw $th;
            }
            $message = "Hello $request->name thank you for registering with zippy as a Property Owner. Your OTP code is $otpCode.";
            $this->sendMessage($request->phone_number, $message);


            if ($user) {
                return response()->json([
                    'response' => 'success',
                    'message' => 'Property Owner created successfully',
                    'user' => $user
                ], 201);
            } else {
                return response()->json([
                    'response' => 'failure',
                    'message' => 'Property Owner not created',
                    'user' => $user
                ], 201);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response' => 'failure', 'message' => $th->getMessage()], 401);
        }
    }



    public  function  verifyPropertyOwnerPhoneNumber(Request $request)
    {
        try {
            $request->validate([
                'phone_number' => 'required|string|exists:users,phone_number',
                'otp' => 'required|size:6',
            ]);
            // Find the user
            $user = User::where('phone_number', $request->phone_number)->first();

            // Check if the OTP code is correct
            if (!Hash::check($request->otp, $user->otp)) {
                return response()->json([
                    'response' => 'failure',
                    'errors' => [
                        'otp' => ['Incorrect OTP. Check your email or phone number for OTP sent to you'],
                    ],
                    'message' => 'Incorrect OTP. Check your email or phone number for OTP sent to you',
                ], 401);
            }

            $password = Str::random(8);

            $role = config("users.Roles.Property Owner");
            try {
                // Send the OTP code to the user's email
                Mail::to($request->email)->send(new AccountCreation($request->name, $password,  config("users.Roles.Property Owner")));
            } catch (\Throwable $th) {
                // throw $th;
                // dd($th);
            }

            $message = "Hello $request->name, your account with  Zippy  as a $role has been created. Please use the following : $password  as your one time password to login in the app 
            If you dont have the app please contact us or download the app from the play store
            <a href='https://play.google.com/store/apps/details?id=com.otp.otp'>https://play.google.com/store/apps/details?id=com.otp.otp</a>";

            $this->sendMessage($request->phone_number, $message);

            // Update the user's email verification status
            $user->update([
                'otp' => null,
                'otp_send_time' => null,
                'email_verified_at' => now(),
                'password' => Hash::make($password),
                'property_owner_verified' => true
            ]);

            return response()->json([
                'response' => 'success',
                'message' => 'Successfully verified email!',
                'user' => $user,
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['response' => 'failure', 'message' => $th->getMessage()], 401);
        }
    }

    public function getRegisterPropertyOwnersByPage(Request $request)
    {
        try {
            $limit = $request->input('limit', 100);
            $page = $request->input('page', 1);
            $sortOrder = $request->input('sort_order', 'desc');

            $user_id =  $this->getCurrentLoggedUserBySanctum()->id;

            $property_owners =  User::orderBy('id', $sortOrder)->where('referrer_id', $user_id)
                ->with('properties')
                ->paginate($limit, ['*'], 'page', $page);

            $response = [
                "data" => $property_owners->items(),
                "pagination" => [
                    "total" => $property_owners->total(),
                    "current_page" => $property_owners->currentPage(),
                    "last_page" => $property_owners->lastPage(),
                    "per_page" => $property_owners->perPage(),
                ]
            ];
            return response()->json(['response' => "success", 'data' => $response], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    public function getAllRegisteredPropertyOwners(Request $request)
    {
        try {
            //code...
            $property_owners =  User::where('role', config('users.Roles.Property Owner'))->where('referrer_id', $this->getCurrentLoggedUserBySanctum()->id)->get();
            return response()->json(["response" => "success", "data" => $property_owners], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
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

            $property = Property::orderBy('id', $sortOrder)->where('agent_id', $user_id)
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

    public function registerPropertyByAgent(Request $request)
    {
        try {
            $user_id =  $this->getCurrentLoggedUserBySanctum()->id;
            //code...
            $request->validate([
                'name' => 'required',
                'description' => 'required',
                'images' => 'required|array',
                'lat' => 'required',
                'long' => 'required',
                'category_id' => 'required',
                'owner_id' => 'required',
                'cover_image' => 'required',
                'number_of_beds' => 'required',
                'number_of_baths' => 'required',
                // 'number_of_rooms' => 'required',
                // 'room_type' => 'required',
                // 'furnishing_status' => 'required',
                'status_id' => 'required',
                'price' => 'required',
                // 'year_built' => 'required',
                'location' => 'required',
                'currency_id' => 'required',
                'payment_period_id' => "required",
                // 'property_size' => 'required',
                'services' => 'required|array',
                'amenities' => 'required|array',
                'is_available' => "required",
                "public_facilities" => "required|array",

            ]);
            // 'zippy_id' => 'required',

            // Get the first 2 letters from the location
            $locationPrefix = strtoupper(substr($request->location, 0, 2));

            // Get the last property stored
            $lastProperty = Property::latest()->first();


            $zippy_id = 'ZPUG' . $locationPrefix . ($lastProperty ? $lastProperty->id + 1 : 1);

            // auto generate zippy_id
            $property = Property::create([
                'name' => $request->name,
                'description' => $request->description,
                'images' => $request->images,
                'lat' => $request->lat,
                'long' => $request->long,
                'agent_id' => $user_id,
                'category_id' => $request->category_id,
                'owner_id' => $request->owner_id,
                'cover_image' => $request->cover_image,
                'number_of_beds' => $request->number_of_beds,
                'number_of_baths' => $request->number_of_baths,
                // 'number_of_rooms' => $request->number_of_rooms,
                // 'room_type' => $request->room_type,
                'furnishing_status' => $request->furnishing_status,
                'status_id' => $request->status_id,
                'public_facilities' => $request->public_facilities,
                'price' => $request->price,
                'year_built' => $request->year_built,
                'location' => $request->location,
                'currency_id' => $request->currency_id,
                'payment_period_id' => $request->payment_period_id,
                'is_available' => $request->is_available,
                'property_size' => $request->property_size,
                'owner' => $request->owner_id,
                'zippy_id' => $zippy_id
            ]);
            if ($property) {
                // add services
                $services = $request->services;
                $property->services()->attach($services);
                // add amenities
                $amenities = $request->amenities;
                $property->amenities()->attach($amenities);

                return response()->json(['response' => "success", 'message' => 'Property created successfully.',  'data' => $property]);
            }
            // return response()->json(['success' => true, 'message' => 'Property created successfully.']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }

    public function getAgentTotals(Request $request)
    {
        try {
            //code...
            $user_id =  $this->getCurrentLoggedUserBySanctum()->id;
            $total_referrals =  User::where('referrer_id', $user_id)->where("property_owner_verified", true)->count();
            $toal_properties = Property::where('agent_id', $user_id)->count();
            return response()->json(['response' => 'success', 'message' => 'Totals fetched successfully.', 'data' => ['total_referrals' => $total_referrals, 'total_properties' => $toal_properties]]);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }
}
