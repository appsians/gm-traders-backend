<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{



public function update(Request $request)
{

    Log::info('Registration request: ' , $request->all());
 //   return $request->all();
    $user = Auth::user();
   // $user = User::find(1);

    // $request->validate([
    //     'first_name' => 'nullable|string|max:255',
    //     'last_name'  => 'nullable|string|max:255',
    //     'email'      => 'nullable|email|unique:users,email,' . $user->id,
    //     'farm_name'  => 'nullable|string|max:255',
    // ]);

    $user->update($request->only(['first_name', 'last_name', 'email', 'farm_name' ,'phone']));
     \App\Models\Order::where('user_id', $user->id)
        ->update([
            'name' => $request->first_name,
            'location' => $request->farm_name,
        ]);

    return response()->json([
        'status'  => true,
        'message' => 'Profile updated successfully',
      //  'data' => [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'phone' => $user->phone,
            'referral_code' => $user->referral_code,
            'farm_name' => $user->farm_name,
            'email' => $user->email,
           // 'profile_image' => $user->profile_image ? url($user->profile_image) : null,
       // ],
    ]);
}

public function updateProfileImage(Request $request)
{
   $user = Auth::user();


    $request->validate([
        'profile_image' => 'required|image|max:2048',
    ]);

    // delete old image if exists
    if ($user->profile_image && file_exists(public_path($user->profile_image))) {
        unlink(public_path($user->profile_image));
    }

    $imageName = time() . '.' . $request->profile_image->extension();
    $request->profile_image->move(public_path('uploads/profile'), $imageName);

    $user->profile_image = 'uploads/profile/' . $imageName;
    $user->save();

    return response()->json([
        'status'  => true,
        'message' => 'Profile image updated successfully',
         'profile_image' => url($user->profile_image),
        // 'data' => [
        //     'id' => $user->id,
        //     'profile_image' => url($user->profile_image),
        // ],
    ]);
}

}
