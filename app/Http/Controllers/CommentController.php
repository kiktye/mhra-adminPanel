<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Blog $blog)
    {

        $commentAttributes = $request->validate([
            'content' => ['required', 'string', 'max:600'],
        ]);

        $blog->comments()->create([
            'content' => $commentAttributes['content'],
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    /**
     * Like/Unlike a Comment.
     */
    public function like(Comment $comment)
    {
        $user = Auth::user();

        if ($comment->isLikedBy($user)) {
            // if already liked, unlike
            $comment->likedByUsers()->detach($user);
            $comment->decrement('likes');
            $liked = false;
        } else {
            // like
            $comment->likedByUsers()->attach($user);
            $comment->increment('likes');
            $liked = true;
        }

        return response()->json([
            'liked' => $liked,
            'likeCount' => $comment->likes
        ]);
    }
    
    /**
     * Reply to a comment
     */
    public function reply(Request $request, Comment $comment)
    {
        $commentAttributes = $request->validate([
            'content' => ['required', 'string', 'max:600'],
            'blog_id' => ['required', 'exists:blogs,id'],
        ]);

        $comment->replies()->create([
            'content' => $commentAttributes['content'],
            'blog_id' => $commentAttributes['blog_id'],
            'user_id' => Auth::user()->id,
        ]);

        return redirect()->back()->with('success', 'Reply added successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        $commentAttributes = $request->validate([
            'content' => ['required', 'string', 'max:600'],
        ]);

        $comment->update([
            'content' => $commentAttributes['content'],
        ]);

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully!');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore($id)
    {
        $comment = Comment::withTrashed()->findOrFail($id);

        $comment->restore();

        return redirect()->back()->with('success', 'Comment restored successfully!');
    }
}
