<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function destroy(Comment $comment)
    { 
        if (auth()->id() !== $comment->user_id) {
            abort(403, 'Kamu tidak diizinkan menghapus komentar ini.');
        }

        $comment->delete();
        return back()->with('success', 'Komentar berhasil dihapus.');
        
    }

    public function reply(Request $request, $commentId)
    {
        $request->validate([
            'reply' => 'required|string|max:255',
        ]);

        $comment = Comment::findOrFail($commentId);

        $reply = new Comment();
        $reply->comment = $request->input('reply');
        $reply->photo_id = $comment->photo_id;
        $reply->user_id = auth()->id();
        $reply->parent_id = $comment->id; 
        $reply->save();

        return redirect()->route('admin.dashboard', $comment->photo_id)->with('success', 'Balasan berhasil ditambahkan!');
    }
}

