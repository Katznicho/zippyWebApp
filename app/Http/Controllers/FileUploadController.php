<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\UserTrait;
use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    use UserTrait;
    //
    public function uploadIdImages(Request $request)
    {
        $request->validate(['cover_image' => 'required', "images" => "required|array|min:4|max:4", "images.*" => "required"]);

        // Store all ID images under one folder
        $destination_path = 'public/properties';

        // Store the IDs in their designated folder
        // $one = $request->frontID->store($destination_path);
        // $two = $request->backID->store($destination_path);

        $one = $request->images[0]->store($destination_path);
        $two = $request->images[1]->store($destination_path);
        $three = $request->images[2]->store($destination_path);
        $four = $request->images[3]->store($destination_path);

        $cover_image = $request->cover_image->store($destination_path);


        if (!$cover_image) {
            return response(['message' => 'failure', 'error' => 'Failed to upload cover image'], 400);
        }

        if (!$one || !$two || !$three || !$four) {
            return response(['message' => 'failure', 'error' => 'Failed to upload ID images'], 400);
        }

        // Return the name of the images
        $cover_image = str_replace($destination_path . '/', '', $cover_image);
        $one = str_replace($destination_path . '/', '', $one);
        $two = str_replace($destination_path . '/', '', $two);
        $three = str_replace($destination_path . '/', '', $three);
        $four = str_replace($destination_path . '/', '', $four);

        // Return only the ID name
        return response()->json(['message' => 'success', 'data' => ['cover_image' => $cover_image, 'one' => $one, 'two' => $two, 'three' => $three, 'four' => $four]], 201);
    }

    public function profileUpload(Request $request)
    {
        $user_id = $this->getCurrentLoggedUserBySanctum()->id;
        $request->validate(['profile_pic' => 'required']);
        // Store all ID images under one folder
        $destination_path = 'public/profile';
        //store the in a folder
        $profile_picture = $request->profile_pic->store($destination_path);
        //return the name of the images
        $pic_path = str_replace($destination_path . '/', '', $profile_picture);
        //update the user avatar
        User::where('id', $user_id)->update(['avatar' => $pic_path]);
        return response()->json(['message' => 'success', 'data' => ['profile_pic' => $pic_path]], 201);
    }
}
