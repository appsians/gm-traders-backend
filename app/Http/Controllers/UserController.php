<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;


class UserController extends Controller
{
    public function userProfile(Request $request)
    {
        return new UserResource($request->user());
        return response()->json([
            'message' => 'Profile fetched successfully',
            'user'    => $request->user(),
        ]);
    }

    public function userDashboard(Request $request)
    {
        return response()->json([
            'message' => 'Welcome to User Dashboard',
            'user'    => $request->user(),
        ]);
    }
}
