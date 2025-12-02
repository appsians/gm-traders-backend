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
            // return [
            //     'id' => $post->id,
            //     'user' => $post->user,
            //     'description' => $post->description,
            //     'image' => $post->image
            //         ? url('uploads/community/' . $post->image)
            //         : null,
            //     'created_at' => $post->created_at->diffForHumans(),
            // ];

              return [
                'id' => $post->id,
                'description' => $post->description,
                'image' => $post->image
                    ? url('uploads/community/' . $post->image)
                    : null,
                'first_name' => $post->user->first_name ?? 'Unknown User',
                'profile_image' => $post->user && $post->user->profile_image
                    ? url( $post->user->profile_image)
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
            'image' => '',
        ]);



        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/community'), $imageName);
        }

        $post = Community::create([
            'user_id' => Auth::user()->id,
            'description' => $request->description,
            'image' => $imageName,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Post created successfully',
            'data' => [
                'id' => $post->id,

                'description' => $post->description,
                'image' => $post->image ? url('uploads/community/' . $post->image) : null,
            ],
        ], 201);

}

  public function update(Request $request, $id)
    {
        $post = Community::findOrFail($id);

      //  Only owner can update
        // if ($post->user_id !== Auth::id()) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Unauthorized action',
        //     ], 403);
        // }

        $request->validate([
            'description' => 'required|string|max:1000',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update image if provided
        if ($request->hasFile('image')) {
            if ($post->image && File::exists(public_path('uploads/community/' . $post->image))) {
                File::delete(public_path('uploads/community/' . $post->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/community'), $imageName);
            $post->image = $imageName;
        }

        $post->description = $request->description;
        $post->save();

        return response()->json([
            'status' => true,
            'message' => 'Post updated successfully',
            'data' => [
                'id' => $post->id,
                'description' => $post->description,
                'image' => $post->image ? url('uploads/community/' . $post->image) : null,
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

        // Delete image from folder
        if ($post->image && File::exists(public_path('uploads/community/' . $post->image))) {
            File::delete(public_path('uploads/community/' . $post->image));
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
                'description' => $post->description,
                'image' => $post->image
                    ? url('uploads/community/' . $post->image)
                    : null,
                'first_name' => $post->user->first_name ?? 'Unknown User',
                'profile_image' => $post->user && $post->user->profile_image
                    ? url( $post->user->profile_image)
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
        $post = Community::find($id);

        if (!$post) {
            return response()->json(['status' => 'false', 'message' => 'Post not found'], 404);
        }

        return response()->json(['status' => 'true', 'data' => $post]);
    }





}






