<?php

namespace App\Http\Controllers\Api;
use App\Models\Community;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\User;


class CommunityController extends Controller
{
     public function index()
    {
    $user = Auth::user();
//  $user = User::find(15);

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'User not found.',
            'data' => null,
        ], 404);
    }

    $posts = Community::with('user:id,first_name,email,profile_image')
        ->where('user_id', $user->id)
        ->latest()
        ->get()
        ->map(function ($post) {
            return [
                'id' => $post->id,
                'user_id' => $post->user_id,
                'description' => $post->description,
                'before_image' => $post->before_image ? url('uploads/community/' . $post->before_image) : null,
                'after_image' => $post->after_image ? url('uploads/community/' . $post->after_image) : null,
                'first_name' => $post->user->first_name ?? 'Unknown User',
                'profile_image' => $post->user && $post->user->profile_image
                    ? url($post->user->profile_image)
                    : null,
                'created_at' => $post->created_at->format('Y-m-d H:i:s'),
            ];
        });

    return response()->json([
        'status' => true,
         'message' => 'success.',
        'data' => $posts,
    ], 200);
}

      public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|max:1000',
            'before_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:5120',
            'after_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        $beforeImageName = null;
        $afterImageName = null;

        // Handle before image upload
        if ($request->hasFile('before_image')) {
            $beforeImageName = time() . '_before_' . uniqid() . '.' . $request->before_image->extension();
            $request->before_image->move(public_path('uploads/community'), $beforeImageName);
        }

        // Handle after image upload
        if ($request->hasFile('after_image')) {
            $afterImageName = time() . '_after_' . uniqid() . '.' . $request->after_image->extension();
            $request->after_image->move(public_path('uploads/community'), $afterImageName);
        }

        $post = Community::create([
            'user_id' => Auth::user()->id,
            'description' => $request->description,
            'before_image' => $beforeImageName,
            'after_image' => $afterImageName,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Post created successfully',
            'data' => [
                'id' => $post->id,
                'user_id' => $post->user_id,
                'description' => $post->description,
                'before_image' => $beforeImageName ? url('uploads/community/' . $beforeImageName) : null,
                'after_image' => $afterImageName ? url('uploads/community/' . $afterImageName) : null,
                'created_at' => $post->created_at->format('Y-m-d H:i:s'),
            ],
        ], 201);
}

  public function update(Request $request, $id)
    {
        $post = Community::findOrFail($id);

        $request->validate([
            'description' => 'required|string|max:1000',
            'before_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
            'after_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        // Handle before image update
        if ($request->hasFile('before_image')) {
            // Delete old before image
            if ($post->before_image && File::exists(public_path('uploads/community/' . $post->before_image))) {
                File::delete(public_path('uploads/community/' . $post->before_image));
            }
            // Upload new before image
            $beforeImageName = time() . '_before_' . uniqid() . '.' . $request->before_image->extension();
            $request->before_image->move(public_path('uploads/community'), $beforeImageName);
            $post->before_image = $beforeImageName;
        }

        // Handle after image update
        if ($request->hasFile('after_image')) {
            // Delete old after image
            if ($post->after_image && File::exists(public_path('uploads/community/' . $post->after_image))) {
                File::delete(public_path('uploads/community/' . $post->after_image));
            }
            // Upload new after image
            $afterImageName = time() . '_after_' . uniqid() . '.' . $request->after_image->extension();
            $request->after_image->move(public_path('uploads/community'), $afterImageName);
            $post->after_image = $afterImageName;
        }

        $post->description = $request->description;
        $post->save();

        return response()->json([
            'status' => true,
            'message' => 'Post updated successfully',
            'data' => [
                'id' => $post->id,
                'user_id' => $post->user_id,
                'description' => $post->description,
                'before_image' => $post->before_image ? url('uploads/community/' . $post->before_image) : null,
                'after_image' => $post->after_image ? url('uploads/community/' . $post->after_image) : null,
                'updated_at' => $post->updated_at->format('Y-m-d H:i:s'),
            ],
        ]);
    }
   public function destroy($id)
    {
        $post = Community::findOrFail($id);

        // Only owner can delete
        // if ($post->user_id !== Auth::id()) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Unauthorized action',
        //     ], 403);
        // }

        // Delete before image
        if ($post->before_image && File::exists(public_path('uploads/community/' . $post->before_image))) {
            File::delete(public_path('uploads/community/' . $post->before_image));
        }

        // Delete after image
        if ($post->after_image && File::exists(public_path('uploads/community/' . $post->after_image))) {
            File::delete(public_path('uploads/community/' . $post->after_image));
        }

        $post->delete();
        if(!$post)
        {


         return response()->json([
            'status' => false,
            'message' => 'Post not found',
        ]);
    }
    else
    {
         return response()->json([
            'status' => true,
            'message' => 'Post deleted successfully',
        ]);

    }
    }

    public function allpostget()
    {



           $posts = Community::with('user')
               ->orderBy('id', 'desc')
    ->get();

    if ($posts->isNotEmpty()) {


            $data = $posts->map(function ($post) {
                return [
                    'id' => $post->id,
                    'user_id' => $post->user_id,
                    'description' => $post->description,
                    'before_image' => $post->before_image ? url('uploads/community/' . $post->before_image) : null,
                    'after_image' => $post->after_image ? url('uploads/community/' . $post->after_image) : null,
                    'first_name' => $post->user->first_name ?? 'Unknown User',
                    'profile_image' => $post->user && $post->user->profile_image
                        ? url($post->user->profile_image)
                        : null,
                    'created_at' => $post->created_at->format('Y-m-d H:i:s'),
                ];
            });



        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $data, // ✅ directly send posts array here
        ]);
    }

    return response()->json([
        'status' => false,
        'message' => 'No posts found',
        'data' => [], // keep consistent structure
    ]);
    }

           public function show($id)
    {
        $post = Community::with('user')->find($id);

        if (!$post) {
            return response()->json([
                'status' => false,
                'message' => 'Post not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Post retrieved successfully',
            'data' => [
                'id' => $post->id,
                'user_id' => $post->user_id,
                'description' => $post->description,
                'before_image' => $post->before_image ? url('uploads/community/' . $post->before_image) : null,
                'after_image' => $post->after_image ? url('uploads/community/' . $post->after_image) : null,
                'first_name' => $post->user->first_name ?? 'Unknown User',
                'profile_image' => $post->user && $post->user->profile_image
                    ? url($post->user->profile_image)
                    : null,
                'created_at' => $post->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $post->updated_at->format('Y-m-d H:i:s'),
            ]
        ]);
    }





}






