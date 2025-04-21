<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        $comment->delete();

        return redirect()->back()->with('success', 'Komentar berhasil dihapus!');
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

