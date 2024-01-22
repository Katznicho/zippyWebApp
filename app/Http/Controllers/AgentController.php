<?php

namespace App\Http\Controllers;

use App\Mail\AccountCreation;
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
            $password = Str::random(8);

            $user = User::create([
                'email' => $request->email,
                'phone_number' => $request->phone_number,
                'referrer_id' => $user_id,
                'password' => Hash::make($password),
                'name ' => $request->name,
                'role' => config("users.Roles.Property Owner"),
            ]);
            if ($user) {
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
}
