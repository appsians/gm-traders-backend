<?php

namespace App\Http\Controllers\Api;
use App\Models\Community;
use App\Models\PostLike;
use App\Models\PostComment;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\User;


class CommunityController extends Controller
{
    /**
     * Helper method to format likes data for a post
     */
    private function formatLikes($post, $currentUserId)
    {
        $likeCount = $post->likes()->count();
        $isLiked = $post->likes()->where('user_id', $currentUserId)->exists();
        
        // Get up to 10 most recent likes with user info
        $recentLikes = $post->likes()
            ->with('user:id,first_name,last_name,profile_image')
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($like) {
                return [
                    'id' => $like->id,
                    'user_id' => $like->user_id,
                    'first_name' => $like->user->first_name ?? 'Unknown',
                    'last_name' => $like->user->last_name ?? '',
                    'profile_image' => $like->user && $like->user->profile_image
                        ? url($like->user->profile_image)
                        : null,
                ];
            });

        return [
            'count' => $likeCount,
            'is_liked' => $isLiked,
            'liked_by' => $recentLikes->toArray(),
        ];
    }

    /**
     * Helper method to format comments data for a post
     */
    private function formatComments($post, $limit = 5)
    {
        $commentCount = $post->comments()->count();
        
        // Get up to $limit most recent comments with user info
        $recentComments = $post->comments()
            ->with('user:id,first_name,last_name,profile_image')
            ->latest()
            ->limit($limit)
            ->get()
            ->map(function ($comment) {
                return [
                    'id' => $comment->id,
                    'post_id' => $comment->post_id,
                    'user_id' => $comment->user_id,
                    'first_name' => $comment->user->first_name ?? 'Unknown',
                    'last_name' => $comment->user->last_name ?? '',
                    'profile_image' => $comment->user && $comment->user->profile_image
                        ? url($comment->user->profile_image)
                        : null,
                    'comment' => $comment->comment,
                    'created_at' => $comment->created_at->toIso8601String(),
                    'updated_at' => $comment->updated_at->toIso8601String(),
                ];
            });

        return [
            'count' => $commentCount,
            'data' => $recentComments->toArray(),
        ];
    }

     public function index()
    {
    $user = Auth::user();

    if (!$user) {
        return response()->json([
            'status' => false,
            'message' => 'User not found.',
            'data' => null,
        ], 404);
    }

    $posts = Community::with(['user:id,first_name,last_name,email,profile_image', 'likes.user', 'comments.user'])
        ->where('user_id', $user->id)
        ->latest()
        ->get()
        ->map(function ($post) use ($user) {
            return [
                'id' => $post->id,
                'user_id' => $post->user_id,
                'first_name' => $post->user->first_name ?? 'Unknown User',
                'last_name' => $post->user->last_name ?? '',
                'profile_image' => $post->user && $post->user->profile_image
                    ? url($post->user->profile_image)
                    : null,
                'description' => $post->description,
                'image' => $post->before_image ? url('uploads/community/' . $post->before_image) : null,
                'before_image' => $post->before_image ? url('uploads/community/' . $post->before_image) : null,
                'after_image' => $post->after_image ? url('uploads/community/' . $post->after_image) : null,
                'created_at' => $post->created_at->toIso8601String(),
                'updated_at' => $post->updated_at->toIso8601String(),
                'likes' => $this->formatLikes($post, $user->id),
                'comments' => $this->formatComments($post, 5),
            ];
        });

    return response()->json([
        'status' => true,
        'message' => 'Posts retrieved successfully',
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
        $user = Auth::user();
        $currentUserId = $user ? $user->id : null;

        $posts = Community::with(['user:id,first_name,last_name,email,profile_image', 'likes.user', 'comments.user'])
            ->orderBy('id', 'desc')
            ->get();

        if ($posts->isNotEmpty()) {
            $data = $posts->map(function ($post) use ($currentUserId) {
                return [
                    'id' => $post->id,
                    'user_id' => $post->user_id,
                    'first_name' => $post->user->first_name ?? 'Unknown User',
                    'last_name' => $post->user->last_name ?? '',
                    'profile_image' => $post->user && $post->user->profile_image
                        ? url($post->user->profile_image)
                        : null,
                    'description' => $post->description,
                    'image' => $post->before_image ? url('uploads/community/' . $post->before_image) : null,
                    'before_image' => $post->before_image ? url('uploads/community/' . $post->before_image) : null,
                    'after_image' => $post->after_image ? url('uploads/community/' . $post->after_image) : null,
                    'created_at' => $post->created_at->toIso8601String(),
                    'updated_at' => $post->updated_at->toIso8601String(),
                    'likes' => $this->formatLikes($post, $currentUserId ?? 0),
                    'comments' => $this->formatComments($post, 5),
                ];
            });

            return response()->json([
                'status' => true,
                'message' => 'Posts retrieved successfully',
                'data' => $data,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Posts retrieved successfully',
            'data' => [],
        ]);
    }

           public function show($id)
    {
        $user = Auth::user();
        $currentUserId = $user ? $user->id : null;

        $post = Community::with(['user:id,first_name,last_name,email,profile_image', 'likes.user', 'comments.user'])->find($id);

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
                'first_name' => $post->user->first_name ?? 'Unknown User',
                'last_name' => $post->user->last_name ?? '',
                'profile_image' => $post->user && $post->user->profile_image
                    ? url($post->user->profile_image)
                    : null,
                'description' => $post->description,
                'image' => $post->before_image ? url('uploads/community/' . $post->before_image) : null,
                'before_image' => $post->before_image ? url('uploads/community/' . $post->before_image) : null,
                'after_image' => $post->after_image ? url('uploads/community/' . $post->after_image) : null,
                'created_at' => $post->created_at->toIso8601String(),
                'updated_at' => $post->updated_at->toIso8601String(),
                'likes' => $this->formatLikes($post, $currentUserId ?? 0),
                'comments' => $this->formatComments($post, 5),
            ]
        ]);
    }

    /**
     * Like/Unlike a post
     * POST /post/{post_id}/like
     */
    public function likePost($postId)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        $post = Community::find($postId);

        if (!$post) {
            return response()->json([
                'status' => false,
                'message' => 'Post not found',
            ], 404);
        }

        $existingLike = PostLike::where('post_id', $postId)
            ->where('user_id', $user->id)
            ->first();

        if ($existingLike) {
            // Unlike the post
            $existingLike->delete();
            $isLiked = false;
            $message = 'Post unliked successfully';
        } else {
            // Like the post
            PostLike::create([
                'post_id' => $postId,
                'user_id' => $user->id,
            ]);
            $isLiked = true;
            $message = 'Post liked successfully';
        }

        $likeCount = $post->likes()->count();

        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => [
                'post_id' => (int) $postId,
                'is_liked' => $isLiked,
                'like_count' => $likeCount,
            ],
        ], 200);
    }

    /**
     * Get all comments for a post with pagination
     * GET /post/{post_id}/comments
     */
    public function getComments($postId, Request $request)
    {
        $post = Community::find($postId);

        if (!$post) {
            return response()->json([
                'status' => false,
                'message' => 'Post not found',
            ], 404);
        }

        $perPage = $request->input('per_page', 20);
        $page = $request->input('page', 1);

        $comments = PostComment::with('user:id,first_name,last_name,profile_image')
            ->where('post_id', $postId)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        $formattedComments = $comments->map(function ($comment) {
            return [
                'id' => $comment->id,
                'post_id' => $comment->post_id,
                'user_id' => $comment->user_id,
                'first_name' => $comment->user->first_name ?? 'Unknown',
                'last_name' => $comment->user->last_name ?? '',
                'profile_image' => $comment->user && $comment->user->profile_image
                    ? url($comment->user->profile_image)
                    : null,
                'comment' => $comment->comment,
                'created_at' => $comment->created_at->toIso8601String(),
                'updated_at' => $comment->updated_at->toIso8601String(),
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Comments retrieved successfully',
            'data' => [
                'comments' => $formattedComments,
                'total' => $comments->total(),
                'current_page' => $comments->currentPage(),
                'per_page' => $comments->perPage(),
                'last_page' => $comments->lastPage(),
            ],
        ], 200);
    }

    /**
     * Add a comment to a post
     * POST /post/{post_id}/comment
     */
    public function addComment($postId, Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        $post = Community::find($postId);

        if (!$post) {
            return response()->json([
                'status' => false,
                'message' => 'Post not found',
            ], 404);
        }

        $request->validate([
            'comment' => 'required|string|min:1|max:1000',
        ], [
            'comment.required' => 'The comment field is required.',
            'comment.string' => 'The comment must be a string.',
            'comment.min' => 'The comment must be at least 1 character.',
            'comment.max' => 'The comment may not be greater than 1000 characters.',
        ]);

        $comment = PostComment::create([
            'post_id' => $postId,
            'user_id' => $user->id,
            'comment' => $request->comment,
        ]);

        // Load user relationship
        $comment->load('user:id,first_name,last_name,profile_image');

        return response()->json([
            'status' => true,
            'message' => 'Comment added successfully',
            'data' => [
                'id' => $comment->id,
                'post_id' => $comment->post_id,
                'user_id' => $comment->user_id,
                'first_name' => $comment->user->first_name ?? 'Unknown',
                'last_name' => $comment->user->last_name ?? '',
                'profile_image' => $comment->user && $comment->user->profile_image
                    ? url($comment->user->profile_image)
                    : null,
                'comment' => $comment->comment,
                'created_at' => $comment->created_at->toIso8601String(),
                'updated_at' => $comment->updated_at->toIso8601String(),
            ],
        ], 200);
    }

    /**
     * Delete a comment
     * DELETE /comment/{comment_id}
     */
    public function deleteComment($commentId)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        $comment = PostComment::find($commentId);

        if (!$comment) {
            return response()->json([
                'status' => false,
                'message' => 'Comment not found or unauthorized',
            ], 404);
        }

        // Check if user owns the comment
        if ($comment->user_id !== $user->id) {
            return response()->json([
                'status' => false,
                'message' => 'Comment not found or unauthorized',
            ], 403);
        }

        $comment->delete();

        return response()->json([
            'status' => true,
            'message' => 'Comment deleted successfully',
        ], 200);
    }





}






